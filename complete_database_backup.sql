-- =====================================
-- 完全データベース復元用SQLファイル
-- 作成日: 2025年1月12日
-- 説明: Railway PostgreSQLの完全なスキーマとデータ
-- =====================================

-- PostgreSQL拡張の有効化
CREATE EXTENSION IF NOT EXISTS pgcrypto;

-- =====================================
-- 管理者テーブル (admins)
-- =====================================
CREATE TABLE IF NOT EXISTS admins (
    id BIGSERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    role VARCHAR(255) NOT NULL DEFAULT 'admin' 
        CHECK (role IN ('super_admin', 'admin', 'editor')),
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    last_login_at TIMESTAMP(0) WITHOUT TIME ZONE,
    created_at TIMESTAMP(0) WITHOUT TIME ZONE,
    updated_at TIMESTAMP(0) WITHOUT TIME ZONE,
    failed_attempts INTEGER NOT NULL DEFAULT 0,
    locked_until TIMESTAMP(0) WITHOUT TIME ZONE,
    mfa_enabled BOOLEAN NOT NULL DEFAULT FALSE,
    mfa_secret VARCHAR(255)
);

CREATE INDEX IF NOT EXISTS admins_email_index ON admins (email);
CREATE INDEX IF NOT EXISTS admins_username_index ON admins (username);

-- =====================================
-- 会員テーブル (members)
-- =====================================
CREATE TABLE IF NOT EXISTS members (
    id BIGSERIAL PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    company_name VARCHAR(200) NOT NULL,
    representative_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    postal_code VARCHAR(10),
    address TEXT,
    membership_type VARCHAR(255) NOT NULL DEFAULT 'basic' 
        CHECK (membership_type IN ('free', 'basic', 'standard', 'premium')),
    status VARCHAR(255) NOT NULL DEFAULT 'pending' 
        CHECK (status IN ('pending', 'active', 'suspended', 'cancelled')),
    joined_date DATE,
    expiry_date DATE,
    email_verified_at TIMESTAMP(0) WITHOUT TIME ZONE,
    created_at TIMESTAMP(0) WITHOUT TIME ZONE,
    updated_at TIMESTAMP(0) WITHOUT TIME ZONE,
    membership_expires_at TIMESTAMP(0) WITHOUT TIME ZONE,
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    position VARCHAR(100),
    department VARCHAR(100),
    capital BIGINT,
    industry VARCHAR(100),
    region VARCHAR(100),
    concerns TEXT,
    notes TEXT,
    started_at TIMESTAMP(0) WITHOUT TIME ZONE
);

CREATE INDEX IF NOT EXISTS members_email_index ON members (email);
CREATE INDEX IF NOT EXISTS members_membership_type_index ON members (membership_type);
CREATE INDEX IF NOT EXISTS members_status_index ON members (status);
CREATE INDEX IF NOT EXISTS members_is_active_index ON members (is_active);

-- =====================================
-- 地域マスターテーブル (regions)
-- =====================================
CREATE TABLE IF NOT EXISTS regions (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(10) NOT NULL UNIQUE,
    created_at TIMESTAMP(0) WITHOUT TIME ZONE,
    updated_at TIMESTAMP(0) WITHOUT TIME ZONE
);

-- =====================================
-- 業界マスターテーブル (industries)
-- =====================================
CREATE TABLE IF NOT EXISTS industries (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(10) NOT NULL UNIQUE,
    created_at TIMESTAMP(0) WITHOUT TIME ZONE,
    updated_at TIMESTAMP(0) WITHOUT TIME ZONE
);

-- =====================================
-- メールグループテーブル (mail_groups)
-- =====================================
CREATE TABLE IF NOT EXISTS mail_groups (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    created_by BIGINT,
    created_at TIMESTAMP(0) WITHOUT TIME ZONE,
    updated_at TIMESTAMP(0) WITHOUT TIME ZONE,
    FOREIGN KEY (created_by) REFERENCES admins(id) ON DELETE SET NULL
);

