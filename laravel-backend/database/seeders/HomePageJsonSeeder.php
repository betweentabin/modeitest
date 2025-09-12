<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageContent;

class HomePageJsonSeeder extends Seeder
{
    public function run(): void
    {
        $key = 'home';

        $texts = [
            // HeroSection titles
            'page_title' => 'ちくぎん地域経済研究所',
            'page_subtitle' => 'for your business',

            // About section
            'about_title' => 'ちくぎん地域経済研究所について',
            'about_subtitle' => 'FOR YOU',
            // CTA button under about
            'cta_secondary' => '研究所について詳しく',
        ];

        $htmls = [
            'about_body' => '当研究所は、産・官・学・金(金融機関)のネットワークによる様々な分野の調査研究を通じ、企業活動などをサポートします。<br><br>経済・社会・産業動向などに関する調査研究及び企業経営や県民の生活のお役に立つ情報をご提供するとともに、各種経済・文化団体の事務局活動等を通じて、地域社会に貢献することを目指しております。',
        ];

        $page = PageContent::where('page_key', $key)->first();
        if (!$page) {
            PageContent::create([
                'page_key' => $key,
                'title' => 'ホーム',
                'content' => ['texts' => $texts, 'htmls' => $htmls],
                'is_published' => true,
                'published_at' => now(),
            ]);
            return;
        }

        $content = $page->content ?? [];
        if (!is_array($content)) $content = ['html' => (string)$content];
        $existingTexts = isset($content['texts']) && is_array($content['texts']) ? $content['texts'] : [];
        $existingHtmls = isset($content['htmls']) && is_array($content['htmls']) ? $content['htmls'] : [];
        // Prefer existing where present; provide defaults otherwise
        $content['texts'] = array_merge($texts, $existingTexts);
        $content['htmls'] = array_merge($htmls, $existingHtmls);

        $page->update([
            'title' => $page->title ?: 'ホーム',
            'content' => $content,
            'is_published' => true,
            'published_at' => $page->published_at ?: now(),
        ]);
    }
}

