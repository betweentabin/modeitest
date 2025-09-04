-- =====================================
-- データベース完全バックアップ（サンプルデータ込み）
-- 作成日: 2025年1月12日
-- 説明: 現在のRailway PostgreSQLの完全なデータバックアップ
-- =====================================

-- 基本スキーマは complete_database_backup.sql を参照
-- このファイルは主にサンプルデータを含む

-- =====================================
-- 会員サンプルデータ
-- =====================================

-- プレミアム会員（テスト用）
INSERT INTO members (
    email, password, company_name, representative_name, phone, postal_code, address,
    membership_type, status, membership_expires_at, is_active, created_at, updated_at
) VALUES (
    'test1@example.com',
    '$2y$12$9110bDlV9IAViguEXPp/lqNH6H2.UIGUgXoLfMK4B9FeuAg9NiKRmsbiu7tIt51kNqcWoyeKgG24a.C',
    '株式会社テスト商事',
    '山田太郎',
    '090-1234-5678',
    '111-1111',
    NULL,
    'premium',
    'active',
    '2026-09-04 03:40:10',
    TRUE,
    '1970-01-01 00:00:00',
    '2025-09-04 03:40:10'
) ON CONFLICT (email) DO UPDATE SET
    password = EXCLUDED.password,
    membership_type = EXCLUDED.membership_type,
    membership_expires_at = EXCLUDED.membership_expires_at,
    updated_at = EXCLUDED.updated_at;

-- その他のサンプル会員
INSERT INTO members (
    email, password, company_name, representative_name, phone,
    membership_type, status, is_active, created_at, updated_at
) VALUES 
(
    'standard@example.com',
    '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    '株式会社スタンダード',
    '佐藤花子',
    '090-2345-6789',
    'standard',
    'active',
    TRUE,
    NOW(),
    NOW()
),
(
    'free@example.com',
    '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    '有限会社フリー',
    '鈴木一郎',
    '090-3456-7890',
    'free',
    'active',
    TRUE,
    NOW(),
    NOW()
),
(
    'basic@example.com',
    '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    '株式会社ベーシック',
    '田中次郎',
    '090-4567-8901',
    'basic',
    'active',
    TRUE,
    NOW(),
    NOW()
)
ON CONFLICT (email) DO UPDATE SET
    company_name = EXCLUDED.company_name,
    representative_name = EXCLUDED.representative_name,
    updated_at = EXCLUDED.updated_at;

-- =====================================
-- セミナーサンプルデータ
-- =====================================

INSERT INTO seminars (
    title, description, date, start_time, end_time, location, capacity, fee,
    status, category, is_members_only, registration_deadline,
    created_at, updated_at
) VALUES 
(
    '採用力強化！経営・人事向け　面接官トレーニングセミナー',
    '優秀な人材を見極め、獲得するための面接技術を習得できるセミナーを開催します。経営者や人事担当者向けの実践的な内容となっております。',
    '2025-06-15',
    '14:00:00',
    '17:00:00',
    'ちくぎん地域経済研究所 会議室A',
    30,
    5000.00,
    'scheduled',
    '人事・労務',
    FALSE,
    '2025-06-10',
    NOW(),
    NOW()
),
(
    'DX推進セミナー',
    'デジタルトランスフォーメーションの基礎から実践まで学べるセミナーです。中小企業のDX導入事例も豊富に紹介します。',
    '2025-06-20',
    '13:00:00',
    '16:00:00',
    'オンライン開催',
    100,
    3000.00,
    'scheduled',
    'IT・デジタル',
    FALSE,
    '2025-06-15',
    NOW(),
    NOW()
),
(
    '地域経済活性化フォーラム',
    '九州地域の経済活性化について、産学官連携の取り組み事例を紹介するフォーラムです。',
    '2025-05-10',
    '10:00:00',
    '16:00:00',
    '久留米シティプラザ',
    200,
    0.00,
    'completed',
    '地域経済',
    FALSE,
    '2025-05-05',
    NOW(),
    NOW()
),
(
    '事業承継セミナー',
    '中小企業の事業承継に関する法務・税務・財務の実務について解説します。',
    '2025-04-25',
    '14:00:00',
    '17:00:00',
    'ちくぎん地域経済研究所 大会議室',
    50,
    2000.00,
    'completed',
    '経営・事業承継',
    TRUE,
    '2025-04-20',
    NOW(),
    NOW()
),
(
    '2025年度経済見通しセミナー',
    '2025年度の経済見通しと地域企業への影響について詳しく解説します。',
    '2025-03-15',
    '15:00:00',
    '17:00:00',
    'ちくぎん地域経済研究所 会議室B',
    80,
    1000.00,
    'completed',
    '経済動向',
    FALSE,
    '2025-03-10',
    NOW(),
    NOW()
),
(
    '新規事業開発セミナー',
    'イノベーション創出と新規事業開発の手法について実践的に学べます。',
    '2025-07-10',
    '10:00:00',
    '16:00:00',
    'ちくぎん地域経済研究所 大会議室',
    40,
    8000.00,
    'scheduled',
    '経営戦略',
    TRUE,
    '2025-07-05',
    NOW(),
    NOW()
)
ON CONFLICT DO NOTHING;

