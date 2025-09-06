<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageContent;

class AboutPageJsonSeeder extends Seeder
{
    public function run(): void
    {
        $key = 'about';

        $texts = [
            'page_title' => 'ちくぎん地域経済研究所について',
            'page_subtitle' => 'ABOUT US',
            'mission_title' => '産学官金のネットワークを活かした地域創生',
            'mission_body' => '私たちは、産・官・学・金（金融機関）のネットワークを活用し、地域経済の持続的な発展と地域企業の成長を支援することを使命としています。',
            'philosophy_title' => '経営理念',
            'philosophy_subtitle' => 'OUR MISSION',
            'message_title' => 'ご挨拶',
            'message_subtitle' => 'MESSAGE',
            'company_title' => '会社概要',
            'company_subtitle' => 'COMPANY PROFILE',
            'history_title' => '沿革',
            'history_subtitle' => 'HISTORY',
            'staff_title' => '所属紹介',
            'staff_subtitle' => 'OUR TEAM',
        ];

        $content = [ 'texts' => $texts, 'images' => [] ];

        $page = PageContent::where('page_key', $key)->first();
        if (!$page) {
            PageContent::create([
                'page_key' => $key,
                'title' => '会社概要',
                'content' => $content,
                'is_published' => true,
                'published_at' => now(),
            ]);
            return;
        }

        $existing = $page->content ?? [];
        if (!is_array($existing)) $existing = ['html' => (string)$existing];
        $existing['texts'] = array_merge($texts, $existing['texts'] ?? []);
        $page->update(['title' => $page->title ?: '会社概要', 'content' => $existing]);
    }
}
