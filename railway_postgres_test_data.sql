-- Railway PostgreSQL用テストデータ挿入SQL
-- 注意: PostgreSQL用に構文を調整しています

-- ==============================
-- 1. お知らせ（news）テーブル用テストデータ
-- ==============================
-- まずカテゴリを確認/挿入
INSERT INTO news_categories (name, slug, color, description, sort_order) VALUES
('お知らせ', 'notice', '#da5761', '一般的なお知らせ', 1),
('重要', 'important', '#ff4444', '重要なお知らせ', 2),
('イベント', 'event', '#4CAF50', 'イベント情報', 3),
('メディア', 'media', '#2196F3', 'メディア情報', 4)
ON CONFLICT (slug) DO NOTHING;

-- お知らせデータを挿入
INSERT INTO news (title, slug, content, excerpt, category_id, is_important, is_published, published_at) VALUES
('2025年度経済展望セミナー開催のお知らせ', 'seminar-2025-economic-outlook', '来る3月15日に、2025年度の九州地域経済展望についてのセミナーを開催いたします。詳細は後日お知らせいたします。', '3月15日にセミナーを開催', (SELECT id FROM news_categories WHERE slug = 'notice'), true, true, '2025-01-15 10:00:00'),
('GW休業のお知らせ', 'gw-holiday-notice', '5月3日から5月6日まで休業いたします。ご不便をおかけしますが、よろしくお願いいたします。', 'GW期間中の休業について', (SELECT id FROM news_categories WHERE slug = 'important'), true, true, '2025-01-10 09:00:00'),
('ホームページリニューアルのお知らせ', 'website-renewal', 'より使いやすいホームページにリニューアルしました。新機能も追加されています。', 'ホームページをリニューアル', (SELECT id FROM news_categories WHERE slug = 'notice'), false, true, '2025-01-08 14:00:00'),
('新年のご挨拶', 'new-year-greeting-2025', '明けましておめでとうございます。本年もどうぞよろしくお願いいたします。', '新年のご挨拶', (SELECT id FROM news_categories WHERE slug = 'notice'), false, true, '2025-01-01 00:00:00'),
('年末年始休業のお知らせ', 'year-end-holiday-2024', '12月29日から1月3日まで年末年始休業とさせていただきます。', '年末年始の休業について', (SELECT id FROM news_categories WHERE slug = 'important'), true, true, '2024-12-25 15:00:00'),
('新刊「九州経済白書2024」発売', 'kyushu-economy-whitepaper-2024', '最新の九州経済白書が発売されました。会員様は特別価格でご購入いただけます。', '九州経済白書2024発売', (SELECT id FROM news_categories WHERE slug = 'notice'), false, true, '2024-12-20 10:00:00'),
('オンラインセミナー配信開始', 'online-seminar-start', 'オンラインでのセミナー配信サービスを開始しました。遠方の方もぜひご参加ください。', 'オンラインセミナー開始', (SELECT id FROM news_categories WHERE slug = 'event'), false, true, '2024-12-15 11:00:00'),
('会員限定イベント開催', 'member-exclusive-event', '12月10日に会員限定の交流イベントを開催いたしました。多数のご参加ありがとうございました。', '会員限定イベント報告', (SELECT id FROM news_categories WHERE slug = 'event'), false, true, '2024-12-11 16:00:00'),
('システムメンテナンスのお知らせ', 'system-maintenance-dec', '12月5日深夜にシステムメンテナンスを実施いたします。一時的にサービスが利用できなくなります。', 'システムメンテナンス実施', (SELECT id FROM news_categories WHERE slug = 'important'), true, true, '2024-12-01 09:00:00'),
('秋季セミナー満員御礼', 'autumn-seminar-full', '11月開催の秋季セミナーは定員に達しました。キャンセル待ちを受け付けております。', '秋季セミナー満員', (SELECT id FROM news_categories WHERE slug = 'event'), false, true, '2024-11-25 14:00:00');

-- ==============================
-- 2. セミナー（seminars）テーブル用テストデータ
-- ==============================
INSERT INTO seminars (
    title, description, detailed_description, date, start_time, end_time, 
    location, capacity, fee, status, featured_image, application_deadline
) VALUES
('採用力強化！経営・人事向け面接官トレーニングセミナー', 
 '優秀な人材を見極め、獲得するための面接技術を習得できるセミナーを開催します。', 
 '実践的なロールプレイングも含め、面接官として必要なスキルを体系的に学べます。', 
 '2025-02-15', '14:00:00', '17:00:00', 
 'ちくぎん地域経済研究所 会議室A', 30, 5000, 'scheduled', '/img/image-1.png', '2025-02-10'),