-- =====================================
-- 経済統計レポートサンプルデータ
-- =====================================

INSERT INTO economic_reports (
    title, description, category, year, publication_date, author, publisher,
    keywords, pages, is_downloadable, members_only, is_featured, is_published,
    download_count, created_at, updated_at
) VALUES 
(
    '地域経済統計レポート',
    '九州地域の最新経済動向を詳細に分析したレポートです。製造業、サービス業の動向と今後の展望について特集しています。',
    'regional',
    2024,
    '2024-04-28',
    'ちくぎん地域経済研究所',
    '株式会社ちくぎん地域経済研究所',
    '九州,地域経済,統計,製造業,サービス業',
    85,
    TRUE,
    TRUE,
    TRUE,
    156,
    NOW(),
    NOW()
),
(
    '四半期経済動向調査レポート（2024年第4四半期）',
    '2024年第4四半期の経済動向について詳細に調査・分析したレポートです。',
    'quarterly',
    2024,
    '2024-03-31',
    'ちくぎん地域経済研究所',
    '株式会社ちくぎん地域経済研究所',
    '四半期,経済動向,調査',
    7,
    TRUE,
    TRUE,
    FALSE,
    89,
    NOW(),
    NOW()
),
(
    '産業別統計分析レポート',
    '地域の主要産業について詳細な統計分析を行ったレポートです。',
    'industry',
    2024,
    '2024-01-15',
    'ちくぎん地域経済研究所',
    '株式会社ちくぎん地域経済研究所',
    '産業別,統計,分析',
    7,
    TRUE,
    TRUE,
    FALSE,
    67,
    NOW(),
    NOW()
),
(
    '年次経済統計（2023年版）',
    '2023年の経済統計を網羅的にまとめた年次レポートです。',
    'annual',
    2023,
    '2023-12-31',
    'ちくぎん地域経済研究所',
    '株式会社ちくぎん地域経済研究所',
    '年次,経済統計,2023',
    120,
    TRUE,
    TRUE,
    FALSE,
    234,
    NOW(),
    NOW()
)
ON CONFLICT DO NOTHING;

-- =====================================
-- ページコンテンツサンプルデータ
-- =====================================

