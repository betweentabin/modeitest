-- ================================================
-- 完全なデータベーススキーマ構築SQL
-- Created: 2024年 (modeitestプロジェクト用)
-- Target: PostgreSQL (Railway)
-- ================================================

-- ================================================
-- 1. 既存テーブルの拡張
-- ================================================

-- 1.1 membersテーブルに新フィールド追加
-- (membership_expires_at, is_active)
DO $$
BEGIN
    -- membership_expires_at カラム追加
    IF NOT EXISTS (
        SELECT 1 FROM information_schema.columns 
        WHERE table_name = 'members' 
        AND column_name = 'membership_expires_at'
    ) THEN
        ALTER TABLE members ADD COLUMN membership_expires_at TIMESTAMP NULL;
    END IF;
    
    -- is_active カラム追加
    IF NOT EXISTS (
        SELECT 1 FROM information_schema.columns 
        WHERE table_name = 'members' 
        AND column_name = 'is_active'
    ) THEN
        ALTER TABLE members ADD COLUMN is_active BOOLEAN DEFAULT TRUE;
    END IF;
END
$$;

-- membersテーブルのインデックス追加
CREATE INDEX IF NOT EXISTS idx_members_membership_expires_at ON members(membership_expires_at);
CREATE INDEX IF NOT EXISTS idx_members_is_active ON members(is_active);
CREATE INDEX IF NOT EXISTS idx_members_membership_type ON members(membership_type);

-- 1.2 seminarsテーブルに公開日制御フィールド追加
DO $$
BEGIN
    -- premium_open_at カラム追加
    IF NOT EXISTS (
        SELECT 1 FROM information_schema.columns 
        WHERE table_name = 'seminars' 
        AND column_name = 'premium_open_at'
    ) THEN
        ALTER TABLE seminars ADD COLUMN premium_open_at TIMESTAMP NULL;
    END IF;
    
    -- standard_open_at カラム追加
    IF NOT EXISTS (
        SELECT 1 FROM information_schema.columns 
        WHERE table_name = 'seminars' 
        AND column_name = 'standard_open_at'
    ) THEN
        ALTER TABLE seminars ADD COLUMN standard_open_at TIMESTAMP NULL;
    END IF;
    
    -- free_open_at カラム追加
    IF NOT EXISTS (
        SELECT 1 FROM information_schema.columns 
        WHERE table_name = 'seminars' 
        AND column_name = 'free_open_at'
    ) THEN
        ALTER TABLE seminars ADD COLUMN free_open_at TIMESTAMP NULL;
    END IF;
END
$$;

-- seminarsテーブルのインデックス追加
CREATE INDEX IF NOT EXISTS idx_seminars_premium_open_at ON seminars(premium_open_at);
CREATE INDEX IF NOT EXISTS idx_seminars_standard_open_at ON seminars(standard_open_at);
CREATE INDEX IF NOT EXISTS idx_seminars_free_open_at ON seminars(free_open_at);

-- 1.3 seminar_registrationsテーブルに承認制フィールド追加
DO $$
BEGIN
    -- approval_status カラム追加
    IF NOT EXISTS (
        SELECT 1 FROM information_schema.columns 
        WHERE table_name = 'seminar_registrations' 
        AND column_name = 'approval_status'
    ) THEN
        ALTER TABLE seminar_registrations ADD COLUMN approval_status VARCHAR(20) DEFAULT 'pending';
    END IF;
    
    -- approved_at カラム追加
    IF NOT EXISTS (
        SELECT 1 FROM information_schema.columns 
        WHERE table_name = 'seminar_registrations' 
        AND column_name = 'approved_at'
    ) THEN
        ALTER TABLE seminar_registrations ADD COLUMN approved_at TIMESTAMP NULL;
    END IF;
    
    -- rejected_at カラム追加
    IF NOT EXISTS (
        SELECT 1 FROM information_schema.columns 
        WHERE table_name = 'seminar_registrations' 
        AND column_name = 'rejected_at'
    ) THEN
        ALTER TABLE seminar_registrations ADD COLUMN rejected_at TIMESTAMP NULL;
    END IF;
    
    -- approved_by カラム追加
    IF NOT EXISTS (
        SELECT 1 FROM information_schema.columns 
        WHERE table_name = 'seminar_registrations' 
        AND column_name = 'approved_by'
    ) THEN
        ALTER TABLE seminar_registrations ADD COLUMN approved_by BIGINT NULL;
    END IF;
    
    -- rejection_reason カラム追加
    IF NOT EXISTS (
        SELECT 1 FROM information_schema.columns 
        WHERE table_name = 'seminar_registrations' 
        AND column_name = 'rejection_reason'
    ) THEN
        ALTER TABLE seminar_registrations ADD COLUMN rejection_reason TEXT NULL;
    END IF;
