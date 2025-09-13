-- ================================================
-- ページコンテンツデータ投入SQL
-- Created: 2024年 (modeitestプロジェクト用)
-- Target: PostgreSQL (Railway)
-- Purpose: 26ページのCMS管理対応データ投入
-- ================================================

-- ページコンテンツテーブルにデータ投入
-- 既存データとの重複を避けて更新または挿入

INSERT INTO page_contents (page_key, title, content, meta_description, meta_keywords, is_published, published_at, created_at, updated_at) VALUES

-- 1. ホームページ
('home', 'ホーム - 一般社団法人○○研究機構', '{"content": "経済レポート・CRI・統計データなど、豊富な情報をお届けします。", "images": ["hero-image.png"]}', '一般社団法人○○研究機構のホームページです', 'ホーム,経済,研究,機構', true, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),

-- 2. 機構について
('about', '機構について - 一般社団法人○○研究機構', '{"content": "当機構の概要、設立趣旨、組織体制についてご紹介します。", "images": []}', '一般社団法人○○研究機構の概要をご紹介', '機構について,概要,組織', true, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),

-- 3. 経済レポート
('economic-reports', '経済レポート - 一般社団法人○○研究機構', '{"content": "最新の経済動向分析レポートを会員様向けに提供しています。", "images": []}', '経済動向の分析レポートを提供', '経済レポート,分析,動向', true, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),

-- 4. CRIコンサルティング
('cri-consulting', 'CRIコンサルティング - 一般社団法人○○研究機構', '{"content": "企業様向けのコンサルティングサービスをご提供しています。", "images": []}', '企業向けコンサルティングサービス', 'CRI,コンサルティング,企業', true, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),

-- 5. 経済統計
('economic-statistics', '経済統計 - 一般社団法人○○研究機構', '{"content": "各種経済統計データを分析・提供しています。", "images": []}', '経済統計データの分析と提供', '経済統計,データ,分析', true, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),

-- 6. セミナー情報
('seminars', 'セミナー情報 - 一般社団法人○○研究機構', '{"content": "定期開催セミナーのご案内と申込み受付。", "images": []}', 'セミナー情報と申込み案内', 'セミナー,講演,申込み', true, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),

-- 7. お知らせ・お知らせ
('news', 'お知らせ・お知らせ - 一般社団法人○○研究機構', '{"content": "最新のお知らせとお知らせをお伝えします。", "images": []}', '最新お知らせとお知らせ', 'お知らせ,お知らせ,最新', true, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),

-- 8. FAQ
('faq', 'よくあるご質問 - 一般社団法人○○研究機構', '{"content": "よくお寄せいただくご質問にお答えします。", "images": []}', 'よくあるご質問とその回答', 'FAQ,質問,回答', true, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),

-- 9. お問い合わせ
('contact', 'お問い合わせ - 一般社団法人○○研究機構', '{"content": "各種お問い合わせはこちらから。", "images": []}', 'お問い合わせフォーム', 'お問い合わせ,連絡,フォーム', true, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),

-- 10. 会員申込み
('membership-application', '会員申込み - 一般社団法人○○研究機構', '{"content": "会員申込みフォームです。", "images": []}', '会員申込み手続き', '会員,申込み,入会', true, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),

-- 11. 用語集
('glossary', '用語集 - 一般社団法人○○研究機構', '{"content": "経済・金融用語の解説集です。", "images": []}', '経済・金融用語の解説', '用語集,経済,金融,解説', true, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),

-- 12. プライバシーポリシー
('privacy-policy', 'プライバシーポリシー - 一般社団法人○○研究機構', '{"content": "個人情報の取り扱いについて", "images": []}', '個人情報保護方針', 'プライバシーポリシー,個人情報,保護', true, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),

-- 13. 利用規約
('terms-of-service', '利用規約 - 一般社団法人○○研究機構', '{"content": "サービス利用規約", "images": []}', 'サービス利用規約', '利用規約,サービス,規約', true, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),

-- 14. サイトマップ
('sitemap', 'サイトマップ - 一般社団法人○○研究機構', '{"content": "サイト全体の構成をご案内", "images": []}', 'サイトマップ', 'サイトマップ,構成,案内', true, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),

-- 15. 会社概要
('company-profile', '会社概要 - 一般社団法人○○研究機構', '{"content": "法人の詳細情報", "images": []}', '法人概要', '会社概要,法人,詳細', true, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),

-- 16. アクセス
('access', 'アクセス - 一般社団法人○○研究機構', '{"content": "所在地とアクセス方法", "images": []}', 'アクセス情報', 'アクセス,所在地,地図', true, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),

-- 17. 採用情報
('recruitment', '採用情報 - 一般社団法人○○研究機構', '{"content": "採用に関する情報", "images": []}', '採用情報', '採用,求人,情報', true, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),