-- =====================================
-- メールグループメンバーテーブル (mail_group_members)
-- =====================================
CREATE TABLE IF NOT EXISTS mail_group_members (
    id BIGSERIAL PRIMARY KEY,
    group_id BIGINT NOT NULL,
    member_id BIGINT NOT NULL,
    created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NOW(),
    FOREIGN KEY (group_id) REFERENCES mail_groups(id) ON DELETE CASCADE,
    FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE,
    UNIQUE(group_id, member_id)
);

CREATE INDEX IF NOT EXISTS mail_group_members_group_id_index ON mail_group_members (group_id);
CREATE INDEX IF NOT EXISTS mail_group_members_member_id_index ON mail_group_members (member_id);

-- =====================================
-- メールキャンペーンテーブル (email_campaigns)
-- =====================================
CREATE TABLE IF NOT EXISTS email_campaigns (
    id BIGSERIAL PRIMARY KEY,
    subject VARCHAR(255) NOT NULL,
    body_html TEXT,
    body_text TEXT,
    status VARCHAR(50) NOT NULL DEFAULT 'draft' 
        CHECK (status IN ('draft', 'scheduled', 'sending', 'sent', 'failed')),
    scheduled_at TIMESTAMP(0) WITHOUT TIME ZONE,
    created_by BIGINT,
    created_at TIMESTAMP(0) WITHOUT TIME ZONE,
    updated_at TIMESTAMP(0) WITHOUT TIME ZONE,
    is_template BOOLEAN NOT NULL DEFAULT FALSE,
    FOREIGN KEY (created_by) REFERENCES admins(id) ON DELETE SET NULL
);

CREATE INDEX IF NOT EXISTS email_campaigns_status_index ON email_campaigns (status);
CREATE INDEX IF NOT EXISTS email_campaigns_scheduled_at_index ON email_campaigns (scheduled_at);

-- =====================================
-- メール受信者テーブル (email_recipients)
-- =====================================
CREATE TABLE IF NOT EXISTS email_recipients (
    id BIGSERIAL PRIMARY KEY,
    campaign_id BIGINT NOT NULL,
    email VARCHAR(255) NOT NULL,
    member_id BIGINT,
    status VARCHAR(50) NOT NULL DEFAULT 'pending' 
        CHECK (status IN ('pending', 'sent', 'failed')),
    sent_at TIMESTAMP(0) WITHOUT TIME ZONE,
    error TEXT,
    created_at TIMESTAMP(0) WITHOUT TIME ZONE,
    updated_at TIMESTAMP(0) WITHOUT TIME ZONE,
    FOREIGN KEY (campaign_id) REFERENCES email_campaigns(id) ON DELETE CASCADE,
    FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE
);

CREATE INDEX IF NOT EXISTS email_recipients_campaign_id_index ON email_recipients (campaign_id);
CREATE INDEX IF NOT EXISTS email_recipients_status_index ON email_recipients (status);
CREATE INDEX IF NOT EXISTS email_recipients_email_index ON email_recipients (email);

-- =====================================
-- メール添付ファイルテーブル (email_attachments)
-- =====================================
CREATE TABLE IF NOT EXISTS email_attachments (
    id BIGSERIAL PRIMARY KEY,
    campaign_id BIGINT NOT NULL,
    filename VARCHAR(255) NOT NULL,
    original_filename VARCHAR(255) NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    file_size BIGINT NOT NULL,
    mime_type VARCHAR(100) NOT NULL,
    created_at TIMESTAMP(0) WITHOUT TIME ZONE,
    updated_at TIMESTAMP(0) WITHOUT TIME ZONE,
    FOREIGN KEY (campaign_id) REFERENCES email_campaigns(id) ON DELETE CASCADE
);

-- =====================================
-- 会員お気に入りテーブル (member_favorites)
-- =====================================
CREATE TABLE IF NOT EXISTS member_favorites (
    id BIGSERIAL PRIMARY KEY,
    member_id BIGINT NOT NULL,
    favorite_member_id BIGINT NOT NULL,
    created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NOW(),
    FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE,
    FOREIGN KEY (favorite_member_id) REFERENCES members(id) ON DELETE CASCADE,
    UNIQUE(member_id, favorite_member_id),
    CHECK (member_id <> favorite_member_id)
);

