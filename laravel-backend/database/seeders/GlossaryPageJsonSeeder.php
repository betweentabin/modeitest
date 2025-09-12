<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageContent;

class GlossaryPageJsonSeeder extends Seeder
{
    public function run(): void
    {
        $key = 'glossary';
        $texts = [
            'page_title' => '用語集',
            'page_subtitle' => 'glossary',
            // ContactSection (used with cms-page-key="glossary")
            'contact_title' => '株式会社ちくぎん地域経済研究所',
            'contact_label' => 'About us',
            'contact_subtitle' => '様々な分野の調査研究を通じ、企業活動などをサポートします。',
            'contact_cta' => 'お問い合わせはこちら',
        ];

        $htmls = [
            'intro' => '経済をより深く知るために必要な用語集となります。',
        ];

        // 初期用語（必要に応じて管理画面のJSONで増減可能）
        $items = [
            [ 'category' => 'economic', 'term' => 'CPI', 'definition' => 'Consumer Price Index（消費者物価指数）。消費者が購入する商品やサービスの価格変動を示す指標。' ],
            [ 'category' => 'economic', 'term' => 'TIBOR', 'definition' => 'Tokyo Interbank Offered Rate。銀行間取引の指標金利。' ],
            [ 'category' => 'financial', 'term' => '社債', 'definition' => '企業が資金調達のために発行する債券。利息を受け取れる投資商品。' ],
            [ 'category' => 'statistics', 'term' => '回帰分析', 'definition' => '説明変数と目的変数の関係を数式で表現し予測や要因分析に用いる統計手法。' ],
            [ 'category' => 'business', 'term' => 'キャッシュフロー', 'definition' => '一定期間における現金の収支のこと。営業・投資・財務CFに区分。' ],
        ];

        $page = PageContent::where('page_key', $key)->first();
        if (!$page) {
            PageContent::create([
                'page_key' => $key,
                'title' => '用語集',
                'content' => [
                    'texts' => $texts,
                    'htmls' => $htmls,
                    'items' => $items,
                ],
                'is_published' => true,
                'published_at' => now(),
            ]);
            return;
        }

        $content = $page->content ?? [];
        if (!is_array($content)) $content = ['html' => (string)$content];
        $content['texts'] = array_merge($texts, $content['texts'] ?? []);
        $content['htmls'] = array_merge($htmls, $content['htmls'] ?? []);
        if (!isset($content['items']) || !is_array($content['items']) || count($content['items']) === 0) {
            $content['items'] = $items;
        }

        $page->update([
            'title' => $page->title ?: '用語集',
            'content' => $content,
        ]);
    }
}
