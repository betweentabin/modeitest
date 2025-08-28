-- ちくぎん地域経済研究所 データベース設計
-- 作成日: 2025-01-01

-- ==============================
-- 1. ユーザー管理
-- ==============================

-- 管理者テーブル
CREATE TABLE admins (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    role ENUM('super_admin', 'admin', 'editor') DEFAULT 'admin',
    is_active BOOLEAN DEFAULT TRUE,
    last_login_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_username (username)
);

-- 会員テーブル
CREATE TABLE members (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    company_name VARCHAR(200) NOT NULL,
    representative_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    postal_code VARCHAR(10),
    address TEXT,
    membership_type ENUM('basic', 'standard', 'premium') DEFAULT 'basic',
    status ENUM('pending', 'active', 'suspended', 'cancelled') DEFAULT 'pending',
    joined_date DATE,
    expiry_date DATE,
    last_login_at TIMESTAMP NULL,
    email_verified_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_membership_type (membership_type),
    INDEX idx_status (status)
);

-- 会員ログテーブル
CREATE TABLE member_activity_logs (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    member_id BIGINT NOT NULL,
    action_type ENUM('login', 'download', 'seminar_register', 'page_view') NOT NULL,
    target_id BIGINT NULL, -- 対象のID（セミナーID、刊行物IDなど）
    target_type VARCHAR(50) NULL, -- 対象の種類
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE,
    INDEX idx_member_id (member_id),
    INDEX idx_action_type (action_type),
    INDEX idx_created_at (created_at)
);

-- ==============================
-- 2. CMS・ページ管理
-- ==============================

-- ページテーブル
CREATE TABLE pages (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    page_key VARCHAR(100) UNIQUE NOT NULL, -- about, services, etc.
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(200) UNIQUE NOT NULL,
    meta_description TEXT,
    meta_keywords TEXT,
    content LONGTEXT,
    status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
    template VARCHAR(100) DEFAULT 'default',
    sort_order INT DEFAULT 0,
    is_system_page BOOLEAN DEFAULT FALSE, -- システム固定ページかどうか
    seo_title VARCHAR(200),
    created_by BIGINT,
    updated_by BIGINT,
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES admins(id) ON DELETE SET NULL,
    FOREIGN KEY (updated_by) REFERENCES admins(id) ON DELETE SET NULL,
    INDEX idx_page_key (page_key),
    INDEX idx_slug (slug),
    INDEX idx_status (status)
);

-- ==============================
-- 3. セミナー管理
-- ==============================

-- セミナーテーブル
CREATE TABLE seminars (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    detailed_description LONGTEXT,
    date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    location VARCHAR(200),
    capacity INT DEFAULT 0,
    current_participants INT DEFAULT 0,
    fee DECIMAL(10,2) DEFAULT 0.00,
    status ENUM('draft', 'scheduled', 'ongoing', 'completed', 'cancelled') DEFAULT 'draft',
    membership_requirement ENUM('none', 'basic', 'standard', 'premium') DEFAULT 'none',
    featured_image VARCHAR(500),
    application_deadline DATE,
    contact_email VARCHAR(255),
    contact_phone VARCHAR(20),
    notes TEXT,
    created_by BIGINT,
    updated_by BIGINT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES admins(id) ON DELETE SET NULL,
    FOREIGN KEY (updated_by) REFERENCES admins(id) ON DELETE SET NULL,
    INDEX idx_date (date),
    INDEX idx_status (status),
    INDEX idx_membership_requirement (membership_requirement)
);

-- セミナー申込テーブル
CREATE TABLE seminar_registrations (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    seminar_id BIGINT NOT NULL,
    member_id BIGINT NULL, -- NULL = 非会員申込
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    company VARCHAR(200),
    phone VARCHAR(20),
    special_requests TEXT,
    attendance_status ENUM('registered', 'attended', 'cancelled', 'no_show') DEFAULT 'registered',
    payment_status ENUM('pending', 'paid', 'refunded') DEFAULT 'pending',
    registration_number VARCHAR(50) UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (seminar_id) REFERENCES seminars(id) ON DELETE CASCADE,
    FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE SET NULL,
    INDEX idx_seminar_id (seminar_id),
    INDEX idx_member_id (member_id),
    INDEX idx_email (email),
    INDEX idx_registration_number (registration_number)
);

-- ==============================
-- 4. 刊行物管理
-- ==============================

-- 刊行物カテゴリテーブル
CREATE TABLE publication_categories (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    description TEXT,
    sort_order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_slug (slug),
    INDEX idx_sort_order (sort_order)
);

