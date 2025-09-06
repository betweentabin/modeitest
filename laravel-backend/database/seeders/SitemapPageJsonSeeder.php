<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageContent;

class SitemapPageJsonSeeder extends Seeder
{
    public function run(): void
    {
        $key = 'sitemap';
        $texts = [
            'page_title' => 'サイトマップ',
            'page_subtitle' => 'SITEMAP',
            'cta_primary' => 'お問い合わせ',
            'cta_secondary' => '入会はこちら',
            'intro' => '当サイトの構造をご案内いたします。',
        ];

        $page = PageContent::where('page_key', $key)->first();
        if (!$page) {
            PageContent::create([
                'page_key' => $key,
                'title' => 'サイトマップ',
                'content' => ['texts' => $texts],
                'is_published' => true,
                'published_at' => now(),
            ]);
            return;
        }

        $content = $page->content ?? [];
        if (!is_array($content)) $content = ['html' => (string)$content];
        $content['texts'] = array_merge($texts, $content['texts'] ?? []);
        $page->update(['title' => $page->title ?: 'サイトマップ', 'content' => $content]);
    }
}
