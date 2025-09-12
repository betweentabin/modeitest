<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageContent;

class ConsultingPageJsonSeeder extends Seeder
{
    public function run(): void
    {
        $key = 'cri-consulting';
        $alias = 'consulting'; // legacy key to migrate/sync from
        $texts = [
            'page_title' => 'CRI経営コンサルティング',
            'page_subtitle' => 'consulting',
            // What is section
            'what_title' => 'CRI 経営コンサルティングとは？',
            'what_subtitle' => 'consulting',
            'what_content_subtitle' => "What's CRI Management Consulting",
            'what_content_heading' => 'CRI経営コンサルティングとは、事業でお悩みの皆様に対し、アドバイス、サポートするサービスです',
            // Duties section
            'duties_title' => 'CRI経営コンサルティングの主な業務',
            'duties_subtitle' => 'main duties',
            'duties_label' => 'MAIN DUTIES',
            'duties_heading' => '事業にまつわる様々な悩みを一緒に解決します',
            // Support section
            'support_title' => 'サポート内容と費用に関して',
            'support_subtitle_en' => 'contents and costs',
            'support_free_title' => '無料 -FREE-',
            'support_paid_title' => '有料 -PAID-',
            // Achievements
            'achievements_title' => 'CRI経営コンサルティングの実績紹介',
            'achievements_subtitle' => 'achievements',
            // CTA
            'cta_primary' => 'お問い合わせはこちら',
            'cta_secondary' => '入会はこちら',
        ];

        $htmls = [
            'what_content_body' => '日常の企業活動の中で、まず自社が抱える様々な問題や課題・顧客ニーズなどに気付き、それらを整理して対応策を講じることができれば、改善に向けて新たなスタートを切ったと言えましょう。<br>しかし、「何か変だ。」と思いながらもとりあえず一日の業務を無事に終えたことに安心していては、身近に存在する重要なことに気付くのが遅れることもあります。',
            'duties_intro' => '事業にまつわる様々をサポート行います。<br>当研究所のネットワークを活かし、御社の実情に合う専門家もご紹介できます。',
            'duties_list' => '<p>経営戦略策定のサポート</p><p>ビジネスマッチィングの支援</p><p>事業継承の支援（後継者育成支援）</p><p>社員研修、経営計画策定のための人材育成</p><p>税務、財務、事務など各業務の課題解決力の育成</p><p>事務省力化のサポート</p><p>人事制度の策定</p><p>ワンストップのよろず差相談</p>',
            'support_intro' => '経営改善とは会社の中の「人」が変わることです。<br>ご相談と問題点・課題の整理は無料です。まずは、お気軽にご相談ください。'
        ];

        // Load primary and alias pages
        $page = PageContent::where('page_key', $key)->first();
        $aliasPage = PageContent::where('page_key', $alias)->first();

        $content = $page ? ($page->content ?? []) : [];
        if (!is_array($content)) $content = ['html' => (string)$content];
        $existingTexts = isset($content['texts']) && is_array($content['texts']) ? $content['texts'] : [];
        $existingHtmls = isset($content['htmls']) && is_array($content['htmls']) ? $content['htmls'] : [];

        $aliasContent = $aliasPage ? ($aliasPage->content ?? []) : [];
        if (!is_array($aliasContent)) $aliasContent = ['html' => (string)$aliasContent];
        $aliasTexts = isset($aliasContent['texts']) && is_array($aliasContent['texts']) ? $aliasContent['texts'] : [];
        $aliasHtmls = isset($aliasContent['htmls']) && is_array($aliasContent['htmls']) ? $aliasContent['htmls'] : [];

        // Merge order: defaults -> existing main -> alias (prefer alias since recent edits likely saved there)
        $finalTexts = array_replace($texts, $existingTexts, $aliasTexts);
        $finalHtmls = array_replace($htmls, $existingHtmls, $aliasHtmls);
        $content['texts'] = $finalTexts;
        $content['htmls'] = $finalHtmls;

        // content.html が空なら、セクションから合成
        $existingHtml = isset($content['html']) && is_string($content['html']) ? trim($content['html']) : '';
        if ($existingHtml === '') {
            $t = $content['texts'];
            $h = $content['htmls'];
            $parts = [];

            // What is
            $whatTitle = $t['what_title'] ?? 'CRI 経営コンサルティングとは？';
            $parts[] = '<h2>' . htmlspecialchars($whatTitle, ENT_QUOTES, 'UTF-8') . '</h2>';
            if (!empty($t['what_content_heading'])) {
                $parts[] = '<h3>' . htmlspecialchars($t['what_content_heading'], ENT_QUOTES, 'UTF-8') . '</h3>';
            }
            if (!empty($h['what_content_body'])) { $parts[] = '<div>' . $h['what_content_body'] . '</div>'; }

            // Duties
            $dutiesTitle = $t['duties_title'] ?? '主な業務';
            $parts[] = '<h2>' . htmlspecialchars($dutiesTitle, ENT_QUOTES, 'UTF-8') . '</h2>';
            if (!empty($t['duties_heading'])) {
                $parts[] = '<p>' . htmlspecialchars($t['duties_heading'], ENT_QUOTES, 'UTF-8') . '</p>';
            }
            if (!empty($h['duties_intro'])) { $parts[] = '<p>' . $h['duties_intro'] . '</p>'; }
            if (!empty($h['duties_list'])) { $parts[] = '<div>' . $h['duties_list'] . '</div>'; }

            // Support
            $supportTitle = $t['support_title'] ?? 'サポート内容と費用に関して';
            $parts[] = '<h2>' . htmlspecialchars($supportTitle, ENT_QUOTES, 'UTF-8') . '</h2>';
            if (!empty($h['support_intro'])) { $parts[] = '<p>' . $h['support_intro'] . '</p>'; }
            if (!empty($t['support_free_title'])) { $parts[] = '<h3>' . htmlspecialchars($t['support_free_title'], ENT_QUOTES, 'UTF-8') . '</h3>'; }
            if (!empty($t['support_paid_title'])) { $parts[] = '<h3>' . htmlspecialchars($t['support_paid_title'], ENT_QUOTES, 'UTF-8') . '</h3>'; }

            $compiled = implode("\n\n", $parts);
            $content['html'] = $compiled;
            $content['htmls'] = array_merge($content['htmls'] ?? [], ['body' => $compiled]);
        }

        if (!$page) {
            $page = PageContent::create([
                'page_key' => $key,
                'title' => 'CRI経営コンサルティング',
                'content' => $content,
                'is_published' => true,
                'published_at' => now(),
            ]);
        } else {
            $page->update([
                'title' => $page->title ?: 'CRI経営コンサルティング',
                'content' => $content,
                'is_published' => true,
                'published_at' => $page->published_at ?: now(),
            ]);
        }

        // Keep legacy alias in sync to avoid admin/editor confusion
        if ($aliasPage) {
            $aliasPage->update([
                'title' => $aliasPage->title ?: 'CRI経営コンサルティング',
                'content' => $content,
                'is_published' => true,
                'published_at' => $aliasPage->published_at ?: now(),
            ]);
        } else {
            PageContent::create([
                'page_key' => $alias,
                'title' => 'CRI経営コンサルティング',
                'content' => $content,
                'is_published' => true,
                'published_at' => now(),
            ]);
        }
    }
}
