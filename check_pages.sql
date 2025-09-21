\pset pager off
\timing off
SELECT page_key, title, is_published, to_char(updated_at, 'YYYY-MM-DD HH24:MI') AS updated
FROM page_contents
WHERE page_key IN (
  'contact','contact-confirm','contact-complete',
  'membership-application','membership-application-confirm','membership-application-complete',
  'seminar-application','seminar-application-confirm','seminar-application-complete'
)
ORDER BY page_key;

-- Contact texts
SELECT 'contact' AS key,
  content->'texts'->>'page_title' AS page_title,
  content->'texts'->>'page_subtitle' AS page_subtitle,
  content->'texts'->>'confirm_title' AS confirm_title,
  content->'texts'->>'confirm_subtitle' AS confirm_subtitle,
  content->'texts'->>'complete_title' AS complete_title,
  content->'texts'->>'complete_hero_title' AS complete_hero_title,
  content->'texts'->>'complete_hero_subtitle' AS complete_hero_subtitle,
  content->'texts'->>'complete_message' AS complete_message
FROM page_contents WHERE page_key='contact';

-- Membership application texts
SELECT 'membership-application' AS key,
  content->'texts'->>'page_title' AS page_title,
  content->'texts'->>'page_subtitle' AS page_subtitle,
  content->'texts'->>'breadcrumb_confirm' AS breadcrumb_confirm,
  content->'texts'->>'breadcrumb_complete' AS breadcrumb_complete,
  content->'texts'->>'complete_title' AS complete_title,
  content->'texts'->>'complete_hero_title' AS complete_hero_title,
  content->'texts'->>'complete_hero_subtitle' AS complete_hero_subtitle,
  content->'texts'->>'complete_message' AS complete_message,
  content->'texts'->>'button_home' AS button_home
FROM page_contents WHERE page_key='membership-application';

-- Seminar application texts
SELECT 'seminar-application' AS key,
  content->'texts'->>'page_title' AS page_title,
  content->'texts'->>'page_subtitle' AS page_subtitle,
  content->'texts'->>'breadcrumb_confirm' AS breadcrumb_confirm,
  content->'texts'->>'breadcrumb_complete' AS breadcrumb_complete,
  content->'texts'->>'complete_title' AS complete_title,
  content->'texts'->>'complete_hero_title' AS complete_hero_title,
  content->'texts'->>'complete_hero_subtitle' AS complete_hero_subtitle,
  content->'texts'->>'complete_message' AS complete_message,
  content->'texts'->>'button_home' AS button_home
FROM page_contents WHERE page_key='seminar-application';

-- Media hero mappings
SELECT img.key,
       CASE WHEN jsonb_typeof(img.value)='string'
            THEN trim(both '"' from img.value::text)
            ELSE img.value->>'url' END AS url
FROM page_contents pc
LEFT JOIN LATERAL jsonb_each((pc.content->'images')::jsonb) AS img(key, value) ON true
WHERE pc.page_key='media' AND img.key IN ('hero_contact','hero_membership','hero_seminar')
ORDER BY img.key;
