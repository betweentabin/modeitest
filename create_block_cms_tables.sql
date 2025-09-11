-- ブロック型CMS用テーブル作成SQL
-- PostgreSQL用 ULID対応版

-- ULID生成関数の作成
CREATE OR REPLACE FUNCTION generate_ulid() RETURNS TEXT AS $$
DECLARE
    -- Crockford's Base32
    encoding   TEXT := '0123456789ABCDEFGHJKMNPQRSTVWXYZ';
    timestamp  BIGINT;
    output     TEXT := '';
    randpart   TEXT := '';
    i          INTEGER;
BEGIN
    -- Get current timestamp in milliseconds
    timestamp := EXTRACT(EPOCH FROM NOW() AT TIME ZONE 'UTC') * 1000;
    
    -- Encode timestamp (10 characters)
    FOR i IN 1..10 LOOP
        output := SUBSTRING(encoding, ((timestamp % 32) + 1)::INTEGER, 1) || output;
        timestamp := timestamp / 32;
    END LOOP;
    
    -- Generate random part (16 characters)
    FOR i IN 1..16 LOOP
        randpart := randpart || SUBSTRING(encoding, (FLOOR(RANDOM() * 32) + 1)::INTEGER, 1);
    END LOOP;
    
    RETURN output || randpart;
END;
$$ LANGUAGE plpgsql;

