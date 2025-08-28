# ちくぎん地域経済研究所 データベース設計書

## 概要
このドキュメントは、ちくぎん地域経済研究所のWebサイトおよびCMSシステムのデータベース設計について説明します。

## 設計方針

### 1. スケーラビリティ
- 将来的な機能拡張に対応できる柔軟な設計
- 大量のデータにも対応できるインデックス設計

### 2. セキュリティ
- 適切な外部キー制約
- パスワードのハッシュ化
- IPアドレスやユーザーエージェントのログ記録

### 3. 保守性
- 明確な命名規則
- 適切な正規化
- わかりやすいテーブル構造

## データベース構造

### 主要なテーブルグループ

#### 1. ユーザー管理
- `admins`: 管理者アカウント
- `members`: 会員アカウント
- `member_activity_logs`: 会員の活動ログ

#### 2. コンテンツ管理（CMS）
- `pages`: 静的ページ管理
- `news`: お知らせ・ニュース
- `news_categories`: お知らせカテゴリ

#### 3. セミナー管理
- `seminars`: セミナー情報
- `seminar_registrations`: セミナー申込

#### 4. 刊行物管理
- `publications`: 刊行物
- `publication_categories`: 刊行物カテゴリ
- `publication_downloads`: ダウンロードログ

#### 5. お問い合わせ管理
- `inquiries`: お問い合わせ
- `inquiry_categories`: お問い合わせカテゴリ
- `inquiry_responses`: お問い合わせ返信

#### 6. システム管理
- `media`: ファイル・メディア管理
- `site_settings`: サイト設定
- `page_views`: ページビュー統計

## 詳細設計

### テーブル詳細

#### 1. admins（管理者）
| カラム名 | データ型 | 制約 | 説明 |
|---------|---------|------|------|
| id | BIGINT | PK, AUTO_INCREMENT | 管理者ID |
| username | VARCHAR(50) | UNIQUE, NOT NULL | ユーザー名 |
| email | VARCHAR(255) | UNIQUE, NOT NULL | メールアドレス |
| password_hash | VARCHAR(255) | NOT NULL | パスワードハッシュ |
| full_name | VARCHAR(100) | NOT NULL | 氏名 |
| role | ENUM | DEFAULT 'admin' | 権限レベル |
| is_active | BOOLEAN | DEFAULT TRUE | 有効/無効 |

#### 2. members（会員）
| カラム名 | データ型 | 制約 | 説明 |
|---------|---------|------|------|
| id | BIGINT | PK, AUTO_INCREMENT | 会員ID |
| email | VARCHAR(255) | UNIQUE, NOT NULL | メールアドレス |
| password_hash | VARCHAR(255) | NOT NULL | パスワードハッシュ |
| company_name | VARCHAR(200) | NOT NULL | 会社名 |
| representative_name | VARCHAR(100) | NOT NULL | 代表者名 |
| membership_type | ENUM | DEFAULT 'basic' | 会員種別 |
| status | ENUM | DEFAULT 'pending' | 会員ステータス |

#### 3. seminars（セミナー）
| カラム名 | データ型 | 制約 | 説明 |
|---------|---------|------|------|
| id | BIGINT | PK, AUTO_INCREMENT | セミナーID |
| title | VARCHAR(200) | NOT NULL | タイトル |
| description | TEXT | | 概要 |
| date | DATE | NOT NULL | 開催日 |
| start_time | TIME | NOT NULL | 開始時間 |
| end_time | TIME | NOT NULL | 終了時間 |
| capacity | INT | DEFAULT 0 | 定員 |
| fee | DECIMAL(10,2) | DEFAULT 0.00 | 参加費 |
| status | ENUM | DEFAULT 'draft' | ステータス |

#### 4. publications（刊行物）
| カラム名 | データ型 | 制約 | 説明 |
|---------|---------|------|------|
| id | BIGINT | PK, AUTO_INCREMENT | 刊行物ID |
| title | VARCHAR(200) | NOT NULL | タイトル |
| description | TEXT | | 概要 |
| category_id | BIGINT | FK | カテゴリID |
| publication_date | DATE | NOT NULL | 発行日 |
| file_url | VARCHAR(500) | | ファイルURL |
| membership_level | ENUM | DEFAULT 'free' | 閲覧権限レベル |
| download_count | INT | DEFAULT 0 | ダウンロード数 |

## インデックス設計

### パフォーマンス最適化のためのインデックス

#### 1. 検索用インデックス
- `members.email`: ログイン認証
- `publications.membership_level`: 権限フィルタリング
- `seminars.date`: 日付順ソート
- `news.published_at`: 公開日順ソート

#### 2. 関連テーブル結合用インデックス
- `seminar_registrations.seminar_id`: セミナー申込一覧
- `publication_downloads.publication_id`: ダウンロード履歴
- `inquiry_responses.inquiry_id`: お問い合わせ返信

## セキュリティ考慮事項

### 1. データ保護
- パスワードは必ずハッシュ化して保存
- 個人情報の適切な管理
- 削除時のカスケード設定

### 2. アクセス制御
- 会員レベルによるコンテンツアクセス制御
- 管理者権限の階層化
- ログイン履歴の記録

### 3. 監査ログ
- 重要な操作の履歴保存
- IPアドレスとユーザーエージェントの記録
- データ変更時のタイムスタンプ

## 拡張性

### 将来的な機能追加への対応

#### 1. 多言語対応
- 各テーブルに言語フィールドの追加可能
- 翻訳テーブルの作成可能

#### 2. マルチサイト対応
- `site_id`フィールドの追加
- サイト別データ管理

#### 3. 高度な分析機能
- より詳細な統計テーブル
- A/Bテスト用テーブル

## パフォーマンス最適化

### 1. クエリ最適化
- 適切なインデックスの設計
- N+1問題の回避
- ページネーション実装

### 2. データ分割
- 大きなテーブルの分割検討
- アーカイブデータの分離

### 3. キャッシュ戦略
- 頻繁にアクセスされるデータのキャッシュ
- Redis等の活用

## 移行計画

### 現在のmockServerからの移行手順

#### フェーズ1: 基本機能移行
1. 基本テーブル作成
2. 管理者・会員データ移行
3. ページデータ移行

#### フェーズ2: コンテンツ移行
1. セミナーデータ移行
2. 刊行物データ移行
3. お知らせデータ移行

#### フェーズ3: 高度機能追加
1. 統計・分析機能
2. 詳細ログ機能
3. 最適化・チューニング

## 運用・保守

### 1. バックアップ戦略
- 定期的なフルバックアップ
- トランザクションログバックアップ
- 災害復旧計画

### 2. モニタリング
- パフォーマンス監視
- エラーログ監視
- 容量監視

### 3. メンテナンス
- 定期的なインデックス再構築
- 統計情報の更新
- 不要データの削除

## 技術要件

### 推奨環境
- **データベース**: MySQL 8.0 以上 / PostgreSQL 13 以上
- **文字エンコーディング**: UTF8MB4
- **タイムゾーン**: Asia/Tokyo
- **照合順序**: utf8mb4_unicode_ci

### 必要な権限
- CREATE, DROP, ALTER: スキーマ変更
- SELECT, INSERT, UPDATE, DELETE: データ操作
- INDEX: インデックス管理
- REFERENCES: 外部キー制約