INSERT INTO page_contents (page_key, title, content, meta_description, is_published, created_at, updated_at) VALUES
('home', 'トップページ', '{"hero_title": "ちくぎん地域経済研究所", "hero_subtitle": "地域経済の発展に貢献します", "description": "地域経済の調査・研究を通じて、九州地域の発展に貢献する研究機関です。"}', 'ちくぎん地域経済研究所のホームページ', TRUE, NOW(), NOW()),
('about', '会社概要', '{"title": "ちくぎん地域経済研究所について", "content": "私たちは地域経済の発展に貢献する研究機関として、調査研究活動を行っています。"}', '会社概要ページ', TRUE, NOW(), NOW()),
('services', 'サービス一覧', '{"title": "サービス一覧", "content": "経済調査、コンサルティング、セミナー開催など様々なサービスを提供しています。"}', 'サービス一覧ページ', TRUE, NOW(), NOW()),
('contact', 'お問い合わせ', '{"title": "お問い合わせ", "content": "ご質問やご相談がございましたら、お気軽にお問い合わせください。"}', 'お問い合わせページ', TRUE, NOW(), NOW()),
('faq', 'よくある質問', '{"title": "よくある質問", "content": "よくいただくご質問とその回答をまとめました。"}', 'よくある質問ページ', TRUE, NOW(), NOW()),
('privacy', 'プライバシーポリシー', '{"title": "プライバシーポリシー", "content": "個人情報の取り扱いについて"}', 'プライバシーポリシー', TRUE, NOW(), NOW()),
('terms', '利用規約', '{"title": "利用規約", "content": "サービス利用に関する規約"}', '利用規約', TRUE, NOW(), NOW())
ON CONFLICT (page_key) DO UPDATE SET
    title = EXCLUDED.title,
    content = EXCLUDED.content,
    updated_at = EXCLUDED.updated_at;

-- =====================================
-- ニュースサンプルデータ
-- =====================================

INSERT INTO news (
    title, slug, content, excerpt, category_id, is_important, is_published, is_featured,
    published_at, created_at, updated_at
) VALUES 
(
    'GW休業のお知らせ',
    'gw-holiday-notice-2025',
    'ゴールデンウィーク期間中の休業についてお知らせいたします。5月3日から5月6日まで休業いたします。',
    '5月3日から5月6日まで休業いたします。',
    1,
    TRUE,
    TRUE,
    FALSE,
    '2025-04-20 09:00:00',
    NOW(),
    NOW()
),
(
    'ホームページリニューアルのお知らせ',
    'website-renewal-2025',
    'より使いやすいホームページにリニューアルしました。新機能や改善点をご紹介します。',
    'より使いやすいホームページにリニューアルしました。',
    1,
    FALSE,
    TRUE,
    TRUE,
    '2025-04-15 10:00:00',
    NOW(),
    NOW()
),
(
    '新年度の経済展望について',
    'economic-outlook-2025',
    '2025年度の九州地域経済展望レポートを公開しました。主要産業の動向と予測をまとめています。',
    '2025年度の九州地域経済展望レポートを公開しました。',
    1,
    TRUE,
    TRUE,
    TRUE,
    '2025-04-01 14:00:00',
    NOW(),
    NOW()
)
ON CONFLICT (slug) DO UPDATE SET
    title = EXCLUDED.title,
    content = EXCLUDED.content,
    updated_at = EXCLUDED.updated_at;

-- =====================================
-- セミナー申込サンプルデータ
-- =====================================

-- テスト用の申込データ（セミナーIDと会員IDは実際の値に応じて調整）
INSERT INTO seminar_registrations (
    seminar_id, member_id, registration_date, status, approval_status,
    created_at, updated_at
) 
SELECT 
    s.id,
    m.id,
    NOW() - INTERVAL '1 day',
    'registered',
    'approved',
    NOW() - INTERVAL '1 day',
    NOW()
FROM seminars s
CROSS JOIN members m
WHERE s.title = 'DX推進セミナー' 
  AND m.email = 'test1@example.com'
  AND NOT EXISTS (
    SELECT 1 FROM seminar_registrations sr 
    WHERE sr.seminar_id = s.id AND sr.member_id = m.id
  );

-- =====================================
-- 完了メッセージ
-- =====================================

SELECT 'サンプルデータを含むデータベースバックアップが完了しました。' as status,
       (SELECT COUNT(*) FROM members) as total_members,
       (SELECT COUNT(*) FROM seminars) as total_seminars,
       (SELECT COUNT(*) FROM economic_reports) as total_reports;
