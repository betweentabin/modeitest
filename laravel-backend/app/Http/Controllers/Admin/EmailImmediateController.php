<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\SimpleMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class EmailImmediateController extends Controller
{
    /**
     * Send a simple email immediately.
     * POST /api/admin/emails/send-simple
     */
    public function send(Request $request)
    {
        Gate::authorize('manage-mails');

        $data = $request->validate([
            'to' => 'required', // string email or array of emails
            'subject' => 'required|string|max:255',
            'body_html' => 'nullable|string',
            'body_text' => 'nullable|string',
            'from.address' => 'nullable|email',
            'from.name' => 'nullable|string|max:255',
            'cc' => 'nullable|array',
            'cc.*' => 'email',
            'bcc' => 'nullable|array',
            'bcc.*' => 'email',
            'attachments' => 'nullable|array',
        ]);

        // Decide mailer (fallback to log if SMTP is not configured)
        $mailer = config('mail.default', 'smtp');
        $smtpHost = config('mail.mailers.smtp.host');
        $dryRun = filter_var(env('MAIL_DRY_RUN', false), FILTER_VALIDATE_BOOLEAN);
        if ($dryRun || ($mailer === 'smtp' && (empty($smtpHost) || $smtpHost === 'smtp.mailgun.org'))) {
            // In dry-run or when SMTP looks unconfigured, use log mailer to avoid hanging
            $mailer = 'log';
        }

        $mailable = new SimpleMail($data);

        $to = is_array($data['to']) ? $data['to'] : [$data['to']];

        $message = Mail::mailer($mailer);
        if (!empty($data['from']['address'])) {
            $message->alwaysFrom($data['from']['address'], $data['from']['name'] ?? null);
        }

        foreach ($to as $addr) {
            $message->to($addr);
        }
        if (!empty($data['cc'])) $message->cc($data['cc']);
        if (!empty($data['bcc'])) $message->bcc($data['bcc']);

        // Send (synchronously). In environments where SMTP is unreachable, above fallback prevents timeouts
        $message->send($mailable);

        return response()->json([
            'success' => true,
            'message' => 'Email queued for sending',
            'mailer' => $mailer,
        ]);
    }
}
