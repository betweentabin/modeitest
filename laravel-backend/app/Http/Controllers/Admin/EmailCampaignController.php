<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailCampaign;
use App\Models\EmailRecipient;
use App\Models\MailGroupMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\EmailAttachment;

class EmailCampaignController extends Controller
{
    public function index(Request $request)
    {
        $query = EmailCampaign::query();
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }
        $campaigns = $query->orderBy('created_at', 'desc')->paginate($request->get('per_page', 20));
        return response()->json(['success' => true, 'data' => $campaigns]);
    }

    public function show(Request $request, $id)
    {
        $campaign = EmailCampaign::withCount([
            'recipients as total_recipients',
            'recipients as sent_count' => function ($q) { $q->where('status', 'sent'); },
            'recipients as failed_count' => function ($q) { $q->where('status', 'failed'); },
            'recipients as pending_count' => function ($q) { $q->where('status', 'pending'); },
        ])->findOrFail($id);

        $recipientsQuery = EmailRecipient::where('campaign_id', $campaign->id)
            ->select('id', 'email', 'member_id', 'status', 'sent_at', 'error')
            ->orderBy('id', 'asc');

        if ($request->filled('status')) {
            $recipientsQuery->where('status', $request->get('status'));
        }

        $perPage = (int) $request->get('per_page', 50);
        $recipients = $recipientsQuery->paginate($perPage);

        return response()->json(['success' => true, 'data' => [
            'campaign' => $campaign,
            'recipients' => $recipients,
        ]]);
    }

    public function resendRecipient($id, $recipientId)
    {
        $campaign = EmailCampaign::findOrFail($id);
        $recipient = EmailRecipient::where('campaign_id', $campaign->id)->where('id', $recipientId)->firstOrFail();

        // Reset to pending for resend
        $recipient->update([
            'status' => 'pending',
            'sent_at' => null,
            'error' => null,
        ]);

        // Re-dispatch sending for this recipient
        \App\Jobs\SendCampaignEmailToRecipient::dispatch($recipient->id);

        return response()->json(['success' => true]);
    }

    public function resendFailed($id)
    {
        $campaign = EmailCampaign::findOrFail($id);
        EmailRecipient::where('campaign_id', $campaign->id)->where('status', 'failed')->update([
            'status' => 'pending',
            'sent_at' => null,
            'error' => null,
        ]);

        // Re-dispatch campaign send for pending recipients
        \App\Jobs\SendEmailCampaignJob::dispatch($campaign->id);

        return response()->json(['success' => true]);
    }

    // Templates: list
    public function templates()
    {
        $templates = EmailCampaign::where('is_template', true)
            ->orderBy('updated_at', 'desc')
            ->select('id','subject','updated_at')
            ->get();
        return response()->json(['success' => true, 'data' => $templates]);
    }

    public function markTemplate($id)
    {
        $c = EmailCampaign::findOrFail($id);
        $c->update(['is_template' => true]);
        return response()->json(['success' => true]);
    }

    public function unmarkTemplate($id)
    {
        $c = EmailCampaign::findOrFail($id);
        $c->update(['is_template' => false]);
        return response()->json(['success' => true]);
    }

    public function createFromTemplate($id)
    {
        // same behavior as duplicate
        return $this->duplicate($id);
    }

    // Duplicate campaign (content + attachments; recipients are not copied)
    public function duplicate($id)
    {
        $orig = EmailCampaign::with('attachments')->findOrFail($id);
        $copy = EmailCampaign::create([
            'subject' => $orig->subject,
            'body_html' => $orig->body_html,
            'body_text' => $orig->body_text,
            'status' => 'draft',
            'created_by' => optional(request()->user())->id,
        ]);

        foreach ($orig->attachments as $att) {
            EmailAttachment::create([
                'campaign_id' => $copy->id,
                'disk' => $att->disk,
                'path' => $att->path,
                'filename' => $att->filename,
                'mime' => $att->mime,
                'size' => $att->size,
            ]);
        }

        return response()->json(['success' => true, 'data' => $copy], 201);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:500',
            'body_html' => 'nullable|string',
            'body_text' => 'nullable|string',
            'groups' => 'array',
            'groups.*' => 'integer|exists:mail_groups,id',
            'extra_emails' => 'array',
            'extra_emails.*' => 'email',
        ]);

        return DB::transaction(function () use ($validated, $request) {
            $campaign = EmailCampaign::create([
                'subject' => $validated['subject'],
                'body_html' => $validated['body_html'] ?? null,
                'body_text' => $validated['body_text'] ?? null,
                'status' => 'draft',
                'created_by' => optional($request->user())->id,
            ]);

            $emails = collect();

            // From groups
            if (!empty($validated['groups'])) {
                $memberIds = MailGroupMember::whereIn('group_id', $validated['groups'])->pluck('member_id')->unique();
                if ($memberIds->isNotEmpty()) {
                    $rows = DB::table('members')->whereIn('id', $memberIds)->pluck('email', 'id');
                    foreach ($rows as $memberId => $email) {
                        if ($email) {
                            $emails->push(['email' => $email, 'member_id' => $memberId]);
                        }
                    }
                }
            }

            // Extra emails
            if (!empty($validated['extra_emails'])) {
                foreach ($validated['extra_emails'] as $email) {
                    $emails->push(['email' => $email, 'member_id' => null]);
                }
            }

            // Deduplicate by email
            $deduped = $emails->unique('email');

            foreach ($deduped as $row) {
                EmailRecipient::create([
                    'campaign_id' => $campaign->id,
                    'email' => $row['email'],
                    'member_id' => $row['member_id'],
                    'status' => 'pending',
                ]);
            }

            return response()->json(['success' => true, 'data' => $campaign], 201);
        });
    }

    public function preview($id)
    {
        $campaign = EmailCampaign::findOrFail($id);
        return response()->json(['success' => true, 'data' => ['body_html' => $campaign->body_html]]);
    }

    public function schedule(Request $request, $id)
    {
        $data = $request->validate([
            'scheduled_at' => 'required|date',
        ]);

        $campaign = EmailCampaign::findOrFail($id);
        $campaign->update([
            'scheduled_at' => $data['scheduled_at'],
            'status' => 'scheduled',
        ]);

        return response()->json(['success' => true, 'data' => $campaign]);
    }

    public function sendNow($id)
    {
        $campaign = EmailCampaign::findOrFail($id);
        $campaign->update(['status' => 'sending']);

        \App\Jobs\SendEmailCampaignJob::dispatch($campaign->id);

        return response()->json(['success' => true, 'message' => '送信キューに投入しました']);
    }

    // Attachments: list
    public function attachments($id)
    {
        $campaign = EmailCampaign::findOrFail($id);
        $atts = $campaign->attachments()->orderBy('id', 'asc')->get();
        return response()->json(['success' => true, 'data' => $atts]);
    }

    // Attachments: upload
    public function uploadAttachment(Request $request, $id)
    {
        $campaign = EmailCampaign::findOrFail($id);
        $request->validate([
            'attachment' => 'required|file|max:10240', // 10MB
        ]);
        $file = $request->file('attachment');
        $disk = env('MAIL_ATTACHMENT_DISK', 'public');
        $path = $file->store('email_attachments/'.$campaign->id, $disk);
        $att = EmailAttachment::create([
            'campaign_id' => $campaign->id,
            'disk' => $disk,
            'path' => $path,
            'filename' => $file->getClientOriginalName(),
            'mime' => $file->getClientMimeType(),
            'size' => $file->getSize(),
        ]);
        return response()->json(['success' => true, 'data' => $att], 201);
    }

    // Attachments: delete
    public function deleteAttachment($id, $attachmentId)
    {
        $campaign = EmailCampaign::findOrFail($id);
        $att = EmailAttachment::where('campaign_id', $campaign->id)->where('id', $attachmentId)->firstOrFail();
        Storage::disk($att->disk)->delete($att->path);
        $att->delete();
        return response()->json(['success' => true]);
    }
}
