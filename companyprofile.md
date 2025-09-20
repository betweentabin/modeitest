会社概要（/company）が「完璧」に反映される理由
概要
会社概要ページは、画像・文言ともに「公開ページの解決順」と「編集側の保存同期」が噛み合っており、編集→公開が即時かつ安定して反映されます。特に以下が他ページより整備されています。

フロントの画像解決が PageContent優先で、media（レジストリ）も正しくフォールバック
キャッシュバスト（uploaded_at→_t=）によりブラウザ/CDNに負けない
変更通知（localStorageやカスタムイベント）で公開タブを強制再読込
編集側が会社概要向けキーを media にもミラー保存（使い回しが効く）
フロント側（公開ページ）の表示パイプライン
最優先は PageContent

画像は PageContent.content.images を最優先で表示（/storage/... に対して uploaded_at を元に _t= を付与）
参照: src/components/CompanyProfile.vue:1 → media() / staffEntries() など
ページ固有マッピング → グローバルMedia

PageContent.content.media_keys → usePageMedia().getResponsiveSlot() でキー解決（モバイル/タブレット対応も内包）
それでも無ければ useMedia().getResponsiveImage() にフォールバック
参照: src/components/CompanyProfile.vue:600 付近, src/composables/usePageMedia.js:1, src/composables/useMedia.js:1
変更検知と再読み込み（リサイズ不要）

localStorage page_content_cache:company-profile を監視して usePageText.load({force:true}) を実行
cms-media-updated（全体イベント）でも再読込をトリガ
参照: src/components/CompanyProfile.vue:600 付近（storage/visibility監視）, src/App.vue:1（cms-media-updated）
キャッシュバストの徹底

PageContent側の画像（とくに /storage/）に uploaded_at を反映した _t= を付与して確実に最新にする
参照: src/components/CompanyProfile.vue:1（キャッシュバスト実装）
この組み合わせにより、編集後の画像がリロード/リサイズ無しでも安定反映されます。

編集側（Block CMS）からの保存フローがリッチ
画像差し替えの「会社概要特別扱い」

company_profile_* で始まるキーは、差し替え時に PageContent だけでなく media ページにも自動ミラー
グローバルMedia（useMedia）で即使え、他ページやフォールバック経路でも一致表示
参照: src/views/admin/BlockCmsEditor.vue:2322（onReplacePageImage 内）
KV（ヒーロー）のブリッジ保存

KVを設定すると、PageContent.images.hero と media_keys.hero（例: hero_company_profile）に加え、media ページの hero_* にも保存
かつ useMedia のキャッシュを無効化
参照: src/views/admin/BlockCmsEditor.vue:2678（onKvSelected）
変更通知で公開タブを即時更新

差し替え/追加後に localStorage の page_content_cache:<pageKey> を更新（公開コンポーネントがこれを監視して強制再読込）
参照（今回追加済み）: src/views/admin/BlockCmsEditor.vue:2322（差し替え後の通知）, src/views/admin/BlockCmsEditor.vue:2369（新規追加後の通知）
編集側プレビューも「公開と同じ順序」で解決

PageContent → per-page media → global media → fallback の順でURL解決（公開と一致）
参照（今回追加済み）: src/views/admin/BlockCmsEditor.vue:1710 以降（_media/_pageMedia導入, getImageUrlByKey()拡張）
DBの裏付け（確認済み）
PageContent: company-profile

content.images に company_profile_staff_* 系キーが uploaded_at 付きで保存（/storage URL）
これが PageContent優先の解決で即表示され、uploaded_atによる_t=でキャッシュに勝てる
Mediaレジストリ: media

company_profile_staff_* が登録済みのため、公開側のフォールバック/使い回しが効く
KVでヒーローを設定していれば hero_company_profile も登録される
実際に確認したSQL例

一覧
SELECT id,page_key,is_published,updated_at FROM page_contents ORDER BY page_key;
company-profileのimages
WITH t AS (SELECT content FROM page_contents WHERE page_key='company-profile') SELECT img.key, CASE WHEN jsonb_typeof(img.value)='string' THEN img.value::text ELSE img.value->>'url' END AS url, img.value->>'uploaded_at' AS uploaded_at FROM t LEFT JOIN LATERAL jsonb_each((t.content->'images')::jsonb) AS img(key,value) ON true ORDER BY img.key;
mediaの company_profile_* が並ぶこと
SELECT img.key, CASE WHEN jsonb_typeof(img.value)='string' THEN img.value::text ELSE img.value->>'url' END AS url FROM page_contents pc LEFT JOIN LATERAL jsonb_each((pc.content->'images')::jsonb) AS img(key,value) ON true WHERE pc.page_key='media' AND img.key LIKE 'company_profile_%' ORDER BY img.key;
「会社概要は完璧」になる要素のまとめ
PageContent優先の解決＋キャッシュバストで、差し替え直後も最新画像
storage/visibility/localStorageイベントの連携で、公開タブが自動的に最新へ（リサイズ不要）
編集画面がメディアレジストリへもミラー保存（company_profile_*）、公開フォールバックと編集プレビューが一致
KVのブリッジ保存が安定（PageContent + media_keys + media を同時更新）
他ページとの差分（今回の修正で解消方向）
一部ページは、公開側の実装が「PageContentより静的フォールバックを先に取る」箇所があり、差し替えが見えづらかった
編集側が page_content_cache:<key> を更新せず、公開タブがPageContentの再読込に気づかないケースがあった
これらを会社概要と同じ作法（解決順・通知・キャッシュバスト）に順次揃えることで行動が一致
運用Tips
ヒーロー（KV）は各ページで設定推奨（KVは自動でPageContent＋media_keys＋mediaへブリッジ）
スタッフ/セクション画像など再利用するものは、PageContent保存に加え、必要ならmediaへも持たせるとフォールバックがさらに安定
対応状況（このリポジトリで入れたもの）
CRI/研究所ページを会社概要と同じ優先順に統一（公開）
/storage/ 絶対URLでも _t= のキャッシュバストを徹底
公開ページが page_content_cache:<pageKey> の通知で即再読込
編集プレビューも「公開と同じ順序」で画像解決、編集→公開の見え方を一致
postgresql://postgres:RgvdpkoBgfjrvxjobxANPJrHfNIeyRkh@shinkansen.proxy.rlwy.net:47420/railway
dbのパブリックurlです