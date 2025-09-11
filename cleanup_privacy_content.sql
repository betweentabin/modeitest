-- プライバシーページのcontentフィールドをクリーンアップ
-- Vueコンポーネントが使用するtextsフィールドのみを残す

-- 1. 現在の構造を確認（バックアップ用）
SELECT content FROM page_contents WHERE page_key = 'privacy' \gset backup_

-- 2. クリーンアップ版の作成
UPDATE page_contents 
SET content = json_build_object(
    'texts', content->'texts',
    'title', 'プライバシーポリシー',
    'description', '個人情報の取り扱いについて説明しています。'
)::json
WHERE page_key = 'privacy';

-- 3. 確認
SELECT 
    json_object_keys(content) as keys,
    CASE 
        WHEN json_object_keys(content) = 'texts' 
        THEN (SELECT COUNT(*) FROM json_object_keys(content->'texts'))::text
        ELSE '-'
    END as field_count
FROM page_contents 
WHERE page_key = 'privacy'
ORDER BY 1;