-- 刊行物テーブル
CREATE TABLE publications (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    content LONGTEXT,
    category_id BIGINT,
    publication_date DATE NOT NULL,
    author VARCHAR(200) DEFAULT 'ちくぎん地域経済研究所',
    pages INT DEFAULT 0,
    file_url VARCHAR(500),
    file_size DECIMAL(8,2), -- MB
    cover_image VARCHAR(500),
    membership_level ENUM('free', 'basic', 'standard', 'premium') DEFAULT 'free',
    download_count INT DEFAULT 0,
    is_published BOOLEAN DEFAULT FALSE,
    is_featured BOOLEAN DEFAULT FALSE,
    tags TEXT, -- カンマ区切り
    isbn VARCHAR(20),
    price DECIMAL(10,2) DEFAULT 0.00,
    created_by BIGINT,
    updated_by BIGINT,
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES publication_categories(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by) REFERENCES admins(id) ON DELETE SET NULL,
    FOREIGN KEY (updated_by) REFERENCES admins(id) ON DELETE SET NULL,
    INDEX idx_category_id (category_id),
    INDEX idx_publication_date (publication_date),
    INDEX idx_membership_level (membership_level),
    INDEX idx_is_published (is_published),
    INDEX idx_is_featured (is_featured)
);

-- 刊行物ダウンロードログテーブル
CREATE TABLE publication_downloads (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    publication_id BIGINT NOT NULL,
    member_id BIGINT NULL,
    ip_address VARCHAR(45),
    user_agent TEXT,
    downloaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (publication_id) REFERENCES publications(id) ON DELETE CASCADE,
    FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE SET NULL,
    INDEX idx_publication_id (publication_id),
    INDEX idx_member_id (member_id),
    INDEX idx_downloaded_at (downloaded_at)
);

-- ==============================
-- 5. お知らせ・ニュース管理
-- ==============================

-- お知らせカテゴリテーブル
CREATE TABLE news_categories (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    color VARCHAR(7) DEFAULT '#da5761', -- HEXカラーコード
    description TEXT,
    sort_order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_slug (slug),
    INDEX idx_sort_order (sort_order)
);

-- お知らせテーブル
CREATE TABLE news (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(200) UNIQUE NOT NULL,
    content LONGTEXT NOT NULL,
    excerpt TEXT,
    category_id BIGINT,
    featured_image VARCHAR(500),
    is_important BOOLEAN DEFAULT FALSE,
    is_published BOOLEAN DEFAULT FALSE,
    is_featured BOOLEAN DEFAULT FALSE,
    view_count INT DEFAULT 0,
    tags TEXT, -- カンマ区切り
    meta_description TEXT,
    created_by BIGINT,
    updated_by BIGINT,
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES news_categories(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by) REFERENCES admins(id) ON DELETE SET NULL,
    FOREIGN KEY (updated_by) REFERENCES admins(id) ON DELETE SET NULL,
    INDEX idx_slug (slug),
    INDEX idx_category_id (category_id),
    INDEX idx_is_published (is_published),
    INDEX idx_is_important (is_important),
    INDEX idx_is_featured (is_featured),
    INDEX idx_published_at (published_at)
);

-- ==============================
-- 6. メディア・ファイル管理
-- ==============================

-- メディアテーブル
CREATE TABLE media (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    filename VARCHAR(255) NOT NULL,
    original_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    file_size BIGINT NOT NULL, -- bytes
    mime_type VARCHAR(100) NOT NULL,
    file_extension VARCHAR(10) NOT NULL,
    alt_text TEXT,
    title VARCHAR(200),
    description TEXT,
    width INT NULL, -- 画像の場合
    height INT NULL, -- 画像の場合
    uploaded_by BIGINT,
    folder VARCHAR(200) DEFAULT 'uploads',
    is_public BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (uploaded_by) REFERENCES admins(id) ON DELETE SET NULL,
    INDEX idx_mime_type (mime_type),
    INDEX idx_uploaded_by (uploaded_by),
    INDEX idx_created_at (created_at)
);

-- ==============================
-- 7. お問い合わせ・フォーム管理
-- ==============================

-- お問い合わせカテゴリテーブル
CREATE TABLE inquiry_categories (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    email_template_id BIGINT NULL,
    sort_order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_sort_order (sort_order)
);

