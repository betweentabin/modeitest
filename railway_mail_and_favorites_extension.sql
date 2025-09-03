-- Railway PostgreSQL用 メール配信システムと会員お気に入り機能追加SQL
-- ちくぎん地域経済研究所 データベース拡張
-- 作成日: 2024年12月

-- =============================================================================
-- 1. 新規テーブル: メール配信システム
-- =============================================================================

-- メールグループテーブル
CREATE TABLE IF NOT EXISTS mail_groups (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    created_by BIGINT REFERENCES admins(id) ON DELETE SET NULL,
    created_at TIMESTAMP DEFAULT NOW(),
    updated_at TIMESTAMP DEFAULT NOW()
);

-- インデックス
CREATE INDEX IF NOT EXISTS idx_mail_groups_created_by ON mail_groups(created_by);

-- メールグループメンバーテーブル
CREATE TABLE IF NOT EXISTS mail_group_members (
    id BIGSERIAL PRIMARY KEY,
    group_id BIGINT NOT NULL REFERENCES mail_groups(id) ON DELETE CASCADE,
    member_id BIGINT NOT NULL REFERENCES members(id) ON DELETE CASCADE,
    created_at TIMESTAMP DEFAULT NOW(),
    CONSTRAINT uq_mail_group_members_group_member UNIQUE (group_id, member_id)
);

-- インデックス
CREATE INDEX IF NOT EXISTS idx_mail_group_members_group_id ON mail_group_members(group_id);
CREATE INDEX IF NOT EXISTS idx_mail_group_members_member_id ON mail_group_members(member_id);

-- メールキャンペーンテーブル
CREATE TABLE IF NOT EXISTS email_campaigns (
    id BIGSERIAL PRIMARY KEY,
    subject VARCHAR(500) NOT NULL,
    body_html TEXT,
    body_text TEXT,
    status VARCHAR(20) CHECK (status IN ('draft', 'scheduled', 'sending', 'sent', 'failed')) DEFAULT 'draft',
    scheduled_at TIMESTAMP,
    created_by BIGINT REFERENCES admins(id) ON DELETE SET NULL,
    created_at TIMESTAMP DEFAULT NOW(),
    updated_at TIMESTAMP DEFAULT NOW()
);

-- インデックス
CREATE INDEX IF NOT EXISTS idx_email_campaigns_status ON email_campaigns(status);
CREATE INDEX IF NOT EXISTS idx_email_campaigns_scheduled_at ON email_campaigns(scheduled_at);
CREATE INDEX IF NOT EXISTS idx_email_campaigns_created_by ON email_campaigns(created_by);

-- メール受信者テーブル
CREATE TABLE IF NOT EXISTS email_recipients (
    id BIGSERIAL PRIMARY KEY,
    campaign_id BIGINT NOT NULL REFERENCES email_campaigns(id) ON DELETE CASCADE,
    email VARCHAR(255) NOT NULL,
    member_id BIGINT REFERENCES members(id) ON DELETE SET NULL,
    status VARCHAR(20) CHECK (status IN ('pending', 'sent', 'failed')) DEFAULT 'pending',
    sent_at TIMESTAMP,
    error TEXT,
    created_at TIMESTAMP DEFAULT NOW(),
    updated_at TIMESTAMP DEFAULT NOW()
);

-- インデックス
CREATE INDEX IF NOT EXISTS idx_email_recipients_campaign_id ON email_recipients(campaign_id);
CREATE INDEX IF NOT EXISTS idx_email_recipients_status ON email_recipients(status);
CREATE INDEX IF NOT EXISTS idx_email_recipients_email ON email_recipients(email);

-- =============================================================================
-- 2. 新規テーブル: 会員お気に入り機能
-- =============================================================================

-- 会員お気に入りテーブル
CREATE TABLE IF NOT EXISTS member_favorites (
    id BIGSERIAL PRIMARY KEY,
    member_id BIGINT NOT NULL REFERENCES members(id) ON DELETE CASCADE,
    favorite_member_id BIGINT NOT NULL REFERENCES members(id) ON DELETE CASCADE,
    created_at TIMESTAMP DEFAULT NOW(),
    CONSTRAINT uq_member_favorites_member_favorite UNIQUE (member_id, favorite_member_id),
    CONSTRAINT chk_member_favorites_not_self CHECK (member_id != favorite_member_id)
);

-- インデックス
CREATE INDEX IF NOT EXISTS idx_member_favorites_member_id ON member_favorites(member_id);
CREATE INDEX IF NOT EXISTS idx_member_favorites_favorite_member_id ON member_favorites(favorite_member_id);

-- =============================================================================
-- 3. 既存テーブル変更: members
-- =============================================================================

