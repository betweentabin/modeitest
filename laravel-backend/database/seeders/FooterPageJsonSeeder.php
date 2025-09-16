<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageContent;

class FooterPageJsonSeeder extends Seeder
{
    public function run(): void
    {
        $key = 'footer';
        $texts = [
            // Primary links
            'link_home' => 'トップページ',
            'link_company' => '会社概要',
            'link_about' => '私たちについて',
            'link_news' => 'お知らせ',
            'link_faq' => 'よくある質問',
            'link_contact' => 'お問い合わせ',
            // Services
            'link_seminar' => 'セミナー',
            'link_publication' => '刊行物',
            'link_glossary' => '用語集',
            // Membership cluster
            'link_membership' => '入会案内',
            'link_membership_standard' => 'スタンダード',
            'link_membership_premium' => 'プレミアム',
            'link_cri_consulting' => 'CRI 経営コンサルティング',
            // Legal/others
            'link_member_login' => '会員ログイン',
            'link_legal' => '特定商取引法に関する表記',
            'link_privacy' => 'プライバシーポリシー',
            'link_terms' => '利用規約',
            'link_sitemap' => 'サイトマップ',
        ];

        $page = PageContent::where('page_key', $key)->first();
        if (!$page) {
            PageContent::create([
                'page_key' => $key,
                'title' => 'フッター',
                'content' => ['texts' => $texts],
                'is_published' => true,
                'published_at' => now(),
            ]);
            return;
        }

        $content = $page->content ?? [];
        if (!is_array($content)) $content = ['html' => (string)$content];
        $content['texts'] = array_merge($texts, $content['texts'] ?? []);
        $page->update(['title' => $page->title ?: 'フッター', 'content' => $content]);
    }
}

