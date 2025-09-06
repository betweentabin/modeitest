<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageContent;

class FaqPageJsonSeeder extends Seeder
{
    public function run(): void
    {
        $key = 'faq';

        $texts = [
            'page_title' => 'よくあるご質問',
            'page_subtitle' => 'FAQ',
        ];

        // デフォルトFAQ（フロントの静的デフォルトと整合）
        $faqs = [
            [
                'category' => 'service',
                'question' => '貴社にとってどんなサービスが提供されますか？',
                'answer' => '私たちは地域経済に関するリサーチ・分析とレポート作成、経営戦略立案支援・事業計画策定・プロジェクト管理・経営指導等を実施しています。',
                'tags' => []
            ],
            [
                'category' => 'membership',
                'question' => '資料費どのくらいの会費を支払っているのですか？',
                'answer' => 'スタンダード会員：年会費12,000円（税別）。プレミアム会員：ビジネスマッチング・事業承継等の支援を含む特典をご提供します。',
                'tags' => ['スタンダード会員','プレミアム会員']
            ],
            [
                'category' => 'research',
                'question' => '研究会の開催はありますか？',
                'answer' => '定期的な研究会や勉強会を開催しており、会員の皆様にご参加いただけます。',
                'tags' => []
            ],
            [
                'category' => 'membership',
                'question' => '会費減額、減額はどうしたら良いですか？',
                'answer' => '会費の減額や変更については、お気軽にお問い合わせください。',
                'tags' => []
            ],
            [
                'category' => 'service',
                'question' => '経営診断をしたい場合どうすればいいの、態度を教えてほしい？',
                'answer' => '経営診断をご希望の場合は、まずはお問い合わせフォームよりご連絡ください。',
                'tags' => []
            ],
            [
                'category' => 'service',
                'question' => '料金体系を教えて？',
                'answer' => 'サービスごとに料金体系が異なります。詳しくはお問い合わせください。',
                'tags' => []
            ],
            [
                'category' => 'service',
                'question' => '入会は法人・個人でも申込める？',
                'answer' => '法人・個人を問わずご入会いただけます。',
                'tags' => []
            ],
            [
                'category' => 'service',
                'question' => '入会したい場合の手続きはどうしたらいい？',
                'answer' => '入会手続きについては、お問い合わせフォームよりご連絡いただくか、直接お電話でお問い合わせください。',
                'tags' => []
            ],
            [
                'category' => 'service',
                'question' => '会費はどうやって払う？',
                'answer' => '会費のお支払い方法は、銀行振込、口座振替等をご利用いただけます。',
                'tags' => []
            ],
            [
                'category' => 'service',
                'question' => '会費の支払いはいつする？',
                'answer' => '会費のお支払いタイミングについては、入会時にご案内いたします。',
                'tags' => []
            ],
        ];

        $page = PageContent::where('page_key', $key)->first();
        if (!$page) {
            PageContent::create([
                'page_key' => $key,
                'title' => 'よくあるご質問',
                'content' => [ 'texts' => $texts, 'faqs' => $faqs ],
                'is_published' => true,
                'published_at' => now(),
            ]);
            return;
        }

        $content = $page->content ?? [];
        if (!is_array($content)) $content = ['html' => (string)$content];
        $content['texts'] = array_merge($texts, $content['texts'] ?? []);

        // 既存のfaqsにデフォルトをマージ（questionで重複判定）
        $existing = $content['faqs'] ?? [];
        $byQuestion = [];
        foreach ($existing as $item) {
            if (is_array($item) && isset($item['question'])) {
                $byQuestion[$item['question']] = $item;
            }
        }
        foreach ($faqs as $item) {
            if (!isset($byQuestion[$item['question']])) {
                $existing[] = $item;
            }
        }
        $content['faqs'] = $existing;

        $page->update([
            'title' => $page->title ?: 'よくあるご質問',
            'content' => $content,
            'is_published' => true,
            'published_at' => $page->published_at ?: now(),
        ]);
    }
}