END
$$;

-- seminar_registrationsテーブルのインデックス追加
CREATE INDEX IF NOT EXISTS idx_seminar_registrations_approval_status ON seminar_registrations(seminar_id, approval_status);
CREATE INDEX IF NOT EXISTS idx_seminar_registrations_member_approval ON seminar_registrations(member_id, approval_status);

-- ================================================
-- 2. 新規テーブル作成
-- ================================================

-- 2.1 mail_groups テーブル (メールグループ)
CREATE TABLE IF NOT EXISTS mail_groups (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    created_by BIGINT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- mail_groupsのインデックス
CREATE INDEX IF NOT EXISTS idx_mail_groups_created_by ON mail_groups(created_by);

-- 2.2 mail_group_members テーブル (メールグループメンバー)
CREATE TABLE IF NOT EXISTS mail_group_members (
    id BIGSERIAL PRIMARY KEY,
    group_id BIGINT NOT NULL REFERENCES mail_groups(id) ON DELETE CASCADE,
    member_id BIGINT NOT NULL REFERENCES members(id) ON DELETE CASCADE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(group_id, member_id)
);

-- mail_group_membersのインデックス
CREATE INDEX IF NOT EXISTS idx_mail_group_members_group_id ON mail_group_members(group_id);
CREATE INDEX IF NOT EXISTS idx_mail_group_members_member_id ON mail_group_members(member_id);

-- 2.3 email_campaigns テーブル (メールキャンペーン)
CREATE TABLE IF NOT EXISTS email_campaigns (
    id BIGSERIAL PRIMARY KEY,
    subject VARCHAR(255) NOT NULL,
    body_html TEXT,
    body_text TEXT,
    status VARCHAR(20) DEFAULT 'draft' CHECK (status IN ('draft', 'scheduled', 'sending', 'sent', 'failed')),
    scheduled_at TIMESTAMP NULL,
    created_by BIGINT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- email_campaignsのインデックス
CREATE INDEX IF NOT EXISTS idx_email_campaigns_status ON email_campaigns(status);
CREATE INDEX IF NOT EXISTS idx_email_campaigns_scheduled_at ON email_campaigns(scheduled_at);
CREATE INDEX IF NOT EXISTS idx_email_campaigns_created_by ON email_campaigns(created_by);

-- 2.4 email_recipients テーブル (メール受信者)
CREATE TABLE IF NOT EXISTS email_recipients (
    id BIGSERIAL PRIMARY KEY,
    campaign_id BIGINT NOT NULL REFERENCES email_campaigns(id) ON DELETE CASCADE,
    email VARCHAR(255) NOT NULL,
    member_id BIGINT NULL REFERENCES members(id) ON DELETE CASCADE,
    status VARCHAR(20) DEFAULT 'pending' CHECK (status IN ('pending', 'sent', 'failed')),
    sent_at TIMESTAMP NULL,
    error_message TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- email_recipientsのインデックス
CREATE INDEX IF NOT EXISTS idx_email_recipients_campaign_id ON email_recipients(campaign_id);
CREATE INDEX IF NOT EXISTS idx_email_recipients_status ON email_recipients(status);
CREATE INDEX IF NOT EXISTS idx_email_recipients_email ON email_recipients(email);

-- 2.5 member_favorites テーブル (会員お気に入り)
CREATE TABLE IF NOT EXISTS member_favorites (
    id BIGSERIAL PRIMARY KEY,
    member_id BIGINT NOT NULL REFERENCES members(id) ON DELETE CASCADE,
    favorite_member_id BIGINT NOT NULL REFERENCES members(id) ON DELETE CASCADE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(member_id, favorite_member_id),
    CHECK (member_id != favorite_member_id)
);

-- member_favoritesのインデックス
CREATE INDEX IF NOT EXISTS idx_member_favorites_member_id ON member_favorites(member_id);
CREATE INDEX IF NOT EXISTS idx_member_favorites_favorite_member_id ON member_favorites(favorite_member_id);

-- ================================================
-- 3. ビュー作成
-- ================================================

-- 3.1 会員統計ビュー
CREATE OR REPLACE VIEW member_statistics AS
SELECT 
    COUNT(*) as total_members,
    COUNT(CASE WHEN membership_type = 'premium' THEN 1 END) as premium_members,
    COUNT(CASE WHEN membership_type = 'standard' THEN 1 END) as standard_members,
    COUNT(CASE WHEN membership_type = 'free' THEN 1 END) as free_members,
    COUNT(CASE WHEN is_active = true THEN 1 END) as active_members,
    COUNT(CASE WHEN is_active = false THEN 1 END) as inactive_members,
    COUNT(CASE WHEN membership_expires_at IS NOT NULL AND membership_expires_at <= CURRENT_DATE + INTERVAL '30 days' THEN 1 END) as expiring_soon_members
FROM members;

-- 3.2 セミナー登録統計ビュー
CREATE OR REPLACE VIEW seminar_registration_statistics AS
SELECT 
    s.id as seminar_id,
    s.title as seminar_title,
    COUNT(sr.id) as total_registrations,
    COUNT(CASE WHEN sr.approval_status = 'approved' THEN 1 END) as approved_registrations,
    COUNT(CASE WHEN sr.approval_status = 'pending' THEN 1 END) as pending_registrations,
    COUNT(CASE WHEN sr.approval_status = 'rejected' THEN 1 END) as rejected_registrations
FROM seminars s
LEFT JOIN seminar_registrations sr ON s.id = sr.seminar_id
GROUP BY s.id, s.title;

-- 3.3 メールキャンペーン統計ビュー
CREATE OR REPLACE VIEW email_campaign_statistics AS
SELECT 
    ec.id as campaign_id,
    ec.subject,
    ec.status as campaign_status,
    COUNT(er.id) as total_recipients,
    COUNT(CASE WHEN er.status = 'sent' THEN 1 END) as sent_count,
    COUNT(CASE WHEN er.status = 'failed' THEN 1 END) as failed_count,
    COUNT(CASE WHEN er.status = 'pending' THEN 1 END) as pending_count
FROM email_campaigns ec
LEFT JOIN email_recipients er ON ec.id = er.campaign_id
GROUP BY ec.id, ec.subject, ec.status;

-- ================================================
-- 4. 初期データ投入 (テスト用)
-- ================================================

-- 4.1 テスト会員データ（既存データがない場合のみ）
INSERT INTO members (
    email, password, company_name, representative_name, 
    phone, postal_code, address, membership_type, status, 
    joined_date, is_active, created_at, updated_at
) VALUES 
(
    'test1@example.com', 
    crypt('password123', gen_salt('bf')), 
    '株式会社テスト商事', 
    '山田太郎',
    '03-1234-5678', 
    '100-0001', 
    '東京都千代田区千代田1-1', 
    'premium', 
    'active',
    CURRENT_DATE - INTERVAL '1 year',
    true,
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
),
(
    'test2@example.com', 
    crypt('password123', gen_salt('bf')), 
    '有限会社サンプル', 
    '鈴木花子',
    '06-9876-5432', 
    '530-0001', 
    '大阪府大阪市北区梅田1-1', 
    'standard', 
    'active',
    CURRENT_DATE - INTERVAL '6 months',
    true,
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
),
(
    'test3@example.com', 
    crypt('password123', gen_salt('bf')), 
    'ABC工業株式会社', 
    '佐藤次郎',
    '052-1111-2222', 
    '460-0001', 
    '愛知県名古屋市中区錦1-1', 
    'free', 
    'active',
    CURRENT_DATE - INTERVAL '3 months',
    true,
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
)
ON CONFLICT (email) DO NOTHING;

-- ================================================
-- 5. 権限・制約の設定
-- ================================================

-- セミナー登録の承認状態制約
DO $$
BEGIN
    IF NOT EXISTS (
        SELECT 1 FROM information_schema.check_constraints 
        WHERE constraint_name = 'seminar_registrations_approval_status_check'
    ) THEN
        ALTER TABLE seminar_registrations 
        ADD CONSTRAINT seminar_registrations_approval_status_check 
        CHECK (approval_status IN ('pending', 'approved', 'rejected'));
    END IF;
END
$$;

-- ================================================
-- 6. 完了メッセージ
-- ================================================

DO $$
BEGIN
    RAISE NOTICE '==============================================';
    RAISE NOTICE '✅ データベーススキーマ構築完了';
    RAISE NOTICE '==============================================';
    RAISE NOTICE '📋 作成されたテーブル:';
    RAISE NOTICE '   - mail_groups (メールグループ)';
    RAISE NOTICE '   - mail_group_members (グループメンバー)';
    RAISE NOTICE '   - email_campaigns (メールキャンペーン)';
    RAISE NOTICE '   - email_recipients (メール受信者)';
    RAISE NOTICE '   - member_favorites (会員お気に入り)';
    RAISE NOTICE '';
    RAISE NOTICE '🔧 拡張されたテーブル:';
    RAISE NOTICE '   - members (membership_expires_at, is_active)';
    RAISE NOTICE '   - seminars (open_at系フィールド)';
    RAISE NOTICE '   - seminar_registrations (承認系フィールド)';
    RAISE NOTICE '';
    RAISE NOTICE '📊 作成されたビュー:';
    RAISE NOTICE '   - member_statistics';
    RAISE NOTICE '   - seminar_registration_statistics';
    RAISE NOTICE '   - email_campaign_statistics';
    RAISE NOTICE '==============================================';
END
$$;
