-- 既存ページデータをブロック型CMSへ移行するSQL

-- 既存のpage_contentsからcms_pagesへ移行
INSERT INTO cms_pages (page_key, title, meta_description, meta_keywords, is_published, published_at, created_at, updated_at)
SELECT 
    page_key,
    title,
    meta_description,
    meta_keywords,
    is_published,
    published_at,
    created_at,
    updated_at
FROM page_contents
ON CONFLICT (page_key) DO NOTHING;

-- ヘルパー関数：JSONからブロックを抽出して作成
CREATE OR REPLACE FUNCTION migrate_page_content_to_blocks(
    p_page_key VARCHAR(255)
) RETURNS void AS $$
DECLARE
    v_page_id TEXT;
    v_content JSONB;
    v_sort_order INTEGER := 0;
    v_block_type_id TEXT;
    v_section JSONB;
BEGIN
    -- ページIDとコンテンツを取得
    SELECT cp.id, pc.content INTO v_page_id, v_content
    FROM cms_pages cp
    JOIN page_contents pc ON cp.page_key = pc.page_key
    WHERE cp.page_key = p_page_key;
    
    IF v_page_id IS NULL THEN
        RETURN;
    END IF;
    
    -- heroセクションの処理
    IF v_content ? 'hero' THEN
        SELECT id INTO v_block_type_id FROM block_types WHERE name = 'heading';
        INSERT INTO page_blocks (page_id, block_type_id, content, sort_order)
        VALUES (
            v_page_id,
            v_block_type_id,
            jsonb_build_object(
                'text', v_content->'hero'->>'title',
                'level', 1,
                'alignment', 'center'
            ),
            v_sort_order
        );
        v_sort_order := v_sort_order + 1;
        
        -- heroの説明文がある場合
        IF v_content->'hero' ? 'description' THEN
            SELECT id INTO v_block_type_id FROM block_types WHERE name = 'text';
            INSERT INTO page_blocks (page_id, block_type_id, content, sort_order)
            VALUES (
                v_page_id,
                v_block_type_id,
                jsonb_build_object(
                    'content', v_content->'hero'->>'description',
                    'format', 'html'
                ),
                v_sort_order
            );
            v_sort_order := v_sort_order + 1;
        END IF;
    END IF;
    
    -- sectionsの処理
    IF v_content ? 'sections' AND jsonb_typeof(v_content->'sections') = 'array' THEN
        FOR v_section IN SELECT * FROM jsonb_array_elements(v_content->'sections')
        LOOP
            -- タイトルがある場合
            IF v_section ? 'title' THEN
                SELECT id INTO v_block_type_id FROM block_types WHERE name = 'heading';
                INSERT INTO page_blocks (page_id, block_type_id, content, sort_order)
                VALUES (
                    v_page_id,
                    v_block_type_id,
                    jsonb_build_object(
                        'text', v_section->>'title',
                        'level', 2,
                        'alignment', 'left'
                    ),
                    v_sort_order
                );
                v_sort_order := v_sort_order + 1;
            END IF;
            
            -- コンテンツがある場合
            IF v_section ? 'content' THEN
                SELECT id INTO v_block_type_id FROM block_types WHERE name = 'text';
                INSERT INTO page_blocks (page_id, block_type_id, content, sort_order)
                VALUES (
                    v_page_id,
                    v_block_type_id,
                    jsonb_build_object(
                        'content', v_section->>'content',
                        'format', 'html'
                    ),
                    v_sort_order
                );
                v_sort_order := v_sort_order + 1;
            END IF;
            
            -- itemsがある場合（リストとして処理）
            IF v_section ? 'items' AND jsonb_typeof(v_section->'items') = 'array' THEN
                SELECT id INTO v_block_type_id FROM block_types WHERE name = 'list';
                INSERT INTO page_blocks (page_id, block_type_id, content, sort_order)
                VALUES (
                    v_page_id,
                    v_block_type_id,
                    jsonb_build_object(
                        'type', 'bullet',
                        'items', v_section->'items'
                    ),
                    v_sort_order
                );
                v_sort_order := v_sort_order + 1;
            END IF;
        END LOOP;
    END IF;
    
    -- FAQsの処理
    IF v_content ? 'faqs' AND jsonb_typeof(v_content->'faqs') = 'array' THEN
        SELECT id INTO v_block_type_id FROM block_types WHERE name = 'accordion';
        INSERT INTO page_blocks (page_id, block_type_id, content, sort_order)
        VALUES (
            v_page_id,
            v_block_type_id,
            jsonb_build_object(
                'items', v_content->'faqs',
                'allowMultiple', true
            ),
            v_sort_order
        );
        v_sort_order := v_sort_order + 1;
    END IF;
    
    -- HTMLsの処理
    IF v_content ? 'htmls' THEN
        FOR v_section IN SELECT value FROM jsonb_each_text(v_content->'htmls')
        LOOP
            SELECT id INTO v_block_type_id FROM block_types WHERE name = 'html';
            INSERT INTO page_blocks (page_id, block_type_id, content, sort_order)
            VALUES (
                v_page_id,
                v_block_type_id,
                jsonb_build_object('code', v_section),
                v_sort_order
            );
            v_sort_order := v_sort_order + 1;
        END LOOP;
    END IF;
    
END;
$$ LANGUAGE plpgsql;

-- 全ページを移行
DO $$
DECLARE
    r RECORD;
BEGIN
    FOR r IN SELECT page_key FROM page_contents
    LOOP
        PERFORM migrate_page_content_to_blocks(r.page_key);
    END LOOP;
END $$;

-- 移行状況の確認クエリ
SELECT 
    cp.page_key,
    cp.title,
    COUNT(pb.id) as block_count,
    array_agg(DISTINCT bt.label ORDER BY bt.label) as block_types_used
FROM cms_pages cp
LEFT JOIN page_blocks pb ON cp.id = pb.page_id
LEFT JOIN block_types bt ON pb.block_type_id = bt.id
GROUP BY cp.page_key, cp.title
ORDER BY cp.page_key;