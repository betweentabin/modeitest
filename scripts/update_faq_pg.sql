-- Update FAQ content to 10 items while preserving other keys in content JSON
BEGIN;

UPDATE page_contents
SET content = jsonb_set(
  CASE WHEN jsonb_typeof(content::jsonb) = 'object' THEN content::jsonb ELSE '{}'::jsonb END,
  '{faqs}',
  (
    '[
      {"category":"service","question":"貴社にとってどんなサービスが提供されますか？","answer":"私たちは地域経済に関するリサーチ・分析とレポート作成、経営戦略立案支援・事業計画策定・プロジェクト管理・経営指導等を実施しています。","tags":[]},
      {"category":"membership","question":"資料費どのくらいの会費を支払っているのですか？","answer":"スタンダード会員：年会費12,000円（税別）。プレミアム会員：ビジネスマッチング・事業承継等の支援を含む特典をご提供します。","tags":["スタンダード会員","プレミアム会員"]},
      {"category":"research","question":"研究会の開催はありますか？","answer":"定期的な研究会や勉強会を開催しており、会員の皆様にご参加いただけます。","tags":[]},
      {"category":"membership","question":"会費減額、減額はどうしたら良いですか？","answer":"会費の減額や変更については、お気軽にお問い合わせください。","tags":[]},
      {"category":"service","question":"経営診断をしたい場合どうすればいいの、態度を教えてほしい？","answer":"経営診断をご希望の場合は、まずはお問い合わせフォームよりご連絡ください。","tags":[]},
      {"category":"service","question":"料金体系を教えて？","answer":"サービスごとに料金体系が異なります。詳しくはお問い合わせください。","tags":[]},
      {"category":"service","question":"入会は法人・個人でも申込める？","answer":"法人・個人を問わずご入会いただけます。","tags":[]},
      {"category":"service","question":"入会したい場合の手続きはどうしたらいい？","answer":"入会手続きについては、お問い合わせフォームよりご連絡いただくか、直接お電話でお問い合わせください。","tags":[]},
      {"category":"service","question":"会費はどうやって払う？","answer":"会費のお支払い方法は、銀行振込、口座振替等をご利用いただけます。","tags":[]},
      {"category":"service","question":"会費の支払いはいつする？","answer":"会費のお支払いタイミングについては、入会時にご案内いたします。","tags":[]}
    ]'::jsonb
  ),
  true
),
updated_at = now()
WHERE page_key = 'faq';

COMMIT;

