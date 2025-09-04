<?php

namespace App\Jobs;

use App\Mail\CampaignMail;
use App\Models\EmailCampaign;
use App\Models\EmailAttachment;
use App\Models\EmailRecipient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendCampaignEmailToRecipient implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 60;
    public int $tries = 3;
    public $backoff = [60, 300, 900]; // 1m, 5m, 15m

    public function __construct(public int $recipientId)
    {
        $this->onQueue('default');
    }

    public function handle(): void
    {
        $recipient = EmailRecipient::find($this->recipientId);
        if (!$recipient) {
            return;
        }

        // Double-check current state
        if ($recipient->status !== 'pending') {
            return;
        }

        $campaign = EmailCampaign::find($recipient->campaign_id);
        if (!$campaign) {
            $recipient->update(['status' => 'failed', 'error' => 'Campaign not found']);
            return;
        }

        $dryRun = filter_var(env('MAIL_DRY_RUN', false), FILTER_VALIDATE_BOOLEAN);

        try {
            if (!$dryRun) {
                $attachments = EmailAttachment::where('campaign_id', $recipient->campaign_id)
                    ->get(['disk','path','filename'])
                    ->map(fn($a) => ['disk' => $a->disk, 'path' => $a->path, 'filename' => $a->filename])
                    ->toArray();
                $mailable = new CampaignMail(
                    subjectLine: $campaign->subject,
                    bodyHtml: $campaign->body_html,
                    bodyText: $campaign->body_text,
                    attachmentsMeta: $attachments,
                );

                Mail::to($recipient->email)->send($mailable);
            } else {
                Log::info('[MAIL_DRY_RUN] Skipping send', [
                    'recipient_id' => $recipient->id,
                    'email' => $recipient->email,
                    'campaign_id' => $campaign->id,
                ]);
            }

            $recipient->update([
                'status' => 'sent',
                'sent_at' => now(),
                'error' => null,
            ]);

            // If no more pending recipients and no failures remain, close campaign
            $pending = EmailRecipient::where('campaign_id', $recipient->campaign_id)->where('status', 'pending')->count();
            if ($pending === 0) {
                $failed = EmailRecipient::where('campaign_id', $recipient->campaign_id)->where('status', 'failed')->count();
                if ($failed === 0) {
                    EmailCampaign::where('id', $recipient->campaign_id)->update(['status' => 'sent']);
                }
            }
        } catch (\Throwable $e) {
            // Mark as failed; let retry attempts handle transient issues
            $recipient->update([
                'status' => 'failed',
                'error' => substr($e->getMessage(), 0, 1000),
            ]);
            // Rethrow to trigger retry/backoff
            throw $e;
        }
    }
}