('DX推進セミナー', 
 'デジタルトランスフォーメーションの基礎から実践まで学べるセミナーです。', 
 '最新事例の紹介と、自社での導入方法について詳しく解説します。', 
 '2025-02-20', '13:00:00', '16:00:00', 
 'オンライン開催', 100, 3000, 'scheduled', '/img/image-1.png', '2025-02-18'),

('事業承継セミナー', 
 '円滑な事業承継のためのポイントを解説。', 
 '税務・法務の専門家も登壇し、実践的なアドバイスを提供します。', 
 '2025-03-10', '14:00:00', '17:00:00', 
 '久留米商工会議所 大ホール', 50, 0, 'scheduled', '/img/image-1.png', '2025-03-05'),

('SDGs経営入門セミナー', 
 'SDGsを経営に取り入れる方法を基礎から学べます。', 
 '先進企業の事例紹介と実践的なワークショップを行います。', 
 '2025-03-15', '13:30:00', '16:30:00', 
 'ちくぎん地域経済研究所 会議室B', 40, 4000, 'scheduled', '/img/image-1.png', '2025-03-10'),

('地域活性化フォーラム', 
 '地域経済の活性化について考えるフォーラム。', 
 'パネルディスカッションでは地域のキーパーソンが登壇します。', 
 '2025-03-25', '13:00:00', '17:00:00', 
 '久留米シティプラザ', 200, 0, 'scheduled', '/img/image-1.png', '2025-03-20'),

('マーケティング戦略セミナー', 
 '最新のマーケティング手法を学び、売上向上につなげる実践的セミナー。', 
 'デジタルマーケティングの活用方法も詳しく解説します。', 
 '2025-04-10', '14:00:00', '16:30:00', 
 'オンライン開催', 80, 3500, 'scheduled', '/img/image-1.png', '2025-04-05'),

('人材育成セミナー', 
 '社員のモチベーション向上と能力開発の方法を学びます。', 
 '実際の成功事例を交えながら、実践的な手法を紹介します。', 
 '2025-04-20', '13:30:00', '16:00:00', 
 'ちくぎん地域経済研究所 会議室A', 35, 4500, 'scheduled', '/img/image-1.png', '2025-04-15'),

('財務分析基礎講座', 
 '財務諸表の読み方から経営分析まで、基礎から学べる講座です。', 
 '実際の財務諸表を使った演習も行います。', 
 '2025-05-15', '13:00:00', '17:00:00', 
 'ちくぎん地域経済研究所 会議室B', 25, 6000, 'scheduled', '/img/image-1.png', '2025-05-10'),

('働き方改革セミナー', 
 '働き方改革の最新動向と実践方法について解説します。', 
 '生産性向上と従業員満足度の両立について考えます。', 
 '2025-05-25', '14:00:00', '16:00:00', 
 'オンライン開催', 60, 2500, 'scheduled', '/img/image-1.png', '2025-05-20'),

('観光ビジネスセミナー', 
 '観光業界の最新トレンドとビジネスチャンスについて学びます。', 
 'インバウンド対応やDX活用についても詳しく解説します。', 
 '2025-06-10', '13:30:00', '16:30:00', 
 '久留米商工会議所 中会議室', 45, 3500, 'scheduled', '/img/image-1.png', '2025-06-05');

-- ==============================
-- 3. 刊行物（publications）テーブル用テストデータ
-- ==============================
-- まずカテゴリを確認/挿入
INSERT INTO publication_categories (name, slug, description, sort_order) VALUES
('調査研究', 'research', '調査研究レポート', 1),
('定期刊行物', 'quarterly', '定期的に発行される刊行物', 2),
('特別企画', 'special', '特別企画・特集', 3),
('統計資料', 'statistics', '経済統計資料', 4)
ON CONFLICT (slug) DO NOTHING;

-- 刊行物データを挿入
INSERT INTO publications (
    title, description, publication_date, category_id,
    author, pages, file_url, cover_image, file_size, 
    download_count, is_published, membership_level, published_at
) VALUES
('事業継承から描く九州の未来', 
 '最新の地域経済動向レポート。九州地域の製造業の動向と今後の展望について特集。', 
 '2025-01-28', (SELECT id FROM publication_categories WHERE slug = 'research'),
 'ちくぎん地域経済研究所', 45, '/files/kyushu-future.pdf', '/img/image-1.png', 2.1, 
 234, true, 'premium', '2025-01-28 10:00:00'),

('経営参考BOOK vol.52', 
 '事業承継をテーマに、成功事例と具体的な進め方を解説。', 
 '2025-01-25', (SELECT id FROM publication_categories WHERE slug = 'quarterly'),
 'ちくぎん地域経済研究所', 32, '/files/management-book-52.pdf', '/img/image-1.png', 1.8, 
 156, true, 'standard', '2025-01-25 10:00:00'),

