\pset pager off
\timing off

-- 1) Ensure rows exist
WITH payload(key, title, subtitle) AS (
  VALUES
    ('seminars', 'セミナー', 'seminar'),
    ('seminars-current', '受付中のセミナー', 'current seminars'),
    ('seminars-past', '過去のセミナー', 'past seminars')
)
INSERT INTO page_contents (page_key, title, content, is_published, published_at, created_at, updated_at)
SELECT key, title,
       jsonb_build_object('texts', jsonb_build_object('page_title', title, 'page_subtitle', subtitle)),
       true, NOW(), NOW(), NOW()
FROM payload
ON CONFLICT (page_key) DO NOTHING;

-- 2) Merge texts into existing rows
WITH payload(key, title, subtitle) AS (
  VALUES
    ('seminars', 'セミナー', 'seminar'),
    ('seminars-current', '受付中のセミナー', 'current seminars'),
    ('seminars-past', '過去のセミナー', 'past seminars')
)
UPDATE page_contents pc
SET title = COALESCE(pc.title, v.title),
    content = (
      jsonb_set(
        COALESCE(pc.content::jsonb, '{}'::jsonb),
        '{texts}',
        COALESCE((pc.content::jsonb)->'texts','{}'::jsonb)
        || jsonb_build_object('page_title', v.title, 'page_subtitle', v.subtitle)
      )
    )::json,
    is_published = true,
    updated_at = NOW()
FROM payload v
WHERE pc.page_key = v.key;

-- 3) Show results
SELECT page_key, content->'texts'->>'page_title' AS page_title, content->'texts'->>'page_subtitle' AS page_subtitle
FROM page_contents
WHERE page_key IN ('seminars','seminars-current','seminars-past')
ORDER BY page_key;
