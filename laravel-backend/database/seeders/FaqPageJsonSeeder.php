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

        $faqs = [
            [ 'category' => 'service', 'question' => 'セミナーの参加方法は？', 'answer' => '各セミナー詳細ページから申込フォームに進んでください。', 'tags' => ['セミナー','申込'] ],
            [ 'category' => 'membership', 'question' => '会員の種類を教えてください', 'answer' => 'スタンダード会員、プレミアム会員をご用意しています。', 'tags' => ['会員'] ],
            [ 'category' => 'research', 'question' => 'レポートの入手方法は？', 'answer' => '刊行物ページからダウンロードまたは購入できます。', 'tags' => ['刊行物'] ],
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
        // 既に faqs があれば維持
        $content['faqs'] = $content['faqs'] ?? $faqs;

        $page->update([
            'title' => $page->title ?: 'よくあるご質問',
            'content' => $content,
            'is_published' => true,
            'published_at' => $page->published_at ?: now(),
        ]);
    }
}

