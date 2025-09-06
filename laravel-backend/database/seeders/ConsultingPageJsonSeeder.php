<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageContent;

class ConsultingPageJsonSeeder extends Seeder
{
    public function run(): void
    {
        $key = 'consulting';
        $texts = [
            'page_title' => 'CRI経営コンサルティング',
            'page_subtitle' => 'consulting',
        ];

        $page = PageContent::where('page_key', $key)->first();
        if (!$page) {
            PageContent::create([
                'page_key' => $key,
                'title' => 'CRI経営コンサルティング',
                'content' => ['texts' => $texts],
                'is_published' => true,
                'published_at' => now(),
            ]);
            return;
        }

        $content = $page->content ?? [];
        if (!is_array($content)) $content = ['html' => (string)$content];
        $content['texts'] = array_merge($texts, $content['texts'] ?? []);
        $page->update(['title' => $page->title ?: 'CRI経営コンサルティング', 'content' => $content]);
    }
}