('Hot Information Vol.323', 
 '2025年度の経済展望と地域企業が取り組むべき課題について特集。', 
 '2025-01-20', (SELECT id FROM publication_categories WHERE slug = 'special'),
 'ちくぎん地域経済研究所', 28, '/files/hot-info-323.pdf', '/img/image-1.png', 1.5, 
 89, true, 'basic', '2025-01-20 10:00:00'),

('Hot Information Vol.324', 
 'DX推進のポイントや、新たな成長戦略について詳しく解説。', 
 '2025-01-15', (SELECT id FROM publication_categories WHERE slug = 'special'),
 'ちくぎん地域経済研究所', 35, '/files/hot-info-324.pdf', '/img/image-1.png', 2.0, 
 45, true, 'free', '2025-01-15 10:00:00'),

('九州経済白書2024', 
 '九州地域の経済動向を詳細に分析した年次レポート。', 
 '2024-12-20', (SELECT id FROM publication_categories WHERE slug = 'research'),
 'ちくぎん地域経済研究所', 120, '/files/kyushu-whitepaper-2024.pdf', '/img/image-1.png', 5.5, 
 567, true, 'premium', '2024-12-20 10:00:00'),

('中小企業のDX推進ガイド', 
 'DX導入の具体的な手順と成功事例を紹介。', 
 '2024-12-15', (SELECT id FROM publication_categories WHERE slug = 'special'),
 'ちくぎん地域経済研究所', 48, '/files/dx-guide.pdf', '/img/image-1.png', 2.3, 
 123, true, 'standard', '2024-12-15 10:00:00'),

('地域経済レポート2024年11月号', 
 '11月の経済指標と分析レポート。', 
 '2024-11-30', (SELECT id FROM publication_categories WHERE slug = 'quarterly'),
 'ちくぎん地域経済研究所', 24, '/files/report-2024-11.pdf', '/img/image-1.png', 1.2, 
 78, true, 'basic', '2024-11-30 10:00:00'),

('SDGs経営実践ガイド', 
 'SDGsを経営に活かす方法を具体的に解説。', 
 '2024-11-20', (SELECT id FROM publication_categories WHERE slug = 'special'),
 'ちくぎん地域経済研究所', 56, '/files/sdgs-guide.pdf', '/img/image-1.png', 2.8, 
 145, true, 'standard', '2024-11-20 10:00:00'),

('観光産業の展望2024', 
 '九州地域の観光産業の現状と将来展望。', 
 '2024-11-15', (SELECT id FROM publication_categories WHERE slug = 'research'),
 'ちくぎん地域経済研究所', 38, '/files/tourism-2024.pdf', '/img/image-1.png', 1.9, 
 98, true, 'free', '2024-11-15 10:00:00'),

('人材採用・育成ハンドブック', 
 '効果的な採用と人材育成の方法を解説。', 
 '2024-11-10', (SELECT id FROM publication_categories WHERE slug = 'special'),
 'ちくぎん地域経済研究所', 42, '/files/hr-handbook.pdf', '/img/image-1.png', 2.0, 
 167, true, 'standard', '2024-11-10 10:00:00');

-- ==============================
-- 4. テスト用会員データ
-- ==============================
INSERT INTO members (
    email, password_hash, company_name, representative_name, 
    phone, membership_type, status, joined_date, expiry_date, email_verified_at
) VALUES
('test1@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
 '株式会社テスト商事', '山田太郎', '090-1234-5678', 
 'premium', 'active', '2024-01-15', '2025-01-15', '2024-01-15 10:00:00'),

('test2@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
 '有限会社サンプル', '鈴木花子', '090-2345-6789', 
 'standard', 'active', '2024-03-20', '2025-03-20', '2024-03-20 14:00:00'),

('test3@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
 'ABC工業株式会社', '佐藤次郎', '090-3456-7890', 
 'basic', 'active', '2024-06-10', '2025-06-10', '2024-06-10 09:00:00');

-- ==============================
-- 注意事項
-- ==============================
-- このSQLファイルをRailwayのPostgreSQLで実行する方法：
-- 1. Railwayダッシュボードにログイン
-- 2. PostgreSQLサービスを選択
-- 3. "Connect" タブから接続情報を取得
-- 4. psqlコマンドまたはTablePlusなどのGUIツールで接続
-- 5. このSQLファイルを実行

-- 接続例（psqlコマンド）：
-- psql "postgresql://postgres:PASSWORD@HOST:PORT/railway"

-- または、RailwayのCLIを使用：
-- railway run psql < railway_postgres_test_data.sql