-- 1. ブロックタイプ定義テーブル
CREATE TABLE IF NOT EXISTS block_types (
    id TEXT PRIMARY KEY DEFAULT generate_ulid(),
    name VARCHAR(255) NOT NULL UNIQUE,
    label VARCHAR(255) NOT NULL,
    icon VARCHAR(50),
    description TEXT,
    schema_definition JSONB NOT NULL,
    default_content JSONB,
    is_active BOOLEAN NOT NULL DEFAULT true,
    created_at TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- 2. ページマスタテーブル
CREATE TABLE IF NOT EXISTS cms_pages (
    id TEXT PRIMARY KEY DEFAULT generate_ulid(),
    page_key VARCHAR(255) NOT NULL UNIQUE,
    title VARCHAR(255) NOT NULL,
    meta_description TEXT,
    meta_keywords TEXT,
    og_image TEXT,
    template VARCHAR(255) DEFAULT 'default',
    is_published BOOLEAN NOT NULL DEFAULT false,
    published_at TIMESTAMP WITHOUT TIME ZONE,
    version INTEGER NOT NULL DEFAULT 1,
    created_by BIGINT REFERENCES users(id),
    updated_by BIGINT REFERENCES users(id),
    created_at TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- 3. ページブロックテーブル
CREATE TABLE IF NOT EXISTS page_blocks (
    id TEXT PRIMARY KEY DEFAULT generate_ulid(),
    page_id TEXT NOT NULL REFERENCES cms_pages(id) ON DELETE CASCADE,
    block_type_id TEXT NOT NULL REFERENCES block_types(id),
    parent_block_id TEXT REFERENCES page_blocks(id) ON DELETE CASCADE,
    title VARCHAR(255),
    content JSONB NOT NULL,
    media_data BYTEA, -- 画像バイナリデータ
    media_type VARCHAR(50), -- image/jpeg, image/png等
    sort_order INTEGER NOT NULL DEFAULT 0,
    is_visible BOOLEAN NOT NULL DEFAULT true,
    is_published BOOLEAN NOT NULL DEFAULT false,
    published_at TIMESTAMP WITHOUT TIME ZONE,
    created_by BIGINT REFERENCES users(id),
    updated_by BIGINT REFERENCES users(id),
    created_at TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- 4. 再利用可能ブロックテーブル
CREATE TABLE IF NOT EXISTS reusable_blocks (
    id TEXT PRIMARY KEY DEFAULT generate_ulid(),
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    block_type_id TEXT NOT NULL REFERENCES block_types(id),
    content JSONB NOT NULL,
    media_data BYTEA,
    media_type VARCHAR(50),
    category VARCHAR(100),
    is_active BOOLEAN NOT NULL DEFAULT true,
    created_by BIGINT REFERENCES users(id),
    updated_by BIGINT REFERENCES users(id),
    created_at TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- 5. ブロックバージョン履歴テーブル
CREATE TABLE IF NOT EXISTS block_versions (
    id TEXT PRIMARY KEY DEFAULT generate_ulid(),
    page_block_id TEXT REFERENCES page_blocks(id) ON DELETE CASCADE,
    reusable_block_id TEXT REFERENCES reusable_blocks(id) ON DELETE CASCADE,
    content JSONB NOT NULL,
    media_data BYTEA,
    media_type VARCHAR(50),
    version_number INTEGER NOT NULL,
    change_description TEXT,
    created_by BIGINT REFERENCES users(id),
    created_at TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    
    CONSTRAINT check_block_reference CHECK (
        (page_block_id IS NOT NULL AND reusable_block_id IS NULL) OR
        (page_block_id IS NULL AND reusable_block_id IS NOT NULL)
    )
);

-- 6. メディア管理テーブル（画像DB保存）
CREATE TABLE IF NOT EXISTS cms_media (
    id TEXT PRIMARY KEY DEFAULT generate_ulid(),
    filename VARCHAR(255) NOT NULL,
    alt_text TEXT,
    media_type VARCHAR(50) NOT NULL,
    media_data BYTEA NOT NULL,
    file_size INTEGER,
    width INTEGER,
    height INTEGER,
    metadata JSONB,
    uploaded_by BIGINT REFERENCES users(id),
    created_at TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- 7. ページ画像関連テーブル
CREATE TABLE IF NOT EXISTS page_media (
    id TEXT PRIMARY KEY DEFAULT generate_ulid(),
    page_id TEXT NOT NULL REFERENCES cms_pages(id) ON DELETE CASCADE,
    media_id TEXT NOT NULL REFERENCES cms_media(id) ON DELETE CASCADE,
    usage_type VARCHAR(50), -- hero, gallery, content等
    sort_order INTEGER DEFAULT 0,
    created_at TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- インデックスの作成
CREATE INDEX idx_page_blocks_page_id ON page_blocks(page_id);
CREATE INDEX idx_page_blocks_type ON page_blocks(block_type_id);
CREATE INDEX idx_page_blocks_published ON page_blocks(is_published, published_at);
CREATE INDEX idx_page_blocks_sort ON page_blocks(page_id, sort_order);
CREATE INDEX idx_page_blocks_parent ON page_blocks(parent_block_id);
CREATE INDEX idx_cms_pages_key ON cms_pages(page_key);
CREATE INDEX idx_cms_pages_published ON cms_pages(is_published, published_at);
CREATE INDEX idx_reusable_blocks_slug ON reusable_blocks(slug);
CREATE INDEX idx_reusable_blocks_category ON reusable_blocks(category);
CREATE INDEX idx_cms_media_type ON cms_media(media_type);
CREATE INDEX idx_page_media_page ON page_media(page_id);

-- 標準ブロックタイプの挿入
INSERT INTO block_types (name, label, icon, description, schema_definition, default_content) VALUES
('heading', '見出し', '📌', '見出しテキストブロック', 
'{
    "type": "object",
    "properties": {
        "text": {"type": "string"},
        "level": {"type": "number", "enum": [1, 2, 3, 4, 5, 6]},
        "alignment": {"type": "string", "enum": ["left", "center", "right"]}
    },
    "required": ["text", "level"]
}',
'{"text": "見出しテキスト", "level": 2, "alignment": "left"}'),

('text', 'テキスト', '📝', 'リッチテキストブロック',
'{
    "type": "object",
    "properties": {
        "content": {"type": "string"},
        "format": {"type": "string", "enum": ["html", "markdown", "plain"]}
    },
    "required": ["content"]
}',
'{"content": "", "format": "html"}'),

('image', '画像', '🖼️', '画像ブロック',
'{
    "type": "object",
    "properties": {
        "media_id": {"type": "string"},
        "url": {"type": "string"},
        "alt": {"type": "string"},
        "caption": {"type": "string"},
        "width": {"type": "string"},
        "height": {"type": "string"},
        "alignment": {"type": "string", "enum": ["left", "center", "right", "full"]}
    }
}',
'{"alignment": "center"}'),

('columns', 'カラム', '⬚⬚', '複数カラムレイアウト',
'{
    "type": "object",
    "properties": {
        "columns": {"type": "number", "enum": [2, 3, 4]},
        "gap": {"type": "string"},
        "responsive": {"type": "boolean"}
    },
    "required": ["columns"]
}',
'{"columns": 2, "gap": "20px", "responsive": true}'),

('html', 'HTML', '</>', 'カスタムHTMLブロック',
'{
    "type": "object",
    "properties": {
        "code": {"type": "string"}
    },
    "required": ["code"]
}',
'{"code": ""}'),

('spacer', 'スペーサー', '↕️', '余白調整ブロック',
'{
    "type": "object",
    "properties": {
        "height": {"type": "string"},
        "responsive": {
            "type": "object",
            "properties": {
                "mobile": {"type": "string"},
                "tablet": {"type": "string"},
                "desktop": {"type": "string"}
            }
        }
    },
    "required": ["height"]
}',
'{"height": "30px"}'),

