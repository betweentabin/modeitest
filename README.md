# ちくぎん地域経済研究所 — 本番引き継ぎ用 README（Xserver + ConoHa）

このREADMEだけで本番環境（Xserver と ConoHa）への引き継ぎ・アップロードまで完結できるようにまとめています。メール設定、APIの切替、CORS、スケジューラ／キューなど運用に必要なポイントも網羅しています。

## 構成と前提

- フロントエンド: Vue.js 2.x（Vue CLI 4）／ビルド成果物は `dist/`
- バックエンド: Laravel 10（`laravel-backend/`）
- 推奨構成: フロント= Xserver（静的ホスティング）, API= ConoHa VPS（Nginx + PHP-FPM）
- ドメイン例: `www.example.com`（フロント） / `api.example.com`（API）

ディレクトリ概要
- `src/` フロントのソース
- `dist/` フロントのビルド出力
- `laravel-backend/` Laravel API 一式
- `deploy/konoha/` ConoHa向け Nginx/PHP-FPM サンプル

## 必要要件

- Xserver: FTP/SFTP で `dist/` をアップできる権限、.htaccess 有効、独自ドメイン + SSL
- ConoHa: Ubuntu 22.04 など、Nginx、PHP 8.2、Composer 2、MySQL 8 または PostgreSQL 14、git（任意）

## 本番手順の全体像（チェックリスト）

1) APIドメインを決める（例: `api.example.com`）/ フロントドメイン（例: `www.example.com`）
2) ConoHa に API を配置（後述の手順 A）
3) Xserver にフロント（`dist/`）を配置し、.htaccess を設定（後述の手順 B）
4) フロントの API 接続先を本番 API ドメインに切替（`src/config/api.js`）
5) 画像/PDF配信の整合性（/storage）を調整（PUBLIC_STORAGE_URL or .htaccess リライト）
6) メール送信（SMTP/Resend等）の環境変数設定と動作確認
7) スケジューラ（cron）／キューワーカー（queue:work）を有効化

---

## 手順 A: ConoHa へ API（Laravel）をデプロイ

1. サーバー準備（Ubuntu 22.04 の例）
```bash
sudo apt update && sudo apt upgrade -y
sudo apt install -y nginx php8.2 php8.2-fpm \
  php8.2-mbstring php8.2-xml php8.2-curl php8.2-zip php8.2-gd \
  php8.2-pgsql php8.2-mysql unzip git curl
# Composer
cd /usr/local/bin && sudo curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
```

2. コード配置
```bash
sudo mkdir -p /var/www/cri-app && sudo chown -R $USER:www-data /var/www/cri-app
cd /var/www/cri-app
# いずれか（git clone か SFTPアップロード）
git clone <this-repo-url> .
cd laravel-backend
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
```

3. .env 設定（代表値）
`laravel-backend/.env` を編集。最低限以下を設定してください。
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://api.example.com
LOG_CHANNEL=stack
LOG_LEVEL=info

# CORS（フロントの本番ドメインを許可）
CORS_ALLOWED_ORIGINS=https://www.example.com

# ストレージURL（絶対URLで返す）
PUBLIC_STORAGE_URL=https://api.example.com/storage

# DB: PostgreSQL の例（デフォルト）
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=cri
DB_USERNAME=cri
DB_PASSWORD=your_password

# DB: MySQL を使う場合はこちら
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=cri
# DB_USERNAME=cri
# DB_PASSWORD=your_password

# Queue / Cache / Session
QUEUE_CONNECTION=database
CACHE_DRIVER=file
SESSION_DRIVER=file
SESSION_LIFETIME=120

# メール（XserverのSMTPを使う例）
MAIL_MAILER=smtp
MAIL_HOST=svXXX.xserver.jp
MAIL_PORT=465
MAIL_ENCRYPTION=ssl
# 587/TLS を使う場合
# MAIL_PORT=587
# MAIL_ENCRYPTION=tls
MAIL_USERNAME=info@your-domain.jp
MAIL_PASSWORD=mailbox_password
MAIL_FROM_ADDRESS=info@your-domain.jp
MAIL_FROM_NAME="ちくぎん地域経済研究所"
MAIL_EHLO_DOMAIN=your-domain.jp

# 送信を一時停止したい場合（テスト用）
# MAIL_DRY_RUN=true

# 代替: Resend を使う場合
# MAIL_MAILER=resend
# RESEND_API_KEY=your_resend_api_key
```

4. ストレージとDB初期化
```bash
cd /var/www/cri-app/laravel-backend
php artisan storage:link
php artisan migrate --force
php artisan db:seed --force
```
初期管理者（Seeder）
- Admin（API管理画面用）
  - `admin@chikugin-cri.co.jp` / `admin123`（初回ログイン後に必ず変更）
  - `editor@chikugin-cri.co.jp` / `editor123`
  - `viewer@chikugin-cri.co.jp` / `viewer123`

5. パーミッション
```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo find storage -type d -exec chmod 775 {} \;
sudo find storage -type f -exec chmod 664 {} \;
```

6. Nginx 設定
- サンプル: `deploy/konoha/nginx.conf`
  - `root` を `.../laravel-backend/public` に変更
  - `server_name` を `api.example.com` に変更
```bash
sudo cp deploy/konoha/nginx.conf /etc/nginx/sites-available/cri-app
sudo ln -s /etc/nginx/sites-available/cri-app /etc/nginx/sites-enabled/cri-app
sudo nginx -t && sudo systemctl reload nginx
```

7. PHP-FPM 調整（任意）
- サンプル: `deploy/konoha/php-fpm-pool.conf`
```bash
sudo systemctl restart php8.2-fpm
```

8. スケジューラ/キュー
```bash
# 毎分スケジューラ（メール配信などのジョブ投入）
crontab -e
* * * * * cd /var/www/cri-app/laravel-backend && php artisan schedule:run >> /dev/null 2>&1

