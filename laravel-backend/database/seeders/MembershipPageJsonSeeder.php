<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageContent;

class MembershipPageJsonSeeder extends Seeder
{
    public function run(): void
    {
        $key = 'membership';
        $texts = [
            'page_title' => '会員サービス',
            'page_subtitle' => 'membership',
            'cta_primary' => 'お問い合わせ',
            'cta_secondary' => '入会はこちら',
        ];

        $page = PageContent::where('page_key', $key)->first();
        if (!$page) {
            PageContent::create([
                'page_key' => $key,
                'title' => '会員サービス',
                'content' => ['texts' => $texts],
                'is_published' => true,
                'published_at' => now(),
            ]);
            return;
        }

        $content = $page->content ?? [];
        if (!is_array($content)) $content = ['html' => (string)$content];
        $content['texts'] = array_merge($texts, $content['texts'] ?? []);
        $page->update(['title' => $page->title ?: '会員サービス', 'content' => $content]);
    }
}

