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
            // Intro section
            'intro_title' => 'ご入会に際しまして',
            'intro_text' => 'ちくぎん地域経済研究所では各種サービスを気軽にご利用いただけるよう、会員制度「ちくぎん地域経済クラブ」を設けております。会員の皆さまには地域経済の情報誌「ちくぎん地域経済レポート」をお届けするとともに、企業経営に関する各種サービスの提供や講演会・セミナーの案内など、御社のビジネスをバックアップします。',
            // Services section headings
            'services_title' => '主な会員が受けられるサービス内容',
            'services_label' => 'service',
            // Categories
            'premium_category_title' => 'プレミアサービス',
            'standard_premium_category_title' => 'スタンダード　&　プレミアサービス',
            // Premium service 1
            'premium_service1_tag' => 'consultation',
            'premium_service1_name' => '日経トップリーダー',
            // Standard services (1..5)
            'standard_service1_tag' => 'consultation',
            'standard_service1_name' => 'ビジネスセミナー',
            'standard_service2_tag' => 'problem',
            'standard_service2_name' => 'マッチング',
            'standard_service3_tag' => 'problem',
            'standard_service3_name' => '経済統計指標DL',
            'standard_service4_tag' => 'consultation',
            'standard_service4_name' => '地域経済統計レポート閲覧',
            'standard_service5_tag' => 'problem',
            'standard_service5_name' => '経営相談',
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
