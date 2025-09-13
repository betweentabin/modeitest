# データベース移行ガイド

## 概要
このガイドは、現在のRailway PostgreSQLデータベースを新しい環境に移行するための手順を説明します。

## ファイル構成

### 1. `complete_database_backup.sql`
- **用途**: 完全なデータベーススキーマの復元
- **内容**: 
  - 全テーブル定義
  - インデックス
  - 制約
  - ビュー
  - 初期マスターデータ
  - 管理者アカウント

### 2. `database_with_sample_data.sql`
- **用途**: サンプルデータの追加
- **内容**:
  - テスト用会員データ
  - セミナーサンプル
  - 経済レポートサンプル
  - お知らせサンプル
  - ページコンテンツ

## 移行手順

### ステップ1: 新しいPostgreSQLデータベースの準備
```bash
# PostgreSQL 13以上を使用
createdb your_new_database
```

### ステップ2: スキーマの復元
```bash
psql -d your_new_database -f complete_database_backup.sql
```

### ステップ3: サンプルデータの投入（オプション）
```bash
psql -d your_new_database -f database_with_sample_data.sql
```

### ステップ4: 現在のデータの移行
現在のRailwayデータベースからデータを移行する場合：

```bash
# 現在のデータをダンプ（データのみ）
pg_dump "postgresql://postgres:PASSWORD@HOST:PORT/DATABASE" \
  --data-only --no-owner --no-privileges \
  -t members -t seminars -t economic_reports -t page_contents -t news \
  > current_data.sql

# 新しいデータベースに投入
psql -d your_new_database -f current_data.sql
```

## 環境変数の設定

### Laravel (.env)
```env
DB_CONNECTION=pgsql
DB_HOST=your_host
DB_PORT=5432
DB_DATABASE=your_new_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Railway/Vercel環境変数
```
DATABASE_URL=postgresql://username:password@host:port/database
```

## テーブル一覧

### 主要テーブル
- `admins` - 管理者アカウント
- `members` - 会員情報
- `seminars` - セミナー情報
- `seminar_registrations` - セミナー申込
- `economic_reports` - 経済レポート
- `page_contents` - CMSページ
- `news` - お知らせ

### メール機能
- `mail_groups` - メールグループ
- `mail_group_members` - グループメンバー
- `email_campaigns` - メールキャンペーン
- `email_recipients` - 受信者
- `email_attachments` - 添付ファイル

### お気に入り機能
- `member_favorites` - 会員お気に入り
- `seminar_favorites` - セミナーお気に入り

### マスターデータ
- `regions` - 地域マスター
- `industries` - 業界マスター
- `news_categories` - お知らせカテゴリ
- `publication_categories` - 刊行物カテゴリ

## 検証方法

### 1. テーブル数の確認
```sql
SELECT COUNT(*) FROM information_schema.tables 
WHERE table_schema = 'public';
```

### 2. データ件数の確認
```sql
SELECT 
  (SELECT COUNT(*) FROM members) as members_count,
  (SELECT COUNT(*) FROM seminars) as seminars_count,
  (SELECT COUNT(*) FROM economic_reports) as reports_count;
```

### 3. 制約の確認
```sql
SELECT conname, contype FROM pg_constraint 
WHERE contype IN ('f', 'u', 'c');
```

## トラブルシューティング

### 権限エラー
```sql
-- 必要に応じて権限を付与
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO your_user;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO your_user;
```

### 文字エンコーディング
```sql
-- データベース作成時にUTF-8を指定
CREATE DATABASE your_database 
  WITH ENCODING 'UTF8' 
  LC_COLLATE='ja_JP.UTF-8' 
  LC_CTYPE='ja_JP.UTF-8';
```

### Laravel Sanctumトークンの再生成
```bash
# 移行後に実行
php artisan sanctum:prune-expired --hours=0
```

## バックアップスケジュール

### 定期バックアップの設定
```bash
# crontabに追加
0 2 * * * pg_dump "postgresql://..." > backup_$(date +\%Y\%m\%d).sql
```

## 注意事項

1. **パスワードハッシュ**: 会員のパスワードはbcryptでハッシュ化されています
2. **ファイルパス**: 画像やPDFファイルのパスは環境に応じて調整が必要
3. **メール設定**: SMTP設定は別途環境変数で設定
4. **Laravel Sanctum**: APIトークンは移行後に再発行推奨
5. **pgcrypto拡張**: PostgreSQLでpgcrypto拡張が必要

## 移行チェックリスト

- [ ] PostgreSQL 13以上の準備
- [ ] スキーマファイルの実行
- [ ] データの移行
- [ ] 環境変数の設定
- [ ] Laravel migrationsの確認
- [ ] APIエンドポイントのテスト
- [ ] 管理者ログインの確認
- [ ] 会員ログインの確認
- [ ] ファイルアップロード機能の確認
- [ ] メール送信機能の確認

## サポート

移行に関する質問や問題がある場合は、開発チームまでお問い合わせください。
