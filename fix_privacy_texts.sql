-- PrivacyPolicyPage.vueのfallback値に合わせてtextsフィールドを修正

UPDATE page_contents 
SET content = jsonb_set(
  jsonb_set(
    jsonb_set(
      jsonb_set(
        content::jsonb,
        '{texts,page_title}',
        '"プライバシー"'::jsonb
      ),
      '{texts,intro}',
      '"当研究所では以下のプライバシーポリシーに基づき、お客様より提供を受けた個人情報を厳正な管理の元に保管し、当研究所の管理行においてのみ利用します。当研究所のサービスを利用した場合、当研究所のキャンペーンやアンケート等に応募した場合には、プライバシーポリシーに同意したものとみなされますので、本プライバシーポリシーの内容をご理解いただくようお願いいたします。"'::jsonb
    ),
    '{texts,disclosure_title}',
    '"情報の第三者への開示について"'::jsonb
  ),
  '{texts,purpose_list}',
  '"サービスの提供、キャンペーンなどを行うため<br>サービスに関する情報またはキャンペーン情報を提供するため<br>お客様から寄せられたご意見、ご要望にお答えするため<br>サービスの開発・改善を目的とした調査・検討を行うため<br>サービスに関する統計的資料を作成するため"'::jsonb
)::json
WHERE page_key = 'privacy';

-- changes_titleの修正（86行目のfallbackが間違っているが、とりあえず正しいタイトルを設定）
UPDATE page_contents 
SET content = jsonb_set(
  content::jsonb,
  '{texts,changes_title}',
  '"プライバシーポリシーの変更"'::jsonb
)::json
WHERE page_key = 'privacy';

-- 確認クエリ
SELECT 
  content->'texts'->>'page_title' as page_title,
  content->'texts'->>'intro' as intro,
  content->'texts'->>'disclosure_title' as disclosure_title,
  content->'texts'->>'changes_title' as changes_title,
  content->'texts'->>'purpose_list' as purpose_list
FROM page_contents 
WHERE page_key = 'privacy';