('button', 'ボタン', '🔘', 'ボタンリンクブロック',
'{
    "type": "object",
    "properties": {
        "text": {"type": "string"},
        "url": {"type": "string"},
        "style": {"type": "string", "enum": ["primary", "secondary", "outline"]},
        "size": {"type": "string", "enum": ["small", "medium", "large"]},
        "alignment": {"type": "string", "enum": ["left", "center", "right"]},
        "target": {"type": "string", "enum": ["_self", "_blank"]}
    },
    "required": ["text", "url"]
}',
'{"text": "ボタンテキスト", "url": "#", "style": "primary", "size": "medium", "alignment": "left", "target": "_self"}'),

('list', 'リスト', '📋', '箇条書きリストブロック',
'{
    "type": "object",
    "properties": {
        "type": {"type": "string", "enum": ["bullet", "number"]},
        "items": {
            "type": "array",
            "items": {"type": "string"}
        }
    },
    "required": ["type", "items"]
}',
'{"type": "bullet", "items": []}'),

('table', 'テーブル', '📊', '表ブロック',
'{
    "type": "object",
    "properties": {
        "headers": {
            "type": "array",
            "items": {"type": "string"}
        },
        "rows": {
            "type": "array",
            "items": {
                "type": "array",
                "items": {"type": "string"}
            }
        },
        "striped": {"type": "boolean"},
        "bordered": {"type": "boolean"}
    },
    "required": ["headers", "rows"]
}',
'{"headers": [], "rows": [], "striped": true, "bordered": true}'),

('accordion', 'アコーディオン', '📂', '折りたたみコンテンツ',
'{
    "type": "object",
    "properties": {
        "items": {
            "type": "array",
            "items": {
                "type": "object",
                "properties": {
                    "title": {"type": "string"},
                    "content": {"type": "string"}
                }
            }
        },
        "allowMultiple": {"type": "boolean"}
    },
    "required": ["items"]
}',
'{"items": [], "allowMultiple": false}'),

('video', '動画', '🎬', '動画埋め込みブロック',
'{
    "type": "object",
    "properties": {
        "url": {"type": "string"},
        "type": {"type": "string", "enum": ["youtube", "vimeo", "direct"]},
        "autoplay": {"type": "boolean"},
        "controls": {"type": "boolean"},
        "loop": {"type": "boolean"}
    },
    "required": ["url", "type"]
}',
'{"type": "youtube", "controls": true, "autoplay": false, "loop": false}'),

('card', 'カード', '🃏', 'カード型コンテンツ',
'{
    "type": "object",
    "properties": {
        "title": {"type": "string"},
        "description": {"type": "string"},
        "image": {"type": "string"},
        "link": {"type": "string"},
        "linkText": {"type": "string"}
    }
}',
'{"title": "", "description": "", "linkText": "詳細を見る"}');

-- 更新日時自動更新トリガー
CREATE OR REPLACE FUNCTION update_updated_at_column()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ language 'plpgsql';

CREATE TRIGGER update_block_types_updated_at BEFORE UPDATE ON block_types
    FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

CREATE TRIGGER update_cms_pages_updated_at BEFORE UPDATE ON cms_pages
    FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

CREATE TRIGGER update_page_blocks_updated_at BEFORE UPDATE ON page_blocks
    FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

CREATE TRIGGER update_reusable_blocks_updated_at BEFORE UPDATE ON reusable_blocks
    FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

CREATE TRIGGER update_cms_media_updated_at BEFORE UPDATE ON cms_media
    FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();