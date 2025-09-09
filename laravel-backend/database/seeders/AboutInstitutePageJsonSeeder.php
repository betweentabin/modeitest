<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageContent;

class AboutInstitutePageJsonSeeder extends Seeder
{
    public function run(): void
    {
        $key = 'about-institute';

        $texts = [
            'page_title' => 'ちくぎん地域経済研究所について',
            'page_subtitle' => 'for you',

            'about_title' => 'ちくぎん地域経済研究所について',
            'about_subtitle' => 'FOR YOU',

            'service_title' => 'サービス概要',
            'service_subtitle' => 'service',

            'service1_title' => '開発・研究',
            'service1_desc' => 'ちくぎん地域経済研究所では、国・地方自治体・大学・企業などからのご要望を受け、様々な情報を収集・調査・分析をします。有意義な情報を分かりやすく発信していきます。',
            'service2_title' => '人材開発、セミナー',
            'service2_desc' => '企業幹部、従業員または後継者(次世代育成)にマッチする効果的な研修を行います。ご要望に合わせて各種講演会、セミナー等の企画・運営を行うほか、様々なニーズに合わせて、外部専門家等の紹介・斡旋をいたします。',
            'service3_title' => '経営支援(経営サポート)',
            'service3_desc' => '企業の皆様の経営課題解決に向けたお手伝いを行います。社内のバックオフィス業務構築などのお悩み事がありましたらご相談ください。',

            'cta_primary' => 'お問い合わせはこちら',
            'cta_secondary' => '入会はこちら',
        ];

        $htmls = [
            'about_body' => '当研究所は、産・官・学・金(金融)のネットワークによる様々な分野の調査研究を通じ、企業活動などをサポートします。<br><br>経済・社会・産業動向などに関する調査研究及び企業経営や県民の生活のお役に立つ情報をご提供するとともに、各種経済・文化団体の事務局活動等を通じて、地域社会に貢献することを目指しております。<br>今後とも地元企業や地域の皆様をはじめ行政等との連携を緊密にし、様々な事業展開を図り地域の発展に寄与してまいりたいと考えております。',
            'service1_list' => '主な定期刊行物<br>ちくぎん地域経済レポート（四半期毎）<br>Hot Information（1ヶ月に2回）<br>メールマガジン（毎週2回）',
        ];

        $page = PageContent::where('page_key', $key)->first();
        if (!$page) {
            PageContent::create([
                'page_key' => $key,
                'title' => 'ちくぎん地域経済研究所について',
                'content' => ['texts' => $texts, 'htmls' => $htmls],
                'is_published' => true,
                'published_at' => now(),
            ]);
            return;
        }

        $content = $page->content ?? [];
        if (!is_array($content)) $content = ['html' => (string)$content];
        $content['texts'] = array_merge($texts, $content['texts'] ?? []);
        $existingHtmls = isset($content['htmls']) && is_array($content['htmls']) ? $content['htmls'] : [];
        $content['htmls'] = array_merge($htmls, $existingHtmls);
        $page->update(['title' => $page->title ?: 'ちくぎん地域経済研究所について', 'content' => $content]);
    }
}