CREATE INDEX IF NOT EXISTS member_favorites_member_id_index ON member_favorites (member_id);
CREATE INDEX IF NOT EXISTS member_favorites_favorite_member_id_index ON member_favorites (favorite_member_id);

-- =====================================
-- セミナーテーブル (seminars)
-- =====================================
CREATE TABLE IF NOT EXISTS seminars (
    id BIGSERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    date DATE NOT NULL,
    start_time TIME WITHOUT TIME ZONE,
    end_time TIME WITHOUT TIME ZONE,
    location VARCHAR(255),
    capacity INTEGER,
    fee DECIMAL(10,2) DEFAULT 0.00,
    status VARCHAR(50) NOT NULL DEFAULT 'scheduled' 
        CHECK (status IN ('scheduled', 'ongoing', 'completed', 'cancelled')),
    category VARCHAR(100),
    is_members_only BOOLEAN NOT NULL DEFAULT FALSE,
    registration_deadline DATE,
    image_url VARCHAR(500),
    created_by BIGINT,
    updated_by BIGINT,
    created_at TIMESTAMP(0) WITHOUT TIME ZONE,
    updated_at TIMESTAMP(0) WITHOUT TIME ZONE,
    premium_open_at TIMESTAMP(0) WITHOUT TIME ZONE,
    standard_open_at TIMESTAMP(0) WITHOUT TIME ZONE,
    free_open_at TIMESTAMP(0) WITHOUT TIME ZONE,
    FOREIGN KEY (created_by) REFERENCES admins(id) ON DELETE SET NULL,
    FOREIGN KEY (updated_by) REFERENCES admins(id) ON DELETE SET NULL
);

CREATE INDEX IF NOT EXISTS seminars_date_index ON seminars (date);
CREATE INDEX IF NOT EXISTS seminars_status_index ON seminars (status);
CREATE INDEX IF NOT EXISTS seminars_category_index ON seminars (category);

-- =====================================
-- セミナー申込テーブル (seminar_registrations)
-- =====================================
CREATE TABLE IF NOT EXISTS seminar_registrations (
    id BIGSERIAL PRIMARY KEY,
    seminar_id BIGINT NOT NULL,
    member_id BIGINT NOT NULL,
    registration_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NOW(),
    status VARCHAR(50) NOT NULL DEFAULT 'registered' 
        CHECK (status IN ('registered', 'attended', 'absent', 'cancelled')),
    notes TEXT,
    created_at TIMESTAMP(0) WITHOUT TIME ZONE,
    updated_at TIMESTAMP(0) WITHOUT TIME ZONE,
    approval_status VARCHAR(50) NOT NULL DEFAULT 'pending' 
        CHECK (approval_status IN ('pending', 'approved', 'rejected')),
    approved_at TIMESTAMP(0) WITHOUT TIME ZONE,
    rejected_at TIMESTAMP(0) WITHOUT TIME ZONE,
    approved_by BIGINT,
    FOREIGN KEY (seminar_id) REFERENCES seminars(id) ON DELETE CASCADE,
    FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE,
    FOREIGN KEY (approved_by) REFERENCES admins(id) ON DELETE SET NULL,
    UNIQUE(seminar_id, member_id)
);

CREATE INDEX IF NOT EXISTS seminar_registrations_seminar_id_index ON seminar_registrations (seminar_id);
CREATE INDEX IF NOT EXISTS seminar_registrations_member_id_index ON seminar_registrations (member_id);
CREATE INDEX IF NOT EXISTS seminar_registrations_approval_status_index ON seminar_registrations (seminar_id, approval_status);

-- =====================================
-- セミナーお気に入りテーブル (seminar_favorites)
-- =====================================
CREATE TABLE IF NOT EXISTS seminar_favorites (
    id BIGSERIAL PRIMARY KEY,
    member_id BIGINT NOT NULL,
    seminar_id BIGINT NOT NULL,
    created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NOW(),
    FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE,
    FOREIGN KEY (seminar_id) REFERENCES seminars(id) ON DELETE CASCADE,
    UNIQUE(member_id, seminar_id)
);

