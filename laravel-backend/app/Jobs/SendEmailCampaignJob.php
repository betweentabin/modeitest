<?php

namespace App\Jobs;

use App\Models\EmailCampaign;
use App\Models\EmailRecipient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmailCampaignJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 120;

    public function __construct(public int $campaignId) {}

    public function handle(): void
    {
        $campaign = EmailCampaign::find($this->campaignId);
        if (!$campaign) return;

        $campaign->update(['status' => 'sending']);

        EmailRecipient::where('campaign_id', $campaign->id)
            ->where('status', 'pending')
            ->chunkById(500, function ($recipients) {
                foreach ($recipients as $recipient) {
                    // 実送信処理は未実装（メールドライバ設定に依存）
                    $recipient->update([
                        'status' => 'sent',
                        'sent_at' => now(),
                    ]);
                }
            });

        $pending = EmailRecipient::where('campaign_id', $campaign->id)->where('status', 'pending')->count();
        $campaign->update(['status' => $pending > 0 ? 'sending' : 'sent']);
    }
}

