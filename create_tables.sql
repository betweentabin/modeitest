-- セミナーテーブル
CREATE TABLE IF NOT EXISTS seminars (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    detailed_description TEXT,
    date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    location VARCHAR(255),
    capacity INTEGER DEFAULT 0,
    current_participants INTEGER DEFAULT 0,
    fee DECIMAL(10,2) DEFAULT 0,
    status VARCHAR(20) DEFAULT 'draft' CHECK (status IN ('draft', 'scheduled', 'ongoing', 'completed', 'cancelled')),
    featured_image VARCHAR(255),
    application_deadline DATE,
    contact_email VARCHAR(255),
    contact_phone VARCHAR(255),
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 刊行物カテゴリテーブル
CREATE TABLE IF NOT EXISTS publication_categories (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    description TEXT,
    sort_order INTEGER DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 刊行物テーブル
CREATE TABLE IF NOT EXISTS publications (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    content TEXT,
    category_id INTEGER REFERENCES publication_categories(id) ON DELETE SET NULL,
    publication_date DATE NOT NULL,
    author VARCHAR(255) DEFAULT 'ちくぎん地域経済研究所',
    pages INTEGER DEFAULT 0,
    file_url VARCHAR(255),
    file_size DECIMAL(8,2),
    cover_image VARCHAR(255),
    membership_level VARCHAR(20) DEFAULT 'free' CHECK (membership_level IN ('free', 'basic', 'standard', 'premium')),
    download_count INTEGER DEFAULT 0,
    is_published BOOLEAN DEFAULT FALSE,
    is_featured BOOLEAN DEFAULT FALSE,
    tags TEXT,
    isbn VARCHAR(20),
    price DECIMAL(10,2) DEFAULT 0,
    published_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- お知らせカテゴリテーブル
CREATE TABLE IF NOT EXISTS news_categories (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    color VARCHAR(7) DEFAULT '#da5761',
    description TEXT,
    sort_order INTEGER DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- お知らせテーブル
CREATE TABLE IF NOT EXISTS news (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    content TEXT NOT NULL,
    excerpt TEXT,
    category_id INTEGER REFERENCES news_categories(id) ON DELETE SET NULL,
    featured_image VARCHAR(255),
    is_important BOOLEAN DEFAULT FALSE,
    is_published BOOLEAN DEFAULT FALSE,
    is_featured BOOLEAN DEFAULT FALSE,
    view_count INTEGER DEFAULT 0,
    tags TEXT,
    meta_description TEXT,
    published_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 管理者テーブル
CREATE TABLE IF NOT EXISTS admins (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    role VARCHAR(20) DEFAULT 'admin' CHECK (role IN ('super_admin', 'admin', 'editor')),
    is_active BOOLEAN DEFAULT TRUE,
    last_login_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 会員テーブル
CREATE TABLE IF NOT EXISTS members (
    id SERIAL PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    company_name VARCHAR(255) NOT NULL,
    representative_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    postal_code VARCHAR(10),
    address TEXT,
    membership_type VARCHAR(20) DEFAULT 'basic' CHECK (membership_type IN ('basic', 'standard', 'premium')),
    status VARCHAR(20) DEFAULT 'pending' CHECK (status IN ('pending', 'active', 'suspended', 'cancelled')),
    joined_date DATE,
    expiry_date DATE,
    last_login_at TIMESTAMP,
    email_verified_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
