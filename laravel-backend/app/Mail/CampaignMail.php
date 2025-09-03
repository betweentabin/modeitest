<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CampaignMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $subjectLine,
        public ?string $bodyHtml = null,
        public ?string $bodyText = null,
    ) {}

    public function build(): self
    {
        $mail = $this->subject($this->subjectLine);

        // Prefer HTML body when available
        if ($this->bodyHtml) {
            $mail->html($this->bodyHtml);
            if ($this->bodyText) {
                $mail->text('emails.plain', ['bodyText' => $this->bodyText]);
            }
        } elseif ($this->bodyText) {
            $mail->text('emails.plain', ['bodyText' => $this->bodyText]);
        } else {
            $mail->text('emails.plain', ['bodyText' => '']);
        }

        return $mail;
    }
}