-- =====================================
-- 経済統計レポートテーブル (economic_reports)
-- =====================================
CREATE TABLE IF NOT EXISTS economic_reports (
    id BIGSERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    category VARCHAR(100) NOT NULL DEFAULT 'quarterly' 
        CHECK (category IN ('quarterly', 'annual', 'regional', 'industry')),
    year INTEGER NOT NULL,
    publication_date DATE NOT NULL,
    author VARCHAR(255) DEFAULT 'ちくぎん地域経済研究所',
    publisher VARCHAR(255) DEFAULT '株式会社ちくぎん地域経済研究所',
    keywords TEXT,
    cover_image VARCHAR(500),
    file_url VARCHAR(500),
    file_size BIGINT,
    pages INTEGER DEFAULT 0,
    is_downloadable BOOLEAN NOT NULL DEFAULT TRUE,
    members_only BOOLEAN NOT NULL DEFAULT TRUE,
    is_featured BOOLEAN NOT NULL DEFAULT FALSE,
    is_published BOOLEAN NOT NULL DEFAULT FALSE,
    download_count INTEGER NOT NULL DEFAULT 0,
    sort_order INTEGER DEFAULT 0,
    created_at TIMESTAMP(0) WITHOUT TIME ZONE,
    updated_at TIMESTAMP(0) WITHOUT TIME ZONE
);

CREATE INDEX IF NOT EXISTS economic_reports_category_index ON economic_reports (category);
CREATE INDEX IF NOT EXISTS economic_reports_year_index ON economic_reports (year);
CREATE INDEX IF NOT EXISTS economic_reports_publication_date_index ON economic_reports (publication_date);
CREATE INDEX IF NOT EXISTS economic_reports_is_published_index ON economic_reports (is_published);
CREATE INDEX IF NOT EXISTS economic_reports_is_featured_index ON economic_reports (is_featured);

-- =====================================
-- ページコンテンツテーブル (page_contents)
-- =====================================
CREATE TABLE IF NOT EXISTS page_contents (
    id BIGSERIAL PRIMARY KEY,
    page_key VARCHAR(100) NOT NULL UNIQUE,
    title VARCHAR(255) NOT NULL,
    content TEXT,
    meta_description TEXT,
    meta_keywords TEXT,
    is_published BOOLEAN NOT NULL DEFAULT TRUE,
    sort_order INTEGER DEFAULT 0,
    created_at TIMESTAMP(0) WITHOUT TIME ZONE,
    updated_at TIMESTAMP(0) WITHOUT TIME ZONE
);

CREATE INDEX IF NOT EXISTS page_contents_page_key_index ON page_contents (page_key);
CREATE INDEX IF NOT EXISTS page_contents_is_published_index ON page_contents (is_published);

-- =====================================
-- ニュースカテゴリテーブル (news_categories)
-- =====================================
CREATE TABLE IF NOT EXISTS news_categories (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    sort_order INTEGER DEFAULT 0,
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP(0) WITHOUT TIME ZONE,
    updated_at TIMESTAMP(0) WITHOUT TIME ZONE
);

-- =====================================
-- ニューステーブル (news)
-- =====================================
CREATE TABLE IF NOT EXISTS news (
    id BIGSERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE,
    content TEXT,
    excerpt TEXT,
    category_id BIGINT,
    featured_image VARCHAR(500),
    is_important BOOLEAN NOT NULL DEFAULT FALSE,
    is_published BOOLEAN NOT NULL DEFAULT FALSE,
    is_featured BOOLEAN NOT NULL DEFAULT FALSE,
    view_count INTEGER NOT NULL DEFAULT 0,
    tags TEXT,
    meta_description TEXT,
    published_at TIMESTAMP(0) WITHOUT TIME ZONE,
    created_at TIMESTAMP(0) WITHOUT TIME ZONE,
    updated_at TIMESTAMP(0) WITHOUT TIME ZONE,
    FOREIGN KEY (category_id) REFERENCES news_categories(id) ON DELETE SET NULL
);

CREATE INDEX IF NOT EXISTS news_published_at_index ON news (published_at);
CREATE INDEX IF NOT EXISTS news_is_published_index ON news (is_published);
CREATE INDEX IF NOT EXISTS news_category_id_index ON news (category_id);

