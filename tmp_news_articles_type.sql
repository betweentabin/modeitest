BEGIN;

-- 1) Add column if missing
ALTER TABLE news_articles ADD COLUMN IF NOT EXISTS type varchar(50);

-- 2) Ensure default and not-null (after backfill)
ALTER TABLE news_articles ALTER COLUMN type SET DEFAULT 'news';

-- 3) Backfill NULLs to 'news'
UPDATE news_articles SET type = 'news' WHERE type IS NULL;

-- 4) Promote any legacy notices (category='notice') to type='notice'
UPDATE news_articles SET type = 'notice' WHERE category = 'notice';

-- 5) Enforce NOT NULL after backfill
ALTER TABLE news_articles ALTER COLUMN type SET NOT NULL;

-- 6) Create index if missing
DO $$
BEGIN
  IF NOT EXISTS (
    SELECT 1 FROM pg_class c
    JOIN pg_namespace n ON n.oid = c.relnamespace
    WHERE c.relkind = 'i' AND c.relname = 'news_articles_type_index'
  ) THEN
    CREATE INDEX news_articles_type_index ON news_articles (type);
  END IF;
END
$$;

COMMIT;