-- membersテーブルに新しいカラムを追加（存在しない場合のみ）
DO $$ 
BEGIN
    -- membership_type の更新（既存の値と互換性を保つ）
    IF NOT EXISTS (
        SELECT 1 FROM information_schema.columns 
        WHERE table_name = 'members' AND column_name = 'membership_type'
    ) THEN
        ALTER TABLE members ADD COLUMN membership_type VARCHAR(20) DEFAULT 'free' 
        CHECK (membership_type IN ('free', 'standard', 'premium'));
    ELSE
        -- 既存のmembership_typeカラムの制約を更新
        ALTER TABLE members DROP CONSTRAINT IF EXISTS members_membership_type_check;
        ALTER TABLE members ADD CONSTRAINT members_membership_type_check 
        CHECK (membership_type IN ('free', 'basic', 'standard', 'premium'));
    END IF;

    -- membership_expires_at カラムの追加
    IF NOT EXISTS (
        SELECT 1 FROM information_schema.columns 
        WHERE table_name = 'members' AND column_name = 'membership_expires_at'
    ) THEN
        ALTER TABLE members ADD COLUMN membership_expires_at TIMESTAMP;
    END IF;

    -- is_active カラムの追加
    IF NOT EXISTS (
        SELECT 1 FROM information_schema.columns 
        WHERE table_name = 'members' AND column_name = 'is_active'
    ) THEN
        ALTER TABLE members ADD COLUMN is_active BOOLEAN DEFAULT true;
    END IF;
END $$;

-- 新しいインデックス
CREATE INDEX IF NOT EXISTS idx_members_membership_type ON members(membership_type);
CREATE INDEX IF NOT EXISTS idx_members_is_active ON members(is_active);
CREATE INDEX IF NOT EXISTS idx_members_membership_expires_at ON members(membership_expires_at);

-- =============================================================================
-- 4. 既存テーブル変更: seminars (案A: 解禁日制)
-- =============================================================================

-- seminarsテーブルに会員ランク別解禁日カラムを追加
DO $$ 
BEGIN
    -- premium_open_at カラムの追加
    IF NOT EXISTS (
        SELECT 1 FROM information_schema.columns 
        WHERE table_name = 'seminars' AND column_name = 'premium_open_at'
    ) THEN
        ALTER TABLE seminars ADD COLUMN premium_open_at TIMESTAMP;
    END IF;

    -- standard_open_at カラムの追加
    IF NOT EXISTS (
        SELECT 1 FROM information_schema.columns 
        WHERE table_name = 'seminars' AND column_name = 'standard_open_at'
    ) THEN
        ALTER TABLE seminars ADD COLUMN standard_open_at TIMESTAMP;
    END IF;

    -- free_open_at カラムの追加
    IF NOT EXISTS (
        SELECT 1 FROM information_schema.columns 
        WHERE table_name = 'seminars' AND column_name = 'free_open_at'
    ) THEN
        ALTER TABLE seminars ADD COLUMN free_open_at TIMESTAMP;
    END IF;
END $$;

-- インデックス
CREATE INDEX IF NOT EXISTS idx_seminars_free_open_at ON seminars(free_open_at);
CREATE INDEX IF NOT EXISTS idx_seminars_standard_open_at ON seminars(standard_open_at);
CREATE INDEX IF NOT EXISTS idx_seminars_premium_open_at ON seminars(premium_open_at);

-- =============================================================================
-- 5. 既存テーブル変更: seminar_registrations (案B: 承認/抽選制)
-- =============================================================================

-- seminar_registrationsテーブルに承認関連カラムを追加
DO $$ 
BEGIN
    -- approval_status カラムの追加
    IF NOT EXISTS (
        SELECT 1 FROM information_schema.columns 
        WHERE table_name = 'seminar_registrations' AND column_name = 'approval_status'
    ) THEN
        ALTER TABLE seminar_registrations ADD COLUMN approval_status VARCHAR(20) DEFAULT 'pending'
        CHECK (approval_status IN ('pending', 'approved', 'rejected'));
    END IF;

    -- approved_at カラムの追加
    IF NOT EXISTS (
        SELECT 1 FROM information_schema.columns 
        WHERE table_name = 'seminar_registrations' AND column_name = 'approved_at'
    ) THEN
        ALTER TABLE seminar_registrations ADD COLUMN approved_at TIMESTAMP;
    END IF;

    -- rejected_at カラムの追加
    IF NOT EXISTS (
        SELECT 1 FROM information_schema.columns 
        WHERE table_name = 'seminar_registrations' AND column_name = 'rejected_at'
    ) THEN
        ALTER TABLE seminar_registrations ADD COLUMN rejected_at TIMESTAMP;
    END IF;

    -- approved_by カラムの追加（承認者）
    IF NOT EXISTS (
        SELECT 1 FROM information_schema.columns 
        WHERE table_name = 'seminar_registrations' AND column_name = 'approved_by'
    ) THEN
        ALTER TABLE seminar_registrations ADD COLUMN approved_by BIGINT REFERENCES admins(id) ON DELETE SET NULL;
    END IF;

    -- rejection_reason カラムの追加
    IF NOT EXISTS (
        SELECT 1 FROM information_schema.columns 
        WHERE table_name = 'seminar_registrations' AND column_name = 'rejection_reason'
    ) THEN
        ALTER TABLE seminar_registrations ADD COLUMN rejection_reason TEXT;
    END IF;