-- お問い合わせテーブル
CREATE TABLE inquiries (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    category_id BIGINT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    company VARCHAR(200),
    phone VARCHAR(20),
    subject VARCHAR(200) NOT NULL,
    message LONGTEXT NOT NULL,
    status ENUM('new', 'in_progress', 'resolved', 'closed') DEFAULT 'new',
    priority ENUM('low', 'normal', 'high', 'urgent') DEFAULT 'normal',
    assigned_to BIGINT NULL,
    ip_address VARCHAR(45),
    user_agent TEXT,
    response_sent_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES inquiry_categories(id) ON DELETE SET NULL,
    FOREIGN KEY (assigned_to) REFERENCES admins(id) ON DELETE SET NULL,
    INDEX idx_category_id (category_id),
    INDEX idx_status (status),
    INDEX idx_priority (priority),
    INDEX idx_assigned_to (assigned_to),
    INDEX idx_created_at (created_at)
);

-- お問い合わせ返信テーブル
CREATE TABLE inquiry_responses (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    inquiry_id BIGINT NOT NULL,
    message LONGTEXT NOT NULL,
    is_internal BOOLEAN DEFAULT FALSE, -- 内部メモかどうか
    created_by BIGINT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (inquiry_id) REFERENCES inquiries(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES admins(id) ON DELETE SET NULL,
    INDEX idx_inquiry_id (inquiry_id),
    INDEX idx_created_at (created_at)
);

-- ==============================
-- 8. システム設定・設定管理
-- ==============================

-- サイト設定テーブル
CREATE TABLE site_settings (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value LONGTEXT,
    setting_type ENUM('text', 'number', 'boolean', 'json', 'html') DEFAULT 'text',
    description TEXT,
    is_public BOOLEAN DEFAULT FALSE, -- フロントエンドで使用可能かどうか
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_setting_key (setting_key),
    INDEX idx_is_public (is_public)
);

-- ==============================
-- 9. 統計・分析
-- ==============================

-- ページビューテーブル
CREATE TABLE page_views (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    page_path VARCHAR(500) NOT NULL,
    page_title VARCHAR(200),
    referrer VARCHAR(500),
    ip_address VARCHAR(45),
    user_agent TEXT,
    session_id VARCHAR(100),
    member_id BIGINT NULL,
    view_duration INT NULL, -- 秒数
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE SET NULL,
    INDEX idx_page_path (page_path),
    INDEX idx_member_id (member_id),
    INDEX idx_created_at (created_at),
    INDEX idx_session_id (session_id)
);

-- ==============================
-- 10. 初期データ投入
-- ==============================

-- 管理者初期データ
INSERT INTO admins (username, email, password_hash, full_name, role) VALUES
('admin', 'admin@chikugin-cri.co.jp', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '管理者', 'super_admin');

-- サイト設定初期データ
INSERT INTO site_settings (setting_key, setting_value, setting_type, description, is_public) VALUES
('site_name', 'ちくぎん地域経済研究所', 'text', 'サイト名', true),
('site_description', '地域経済の発展に貢献する研究機関', 'text', 'サイト説明', true),
('contact_email', 'info@chikugin-cri.co.jp', 'text', 'お問い合わせメールアドレス', true),
('contact_phone', '0942-46-5091', 'text', '電話番号', true),
('contact_address', '〒839-0864 福岡県久留米市百年公園2番地1号久留米リサーチ・パーク内6階', 'text', '住所', true),
('business_hours', '平日9:00-17:00', 'text', '営業時間', true),
('membership_basic_price', '10000', 'number', 'ベーシック会員年会費', false),
('membership_standard_price', '20000', 'number', 'スタンダード会員年会費', false),
('membership_premium_price', '30000', 'number', 'プレミアム会員年会費', false);

-- お知らせカテゴリ初期データ
INSERT INTO news_categories (name, slug, color, description, sort_order) VALUES
('お知らせ', 'notice', '#da5761', '一般的なお知らせ', 1),
('重要', 'important', '#ff4444', '重要なお知らせ', 2),
('イベント', 'event', '#4CAF50', 'イベント情報', 3),
('メディア', 'media', '#2196F3', 'メディア情報', 4);

-- 刊行物カテゴリ初期データ
INSERT INTO publication_categories (name, slug, description, sort_order) VALUES
('調査研究', 'research', '調査研究レポート', 1),
('定期刊行物', 'quarterly', '定期的に発行される刊行物', 2),
('特別企画', 'special', '特別企画・特集', 3),
('統計資料', 'statistics', '経済統計資料', 4);

-- お問い合わせカテゴリ初期データ
INSERT INTO inquiry_categories (name, description, sort_order) VALUES
('一般的なお問い合わせ', '一般的なご質問・お問い合わせ', 1),
('会員について', '会員登録・会員サービスに関するお問い合わせ', 2),
('セミナーについて', 'セミナー・イベントに関するお問い合わせ', 3),
('刊行物について', '刊行物・資料に関するお問い合わせ', 4),
('その他', 'その他のお問い合わせ', 5);
