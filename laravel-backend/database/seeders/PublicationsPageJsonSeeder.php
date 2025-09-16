<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageContent;

class PublicationsPageJsonSeeder extends Seeder
{
    public function run(): void
    {
        $key = 'publications';
        $texts = [
            'page_title' => '刊行物',
            'page_subtitle' => 'publications',
            'cta_primary' => 'お問い合わせはこちら',
            'cta_secondary' => '入会はこちら',
            // UI labels
            'show_more' => 'さらに表示',
            'all_categories' => 'すべてのカテゴリ',
            'join_to_download' => '入会してダウンロード',
            'loading' => '読み込み中...',
        ];

        $page = PageContent::where('page_key', $key)->first();
        if (!$page) {
            PageContent::create([
                'page_key' => $key,
                'title' => '刊行物',
                'content' => ['texts' => $texts],
                'is_published' => true,
                'published_at' => now(),
            ]);
            return;
        }

        $content = $page->content ?? [];
        if (!is_array($content)) $content = ['html' => (string)$content];
        $content['texts'] = array_merge($texts, $content['texts'] ?? []);
        $page->update(['title' => $page->title ?: '刊行物', 'content' => $content]);
    }
}