-- 18. リンク集
('links', 'リンク集 - 一般社団法人○○研究機構', '{"content": "関連サイトへのリンク", "images": []}', 'リンク集', 'リンク,関連サイト', true, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),

-- 19. お知らせ詳細
('notice-detail', 'お知らせ詳細 - 一般社団法人○○研究機構', '{"content": "個別のお知らせ詳細ページ", "images": []}', 'お知らせ詳細', 'お知らせ,詳細,情報', true, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),

-- 20. 会員ログイン
('member-login', '会員ログイン - 一般社団法人○○研究機構', '{"content": "会員専用ログインページ", "images": []}', '会員ログイン', 'ログイン,会員,認証', true, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),

-- 21. 会員登録
('member-register', '会員登録 - 一般社団法人○○研究機構', '{"content": "新規会員登録ページ", "images": []}', '会員登録', '会員登録,新規,入会', true, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),

-- 22. マイアカウント
('my-account', 'マイアカウント - 一般社団法人○○研究機構', '{"content": "会員専用マイページ", "images": []}', 'マイアカウント', 'マイアカウント,会員,マイページ', true, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),

-- 23. お問い合わせ確認
('contact-confirm', 'お問い合わせ確認 - 一般社団法人○○研究機構', '{"content": "お問い合わせ内容の確認ページ", "images": []}', 'お問い合わせ確認', 'お問い合わせ,確認', true, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),

-- 24. お問い合わせ完了
('contact-complete', 'お問い合わせ完了 - 一般社団法人○○研究機構', '{"content": "お問い合わせ送信完了ページ", "images": []}', 'お問い合わせ完了', 'お問い合わせ,完了,送信', true, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),

-- 25. 会員名簿
('member-directory', '会員名簿 - 一般社団法人○○研究機構', '{"content": "会員名簿（Standard/Premium会員限定）", "images": []}', '会員名簿', '会員名簿,名簿,会員一覧', true, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),

-- 26. お気に入り会員
('member-favorites', 'お気に入り会員 - 一般社団法人○○研究機構', '{"content": "お気に入り登録した会員一覧", "images": []}', 'お気に入り会員', 'お気に入り,会員,一覧', true, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)

-- 重複キーの場合は更新
ON CONFLICT (page_key) DO UPDATE SET
    title = EXCLUDED.title,
    content = EXCLUDED.content,
    meta_description = EXCLUDED.meta_description,
    meta_keywords = EXCLUDED.meta_keywords,
    is_published = EXCLUDED.is_published,
    updated_at = CURRENT_TIMESTAMP;

-- ================================================
-- 完了メッセージ
-- ================================================

DO $$
BEGIN
    RAISE NOTICE '==============================================';
    RAISE NOTICE '✅ ページコンテンツデータ投入完了';
    RAISE NOTICE '==============================================';
    RAISE NOTICE '📄 投入されたページ数: 26ページ';
    RAISE NOTICE '';
    RAISE NOTICE '📋 管理対象ページ:';
    RAISE NOTICE '   1. ホーム (home)';
    RAISE NOTICE '   2. 機構について (about)';
    RAISE NOTICE '   3. 経済レポート (economic-reports)';
    RAISE NOTICE '   4. CRIコンサルティング (cri-consulting)';
    RAISE NOTICE '   5. 経済統計 (economic-statistics)';
    RAISE NOTICE '   6. セミナー情報 (seminars)';
    RAISE NOTICE '   7. お知らせ・お知らせ (news)';
    RAISE NOTICE '   8. FAQ (faq)';
    RAISE NOTICE '   9. お問い合わせ (contact)';
    RAISE NOTICE '   10. 会員申込み (membership-application)';
    RAISE NOTICE '   11. 用語集 (glossary)';
    RAISE NOTICE '   12. プライバシーポリシー (privacy-policy)';
    RAISE NOTICE '   13. 利用規約 (terms-of-service)';
    RAISE NOTICE '   14. サイトマップ (sitemap)';
    RAISE NOTICE '   15. 会社概要 (company-profile)';
    RAISE NOTICE '   16. アクセス (access)';
    RAISE NOTICE '   17. 採用情報 (recruitment)';
    RAISE NOTICE '   18. リンク集 (links)';
    RAISE NOTICE '   19. お知らせ詳細 (notice-detail)';
    RAISE NOTICE '   20. 会員ログイン (member-login)';
    RAISE NOTICE '   21. 会員登録 (member-register)';
    RAISE NOTICE '   22. マイアカウント (my-account)';
    RAISE NOTICE '   23. お問い合わせ確認 (contact-confirm)';
    RAISE NOTICE '   24. お問い合わせ完了 (contact-complete)';
    RAISE NOTICE '   25. 会員名簿 (member-directory)';
    RAISE NOTICE '   26. お気に入り会員 (member-favorites)';
    RAISE NOTICE '==============================================';
END
$$;
