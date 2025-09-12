<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageContent;

class ContactPageJsonSeeder extends Seeder
{
    public function run(): void
    {
        $key = 'contact';
        $texts = [
            'page_title' => 'お問い合わせ',
            'page_subtitle' => 'contact',
            'form_title' => 'お問い合わせ',
            // ContactSection (default cmsPageKey fallback is 'contact')
            'contact_title' => '株式会社ちくぎん地域経済研究所',
            'contact_label' => 'About us',
            'contact_subtitle' => '様々な分野の調査研究を通じ、企業活動などをサポートします。',
            'contact_cta' => 'お問い合わせはこちら',
        ];

        $page = PageContent::where('page_key', $key)->first();
        if (!$page) {
            PageContent::create([
                'page_key' => $key,
                'title' => 'お問い合わせ',
                'content' => ['texts' => $texts],
                'is_published' => true,
                'published_at' => now(),
            ]);
            return;
        }

        $content = $page->content ?? [];
        if (!is_array($content)) $content = ['html' => (string)$content];
        $content['texts'] = array_merge($texts, $content['texts'] ?? []);
        $page->update(['title' => $page->title ?: 'お問い合わせ', 'content' => $content]);
    }
}