END $$;

-- インデックス
CREATE INDEX IF NOT EXISTS idx_seminar_registrations_seminar_approval ON seminar_registrations(seminar_id, approval_status);
CREATE INDEX IF NOT EXISTS idx_seminar_registrations_member_approval ON seminar_registrations(member_id, approval_status);
CREATE INDEX IF NOT EXISTS idx_seminar_registrations_approved_by ON seminar_registrations(approved_by);

-- =============================================================================
-- 6. サンプルデータの挿入
-- =============================================================================

-- メールグループのサンプルデータ
INSERT INTO mail_groups (name, description, created_by) VALUES
('全会員', '全ての会員を対象としたメール配信グループ', 1),
('プレミアム会員', 'プレミアム会員のみを対象としたメール配信グループ', 1),
('セミナー参加者', 'セミナーに参加したことがある会員', 1)
ON CONFLICT DO NOTHING;

-- メールキャンペーンのサンプルデータ
INSERT INTO email_campaigns (subject, body_html, body_text, status, created_by) VALUES
('【ちくぎん地域経済研究所】月次レポートのお知らせ', 
 '<h1>月次レポートが公開されました</h1><p>最新の経済動向をお伝えします。</p>', 
 '月次レポートが公開されました。最新の経済動向をお伝えします。', 
 'draft', 1),
('【重要】会員制度変更のお知らせ', 
 '<h1>会員制度が変更になります</h1><p>詳細はこちらをご確認ください。</p>', 
 '会員制度が変更になります。詳細はこちらをご確認ください。', 
 'draft', 1)
ON CONFLICT DO NOTHING;

-- =============================================================================
-- 7. 権限とセキュリティの設定
-- =============================================================================

-- メール配信関連のテーブルに対する権限設定
-- GRANT SELECT, INSERT, UPDATE, DELETE ON mail_groups TO railway_user;
-- GRANT SELECT, INSERT, UPDATE, DELETE ON mail_group_members TO railway_user;
-- GRANT SELECT, INSERT, UPDATE, DELETE ON email_campaigns TO railway_user;
-- GRANT SELECT, INSERT, UPDATE, DELETE ON email_recipients TO railway_user;
-- GRANT SELECT, INSERT, UPDATE, DELETE ON member_favorites TO railway_user;

-- =============================================================================
-- 8. 統計・分析用ビューの作成
-- =============================================================================

-- 会員統計ビュー
CREATE OR REPLACE VIEW member_statistics AS
SELECT 
    membership_type,
    COUNT(*) as total_members,
    COUNT(CASE WHEN is_active = true THEN 1 END) as active_members,
    COUNT(CASE WHEN membership_expires_at > NOW() THEN 1 END) as valid_members
FROM members 
GROUP BY membership_type;

-- セミナー申し込み統計ビュー
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

-- メールキャンペーン統計ビュー
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

-- =============================================================================
-- 9. 完了メッセージとデータ確認
-- =============================================================================

-- データベース拡張完了の確認
SELECT 
    'メール配信システムとお気に入り機能の追加が完了しました。' as message,
    (SELECT COUNT(*) FROM mail_groups) as mail_groups_count,
    (SELECT COUNT(*) FROM email_campaigns) as campaigns_count,
    (SELECT COUNT(*) FROM member_favorites) as favorites_count,
    (SELECT COUNT(*) FROM members WHERE membership_expires_at IS NOT NULL) as members_with_expiry;

-- 新しく追加されたテーブルの一覧
SELECT 
    table_name,
    CASE 
        WHEN table_name IN ('mail_groups', 'mail_group_members', 'email_campaigns', 'email_recipients') 
        THEN 'メール配信システム'
        WHEN table_name = 'member_favorites' 
        THEN 'お気に入り機能'
        ELSE 'その他'
    END as feature_category
FROM information_schema.tables 
WHERE table_schema = 'public' 
AND table_name IN ('mail_groups', 'mail_group_members', 'email_campaigns', 'email_recipients', 'member_favorites')
ORDER BY feature_category, table_name;