# キューワーカー（常駐）
# Supervisor例: /etc/supervisor/conf.d/laravel-worker.conf を作成
# [program:laravel-worker]
# command=php /var/www/cri-app/laravel-backend/artisan queue:work --queue=default --sleep=3 --tries=3 --max-time=3600
# autostart=true
# autorestart=true
# user=www-data
# redirect_stderr=true
# stdout_logfile=/var/log/supervisor/laravel-worker.log
# 反映
# sudo supervisorctl reread && sudo supervisorctl update && sudo supervisorctl start laravel-worker:*
```

9. 動作確認
```bash
curl -s https://api.example.com/api/health | jq
curl -s https://api.example.com/api/test | jq
```

---

## 手順 B: Xserver へフロント（Vueビルド）をデプロイ

1. フロントのビルド
```bash
npm ci
# API先を本番に切り替える（2つの方法のどちらか）
# A) `src/config/api.js` の production.baseURL を https://api.example.com に変更
# B) 環境変数方式に改修した場合: VUE_APP_API_URL=https://api.example.com を設定してビルド
npm run build
```

2. Xserver にアップロード
- サーバーパネルで対象ドメインの「公開フォルダ（ドキュメントルート）」を確認
- `dist/` の中身をその公開フォルダ直下へアップロード（SFTP/FTP）

3. .htaccess を配置（SPA 用 + /storage リライト）
`deploy/xserver/.htaccess` を公開フォルダ直下に置くか、以下内容を作成してください。
```apache
RewriteEngine On
RewriteBase /

# APIが返す相対パス /storage/... をAPIへ転送
RewriteRule ^storage/(.*)$ https://api.example.com/storage/$1 [L,PT]

# SPA の履歴リライト
RewriteRule ^index\.html$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.html [L]
```
注: API側で `PUBLIC_STORAGE_URL=https://api.example.com/storage` を設定していれば、返却URLが絶対URLになり、上記 /storage リライトは不要です（どちらでも可）。

4. SSL と動作確認
- Xserver で独自SSLを有効化し、`https://www.example.com` にアクセス
- 管理ログイン: `https://www.example.com/#/admin`（ハッシュモード）
- 管理ログイン後は API の `POST /api/admin/login` が成功することを確認

---

## メール送信（本番）

本プロジェクトは SMTP（例: Xserver）、Resend、SendGrid、Gmail API（制限環境用）に対応します。最小構成は SMTP です。

- SMTP（Xserver）の例は上記 .env を参照
- 送信テスト（管理API）: `POST /api/admin/emails/send-simple`
  - Body 例:
  ```json
  {
    "to": "your-address@example.com",
    "subject": "SMTP テスト",
    "body_text": "Hello via SMTP",
    "from": {"address": "info@your-domain.jp", "name": "ちくぎん地域経済研究所"}
  }
  ```
- うまく届かない場合の典型:
  - 530/535 認証: ユーザー名=メールアドレス、ポート/暗号化の組み合わせを再確認
  - 553 From 拒否: `MAIL_FROM_ADDRESS` が送信許可されたドメインであるか
  - タイムアウト: サーバー外向きSMTP制限→Resend/SendGrid検討

詳細なSMTPガイドは `laravel-backend/README.md` 参照。

---

## API ベースURLの切替（フロント）

- 現状（既定）: `src/config/api.js` の `production.baseURL` を本番APIへ書き換える
- 改修（推奨）: `process.env.VUE_APP_API_URL` があればそれを優先する実装に変更し、
  ビルド時に `VUE_APP_API_URL=https://api.example.com npm run build`

---

## CORS とストレージ

- CORS 許可: `laravel-backend/config/cors.php` は `CORS_ALLOWED_ORIGINS`（カンマ区切り）を参照
- 画像/PDFのURL: `PUBLIC_STORAGE_URL` を設定すると絶対URLを返すため、フロント側での `/storage` リライトが不要に

---

## ローカル開発（参考）

前提
- Node.js 16+ / npm
- PHP 8.1+ / Composer

セットアップ
```bash
npm ci
cd laravel-backend && composer install && cp .env.example .env && php artisan key:generate && cd ..
```

起動
```bash
# フロント（http://localhost:8080）
npm run dev

# API（http://localhost:8000）
cd laravel-backend && php artisan serve
```

APIをローカルに向けたい場合は `src/config/api.js` の baseURL を `http://127.0.0.1:8000` に一時変更するか、
環境変数方式へ改修してください。

---

## 付録: よく使う確認コマンド

- API稼働確認: `curl -s https://api.example.com/api/health | jq`
- ルート一覧: `curl -s https://api.example.com/api/debug-routes | jq`
- 権限/パス: `ls -ld laravel-backend/storage laravel-backend/bootstrap/cache`
- ジョブテーブル: `
  php artisan migrate:status | grep jobs
  `（`2019_08_19_000001_create_jobs_table.php` 等が適用済みであること）
