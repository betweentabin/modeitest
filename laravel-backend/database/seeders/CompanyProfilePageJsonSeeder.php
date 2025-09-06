<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageContent;

class CompanyProfilePageJsonSeeder extends Seeder
{
    public function run(): void
    {
        $key = 'company-profile';
        $texts = [
            'page_title' => '会社概要',
            'page_subtitle' => 'About Us',
            'philosophy_title' => '経営理念',
            'philosophy_subtitle' => 'philosophy',
            'message_title' => 'ご挨拶',
            'message_subtitle' => 'message',
            'profile_title' => '会社概要',
            'profile_subtitle' => 'company profile',
            'message_label' => 'MESSAGE',
            'message_signature' => '株式会社 ちくぎん地域経済研究所代表取締役社長 空閑 重信',
            // OUR MISSIONブロック（本文は htmls へ）
            'mission_label' => 'OUR MISSION',
            'mission_title' => '産官学金のネットワーク活用による地域貢献',
            // 会社概要テーブル（ラベル・値を個別キーで管理）
            'profile_company_name_label' => '会社名',
            'profile_company_name_value' => '株式会社 ちくぎん地域経済研究所',
            'profile_established_label' => '設立',
            'profile_established_value' => '平成23年7月1日',
            'profile_address_label' => '住所',
            'profile_address_value' => '〒839-0864<br>福岡県久留米市百年公園1番1号 久留米リサーチセンタービル6階',
            'profile_representative_label' => '代表者',
            'profile_representative_value' => '代表取締役社長　空閑 重信',
            'profile_capital_label' => '資本金',
            'profile_capital_value' => '3,000万円',
            'profile_shareholders_label' => '株主',
            'profile_shareholders_value' => '筑邦銀行　および筑邦銀行グループ会社 （ちくぎんリース(株)、昭光(株)、筑邦信用保証(株)）',
            'profile_organization_label' => '組織体制',
            'profile_organization_value' => '企画部、調査部',
            // 見出し（沿革・所員紹介）
            'history_title' => '沿革',
            'history_subtitle' => 'history',
            'staff_title' => '所員紹介',
            'staff_subtitle' => 'About us',
        ];

        $defaultHtmls = [
            'message_body' => '<p>皆さま方には、平素より筑邦銀行グループをご利用お引き立ていただき誠にありがとうございます。</p>
<p>私どもは「地域社会へのご奉仕」という基本理念のもと、総合金融サービスの向上・充実に努めてまいりました。こうした中で、地元のさらなる発展に貢献するため、「(株)ちくぎん地域経済研究所」を設立いたしました。</p>
<p>当研究所では、産・官・学・金（金融機関）のネットワークの構築などにより、今後一層発展の可能性を秘めたバイオ・アグリ・医療・介護をはじめ様々な分野の調査研究をより専門的に行うことといたします。</p>
<p>また、こうした研究成果や様々なネットワークを活用し経営コンサルティング機能を十分に発揮することなどにより、多様な企業の生産・販売活動や医療・介護活動などのサポートを行ってまいります。</p>
<p>以上のような活動を通じ、皆さま方と緊密な連携のもと、ヒト・モノ・カネ・情報を最大限に活かし、地域の振興・発展にお役にたてるよう努めてまいる所存です。</p>
<p>当研究所へのご支援、ご愛顧をよろしくお願い申し上げます。</p>'
            ,
            'mission_body' => '<ul><li>地域に根差した経済・産業の調査・研究</li><li>地域経済を担う企業・医療・農業・学術研究活動のサポート</li><li>未来を支える「人」づくり</li></ul>'
        ];

        $page = PageContent::where('page_key', $key)->first();
        if (!$page) {
            PageContent::create([
                'page_key' => $key,
                'title' => '会社概要',
                'content' => ['texts' => $texts, 'htmls' => $defaultHtmls],
                'is_published' => true,
                'published_at' => now(),
            ]);
            return;
        }

        $content = $page->content ?? [];
        if (!is_array($content)) $content = ['html' => (string)$content];
        $content['texts'] = array_merge($texts, $content['texts'] ?? []);
        $htmls = isset($content['htmls']) && is_array($content['htmls']) ? $content['htmls'] : [];
        $content['htmls'] = array_merge($defaultHtmls, $htmls);
        $page->update(['title' => $page->title ?: '会社概要', 'content' => $content]);
    }
}