-- =====================================
-- 刊行物カテゴリテーブル (publication_categories)
-- =====================================
CREATE TABLE IF NOT EXISTS publication_categories (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    sort_order INTEGER DEFAULT 0,
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP(0) WITHOUT TIME ZONE,
    updated_at TIMESTAMP(0) WITHOUT TIME ZONE
);

-- =====================================
-- 刊行物テーブル (publications)
-- =====================================
CREATE TABLE IF NOT EXISTS publications (
    id BIGSERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    category_id BIGINT,
    publication_date DATE,
    author VARCHAR(255),
    publisher VARCHAR(255),
    isbn VARCHAR(20),
    pages INTEGER,
    price DECIMAL(10,2),
    cover_image VARCHAR(500),
    file_url VARCHAR(500),
    file_size BIGINT,
    is_downloadable BOOLEAN NOT NULL DEFAULT TRUE,
    members_only BOOLEAN NOT NULL DEFAULT FALSE,
    is_featured BOOLEAN NOT NULL DEFAULT FALSE,
    is_published BOOLEAN NOT NULL DEFAULT FALSE,
    download_count INTEGER NOT NULL DEFAULT 0,
    view_count INTEGER NOT NULL DEFAULT 0,
    sort_order INTEGER DEFAULT 0,
    created_at TIMESTAMP(0) WITHOUT TIME ZONE,
    updated_at TIMESTAMP(0) WITHOUT TIME ZONE,
    FOREIGN KEY (category_id) REFERENCES publication_categories(id) ON DELETE SET NULL
);

-- =====================================
-- その他のシステムテーブル
-- =====================================

-- Laravelのジョブテーブル
CREATE TABLE IF NOT EXISTS jobs (
    id BIGSERIAL PRIMARY KEY,
    queue VARCHAR(255) NOT NULL,
    payload TEXT NOT NULL,
    attempts INTEGER NOT NULL,
    reserved_at INTEGER,
    available_at INTEGER NOT NULL,
    created_at INTEGER NOT NULL
);

CREATE INDEX IF NOT EXISTS jobs_queue_index ON jobs (queue);

-- 失敗したジョブテーブル
CREATE TABLE IF NOT EXISTS failed_jobs (
    id BIGSERIAL PRIMARY KEY,
    uuid VARCHAR(255) NOT NULL UNIQUE,
    connection TEXT NOT NULL,
    queue TEXT NOT NULL,
    payload TEXT NOT NULL,
    exception TEXT NOT NULL,
    failed_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NOW()
);

-- パスワードリセットトークンテーブル
CREATE TABLE IF NOT EXISTS password_reset_tokens (
    email VARCHAR(255) NOT NULL,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP(0) WITHOUT TIME ZONE,
    PRIMARY KEY (email)
);

-- 個人アクセストークンテーブル (Laravel Sanctum)
CREATE TABLE IF NOT EXISTS personal_access_tokens (
    id BIGSERIAL PRIMARY KEY,
    tokenable_type VARCHAR(255) NOT NULL,
    tokenable_id BIGINT NOT NULL,
    name VARCHAR(255) NOT NULL,
    token VARCHAR(64) NOT NULL UNIQUE,
    abilities TEXT,
    last_used_at TIMESTAMP(0) WITHOUT TIME ZONE,
    expires_at TIMESTAMP(0) WITHOUT TIME ZONE,
    created_at TIMESTAMP(0) WITHOUT TIME ZONE,
    updated_at TIMESTAMP(0) WITHOUT TIME ZONE
);

CREATE INDEX IF NOT EXISTS personal_access_tokens_tokenable_index ON personal_access_tokens (tokenable_type, tokenable_id);

-- =====================================
-- 初期データの挿入
-- =====================================

