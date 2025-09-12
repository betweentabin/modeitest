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
            // In-page navigation labels
            'nav_philosophy' => '経営理念',
            'nav_message' => 'ご挨拶',
            'nav_profile' => '企業概要',
            'nav_history' => '沿革',
            'nav_staff' => '所員紹介',
            'nav_financial' => '決算報告',
            'nav_access' => 'アクセス',
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

        // 初期画像（メディア管理に出すため、絶対URLのままでもOK）
        $images = [
            'company_profile_philosophy' => 'https://api.builder.io/api/v1/image/assets/TEMP/01501a28725d762f4b766643e9bcd235f2e43e2e?width=1340',
            'company_profile_message' => 'https://api.builder.io/api/v1/image/assets/TEMP/20aa75cfa1be4c2096a1f47bf126cf240173b231?width=1340',
            'company_profile_staff_morita' => 'https://api.builder.io/api/v1/image/assets/TEMP/013d1cd8a9cd502c97404091dee8168d1aa93903?width=452',
            'company_profile_staff_mizokami' => 'https://api.builder.io/api/v1/image/assets/TEMP/3eb35c11c5738cb9283fd65048f0db5c42dd1080?width=451',
            'company_profile_staff_kuga' => 'https://api.builder.io/api/v1/image/assets/TEMP/ce433d9c00a0ce68895c315df3a3c49aa626deff?width=451',
            'company_profile_staff_takada' => 'https://api.builder.io/api/v1/image/assets/TEMP/b21372a6aca15dfc189c6953aeb23f36f5d5e20b?width=451',
            'company_profile_staff_nakamura' => 'https://api.builder.io/api/v1/image/assets/TEMP/497e67c9baa8add863ab6c5cc32439cf23eea4c3?width=451',
        ];

        // デフォルトの沿革（history）
        $defaultHistory = [
            [ 'year' => '1988', 'date' => '昭和63年1月30日', 'body' => 'ちくぎんコンピュータサービス（株）設立' ],
            [ 'year' => '2010', 'date' => '平成22年6月29日', 'body' => 'ちくぎんコンピュータサービス（株）の定款変更により、経営コンサルティング業務・経済調査等業務を追加。' ],
            [ 'year' => '2011', 'date' => '平成23年7月1日', 'body' => '社名変更　（株）ちくぎん地域経済研究所として新たにスタート。<br>主たる業務は調査・研究、人材開発、IT関連サービス、経営支援（経営サポート）、コンシェルジュサービス。' ],
        ];

        $page = PageContent::where('page_key', $key)->first();
        if (!$page) {
            PageContent::create([
                'page_key' => $key,
                'title' => '会社概要',
                'content' => ['texts' => $texts, 'htmls' => $defaultHtmls, 'images' => $images, 'history' => $defaultHistory],
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
        $imgs = isset($content['images']) && is_array($content['images']) ? $content['images'] : [];
        $content['images'] = array_merge($images, $imgs);
        // history は未設定または空のときだけ初期値を設定（既存優先）
        if (empty($content['history']) || !is_array($content['history'])) {
            $content['history'] = $defaultHistory;
        }

        // プライバシー方式との整合: content.html が未設定なら既存セクションから全文HTMLを合成
        $existingHtml = isset($content['html']) && is_string($content['html']) ? trim($content['html']) : '';
        if ($existingHtml === '') {
            $t = $content['texts'];
            $h = $content['htmls'];
            $parts = [];

            $phTitle = isset($t['philosophy_title']) && $t['philosophy_title'] !== '' ? $t['philosophy_title'] : '経営理念';
            $parts[] = '<h2>' . htmlspecialchars($phTitle, ENT_QUOTES, 'UTF-8') . '</h2>';
            if (!empty($h['mission_body'])) { $parts[] = '<div>' . $h['mission_body'] . '</div>'; }

            $msgTitle = isset($t['message_title']) && $t['message_title'] !== '' ? $t['message_title'] : 'ご挨拶';
            $parts[] = '<h2>' . htmlspecialchars($msgTitle, ENT_QUOTES, 'UTF-8') . '</h2>';
            if (!empty($h['message_body'])) { $parts[] = '<div>' . $h['message_body'] . '</div>'; }

            // 会社概要テーブルを合成（ラベルはサニタイズ、値はHTML許容）
            $profilePairs = [
                ['profile_company_name_label','profile_company_name_value','会社名'],
                ['profile_established_label','profile_established_value','設立'],
                ['profile_address_label','profile_address_value','住所'],
                ['profile_representative_label','profile_representative_value','代表者'],
                ['profile_capital_label','profile_capital_value','資本金'],
                ['profile_shareholders_label','profile_shareholders_value','株主'],
                ['profile_organization_label','profile_organization_value','組織体制'],
            ];
            $rows = '';
            foreach ($profilePairs as [$lk, $vk, $fallbackLabel]) {
                $label = isset($t[$lk]) && is_string($t[$lk]) && trim($t[$lk]) !== '' ? $t[$lk] : $fallbackLabel;
                $val = isset($t[$vk]) && is_string($t[$vk]) ? $t[$vk] : '';
                $rows .= '<tr><th>' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . '</th><td>' . $val . '</td></tr>';
            }
            if ($rows !== '') {
                $profTitle = isset($t['profile_title']) && $t['profile_title'] !== '' ? $t['profile_title'] : '会社概要';
                $parts[] = '<h2>' . htmlspecialchars($profTitle, ENT_QUOTES, 'UTF-8') . '</h2>';
                $parts[] = '<table>' . $rows . '</table>';
            }

            $compiled = implode("\n\n", $parts);
            $content['html'] = $compiled;
            $content['htmls'] = array_merge($content['htmls'] ?? [], ['body' => $compiled]);
        }

        $page->update(['title' => $page->title ?: '会社概要', 'content' => $content]);
    }
}
