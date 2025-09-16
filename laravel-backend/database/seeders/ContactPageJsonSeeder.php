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
            // Form labels/options/buttons
            'form_label_subject' => '件名',
            'form_placeholder_select' => '選択してください',
            'form_option_inquiry' => 'サービスに関するお問い合わせ',
            'form_option_membership' => '会員に関するお問い合わせ',
            'form_option_seminar' => 'セミナーに関するお問い合わせ',
            'form_option_other' => 'その他',
            'form_label_name' => 'お名前',
            'form_label_kana' => 'ふりがな（全角ひらがな）',
            'form_label_company' => '会社名',
            'form_label_position' => '役職',
            'form_label_phone' => '電話番号',
            'form_label_email' => 'メールアドレス',
            'form_label_content' => 'お問い合わせ内容',
            'form_privacy_note' => '弊社のプライバシーポリシー（個人情報保護方針）に同意をされる場合は、下記のチェックボックスにチェックを入れてください。',
            'form_privacy_agree' => '個人情報保護方針に同意します',
            'form_button_confirm' => '確認する',
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