-- 管理者アカウント
INSERT INTO admins (username, email, password, full_name, role, created_at, updated_at) 
VALUES 
('admin', 'admin@example.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '管理者', 'admin', NOW(), NOW())
ON CONFLICT (email) DO NOTHING;

-- 地域マスターデータ
INSERT INTO regions (name, code, created_at, updated_at) VALUES
('北海道', 'hokkaido', NOW(), NOW()),
('東北', 'tohoku', NOW(), NOW()),
('関東', 'kanto', NOW(), NOW()),
('中部', 'chubu', NOW(), NOW()),
('関西', 'kansai', NOW(), NOW()),
('中国', 'chugoku', NOW(), NOW()),
('四国', 'shikoku', NOW(), NOW()),
('九州', 'kyushu', NOW(), NOW()),
('沖縄', 'okinawa', NOW(), NOW())
ON CONFLICT (code) DO NOTHING;

-- 業界マスターデータ
INSERT INTO industries (name, code, created_at, updated_at) VALUES
('製造業', 'manufacturing', NOW(), NOW()),
('建設業', 'construction', NOW(), NOW()),
('小売業', 'retail', NOW(), NOW()),
('卸売業', 'wholesale', NOW(), NOW()),
('金融業', 'finance', NOW(), NOW()),
('不動産業', 'realestate', NOW(), NOW()),
('情報通信業', 'it', NOW(), NOW()),
('運輸業', 'transportation', NOW(), NOW()),
('医療・福祉', 'healthcare', NOW(), NOW()),
('教育', 'education', NOW(), NOW()),
('サービス業', 'service', NOW(), NOW()),
('農林水産業', 'agriculture', NOW(), NOW())
ON CONFLICT (code) DO NOTHING;

-- ニュースカテゴリ
INSERT INTO news_categories (name, slug, description, sort_order, created_at, updated_at) VALUES
('お知らせ', 'notice', '一般的なお知らせ', 1, NOW(), NOW()),
('重要', 'important', '重要なお知らせ', 2, NOW(), NOW()),
('イベント', 'event', 'イベント情報', 3, NOW(), NOW()),
('セミナー', 'seminar', 'セミナー関連', 4, NOW(), NOW())
ON CONFLICT (slug) DO NOTHING;

-- 刊行物カテゴリ
INSERT INTO publication_categories (name, slug, description, sort_order, created_at, updated_at) VALUES
('四半期レポート', 'quarterly', '四半期経済レポート', 1, NOW(), NOW()),
('年次レポート', 'annual', '年次経済統計', 2, NOW(), NOW()),
('地域調査', 'regional', '地域経済調査', 3, NOW(), NOW()),
('産業分析', 'industry', '産業別統計', 4, NOW(), NOW()),
('特集', 'special', '特集記事', 5, NOW(), NOW())
ON CONFLICT (slug) DO NOTHING;

-- =====================================
-- ビューの作成
-- =====================================

-- アクティブ会員ビュー
CREATE OR REPLACE VIEW active_members AS
SELECT *
FROM members
WHERE status = 'active' AND is_active = TRUE;

-- 有効な会員種別ビュー
CREATE OR REPLACE VIEW valid_members AS
SELECT *
FROM members
WHERE status = 'active' 
  AND is_active = TRUE 
  AND (membership_expires_at IS NULL OR membership_expires_at > NOW());

-- 公開されたニュースビュー
CREATE OR REPLACE VIEW published_news AS
SELECT n.*, nc.name as category_name
FROM news n
LEFT JOIN news_categories nc ON n.category_id = nc.id
WHERE n.is_published = TRUE
ORDER BY n.published_at DESC;

-- 公開された刊行物ビュー
CREATE OR REPLACE VIEW published_publications AS
SELECT p.*, pc.name as category_name
FROM publications p
LEFT JOIN publication_categories pc ON p.category_id = pc.id
WHERE p.is_published = TRUE
ORDER BY p.publication_date DESC;

-- =====================================
-- コメント
-- =====================================

COMMENT ON DATABASE railway IS '会員管理システム - メインデータベース';
COMMENT ON TABLE admins IS '管理者アカウント';
COMMENT ON TABLE members IS '会員情報';
COMMENT ON TABLE mail_groups IS 'メール配信グループ';
COMMENT ON TABLE email_campaigns IS 'メールキャンペーン';
COMMENT ON TABLE member_favorites IS '会員お気に入り';
COMMENT ON TABLE seminars IS 'セミナー情報';
COMMENT ON TABLE economic_reports IS '経済統計レポート';
COMMENT ON TABLE page_contents IS 'CMSページコンテンツ';

-- 作成完了メッセージ
SELECT 'データベースの復元が完了しました。' as status;
