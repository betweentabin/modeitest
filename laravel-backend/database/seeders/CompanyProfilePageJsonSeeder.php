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
        ];

        $defaultHtmls = [
            'message_body' => '<p>皆さま方には、平素より筑邦銀行グループをご利用お引き立ていただき誠にありがとうございます。</p>
<p>私どもは「地域社会へのご奉仕」という基本理念のもと、総合金融サービスの向上・充実に努めてまいりました。こうした中で、地元のさらなる発展に貢献するため、「(株)ちくぎん地域経済研究所」を設立いたしました。</p>
<p>当研究所では、産・官・学・金（金融機関）のネットワークの構築などにより、今後一層発展の可能性を秘めたバイオ・アグリ・医療・介護をはじめ様々な分野の調査研究をより専門的に行うことといたします。</p>
<p>また、こうした研究成果や様々なネットワークを活用し経営コンサルティング機能を十分に発揮することなどにより、多様な企業の生産・販売活動や医療・介護活動などのサポートを行ってまいります。</p>
<p>以上のような活動を通じ、皆さま方と緊密な連携のもと、ヒト・モノ・カネ・情報を最大限に活かし、地域の振興・発展にお役にたてるよう努めてまいる所存です。</p>
<p>当研究所へのご支援、ご愛顧をよろしくお願い申し上げます。</p>'
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
