# ちくぎん地域経済研究所

地域経済研究のためのWebアプリケーションです。

## 技術スタック

- **フロントエンド**: Vue.js 2.6.11
- **バックエンド**: Laravel 10
- **ビルドツール**: Vite

## ローカル環境での起動方法

### 前提条件

- Node.js (v16以上推奨)
- PHP 8.1以上
- Composer
- npm

### 1. 依存関係のインストール

```bash
# フロントエンドの依存関係をインストール
npm install

# バックエンドの依存関係をインストール
cd laravel-backend
composer install
npm install
cd ..
```

### 2. 環境設定

```bash
# Laravelの環境設定
cd laravel-backend
cp .env.example .env
php artisan key:generate
cd ..
```

### 3. プロジェクトの起動

#### 方法1: 自動起動スクリプトを使用（推奨）

```bash
./start-local.sh
```

#### 方法2: 手動で起動

**ターミナル1 - フロントエンド:**
```bash
npm start
```

**ターミナル2 - Laravelバックエンド:**
```bash
cd laravel-backend
php artisan serve
```

**ターミナル3 - Vite開発サーバー:**
```bash
cd laravel-backend
npm run dev
```

### アクセスURL

- **フロントエンド**: http://localhost:8080
- **バックエンド**: http://localhost:8000
- **Vite開発サーバー**: http://localhost:5173

## 開発

### フロントエンド開発

Vue.jsコンポーネントは `src/components/` ディレクトリにあります。

### バックエンド開発

Laravelのコントローラーは `laravel-backend/app/Http/Controllers/` にあります。

## トラブルシューティング

### ポートが使用中の場合

```bash
# 使用中のポートを確認
lsof -i :8080
lsof -i :8000
lsof -i :5173

# プロセスを終了
kill -9 <PID>
```

### 依存関係のエラー

```bash
# node_modulesを削除して再インストール
rm -rf node_modules
npm install

# Laravelの依存関係も再インストール
cd laravel-backend
rm -rf vendor
composer install
```

## 環境ごとの設定ガイド（どこを変更するか）

本プロジェクトをローカル、Vercel、本番（ConoHa + Xserver + PostgreSQL）で運用する際の設定ポイントをまとめます。必要に応じて、以下のファイルの設定を変更してください。

### 1. 変更対象ファイル一覧（要点）

- フロントエンドのAPI接続先
  - `src/config/api.js`（APIベースURLの決定ロジックを管理します）
  - `vercel.json`（Vercel上での`/storage/*`リライトとSPAルーティングを定義します）
  - `vue.config.js`（ローカル開発サーバの履歴リライトを設定します）
- バックエンドの公開URL/CORS
  - `laravel-backend/.env` の `APP_URL`（`Storage::url()` の基準URLになります）
  - `laravel-backend/config/cors.php`（許可するオリジンを設定します）
- データベース
  - `laravel-backend/.env` の `DB_CONNECTION=pgsql` ほか `DB_*` 各種設定

補足: 現在の`src/config/api.js`は開発・本番ともに同一のAPIベースURL（RailwayのURL）を参照する構成です。移行の際は、ベースURLの切り替え方法を下記から選択してください。

### 2. ローカル環境（localhost）

- フロントエンド: `npm run dev` または `npm start` で起動します。
- バックエンド: `php artisan serve --port=8000` で起動します。
- API接続先の決め方:
  - 現状のままでは、`src/config/api.js` が本番API（Railway）へ向きます。ローカルのLaravelを参照したい場合は、`src/config/api.js` のベースURLを一時的に `http://127.0.0.1:8000` に変更してください。
  - もしくは、環境変数で切り替え可能な実装に改修した上で、`.env.local` に `VUE_APP_API_URL=http://127.0.0.1:8000` を設定して起動します（実装方針は「5. APIベースURLの切り替え方」を参照してください）。
- `/storage/*` の表示:
  - ローカルではVercelの`rewrites`は効きません。必要であれば `vue.config.js` に `/storage` をバックエンドへプロキシする設定を追加してください。

### 3. Vercel（現行構成）

- `vercel.json` にて以下を設定しています。
  - `/storage/*` → バックエンド（Railway）の `/storage/*` へリライト
  - SPA向けの履歴リライト（`/index.html`へ）
- フロントのAPI接続先は `src/config/api.js` が参照するベースURLに依存します。

### 4. 本番（ConoHa：API + PostgreSQL、Xserver：フロント）

- 推奨アーキテクチャ:
  - API: ConoHa VPS 上の Nginx + PHP-FPM + Laravel + PostgreSQL
  - フロント: Xserver に `dist/` を配置（SPA）
  - ドメインは `api.example.com`（API）と `www.example.com`（フロント）に分離します。

- Xserver 側（フロント）
  - `dist/` をアップロードします。
  - `.htaccess` に SPA 向けリライトを設定します（例）：
    ```
    RewriteEngine On
    RewriteBase /
    RewriteRule ^index\.html$ - [L]
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule . /index.html [L]
    ```
  - 画像やPDFなど `/storage/*` のURLは、API側の `APP_URL` を用いて「絶対URL」で返す構成にすると、フロント側で追加設定をせずに表示できます。

- ConoHa 側（API）
  - Nginx/PHP-FPMの設定例は `deploy/konoha/` を参照してください。
  - `laravel-backend/.env` を本番用に設定します。
    - `APP_URL=https://api.example.com`
    - `DB_CONNECTION=pgsql` と各 `DB_*` をPostgreSQLに合わせて設定します。
  - 初期化手順（例）
    - `composer install --no-dev --optimize-autoloader`
    - `php artisan key:generate`
    - `php artisan storage:link`
    - `php artisan migrate --force`（必要に応じて `db:seed`）
  - `laravel-backend/config/cors.php` の `allowed_origins` にフロントの本番ドメイン（例: `https://www.example.com`）を追加します。

### 5. APIベースURLの切り替え方

移行後も環境ごとにAPI先を柔軟に切り替えたい場合は、以下のどちらかの方針をお選びください。

- 方針A（現状維持）: `src/config/api.js` に本番APIの固定URLを書き、移行のタイミングで当該URLを書き換えます。
  - メリット: コードが簡単です。
  - デメリット: 環境ごとの切り替えにビルドが必要です。

- 方針B（推奨）: `src/config/api.js` を環境変数（例: `VUE_APP_API_URL`）で切り替えられるように改修します。
  - 例: 変数があればそれを優先し、なければ本番URLへフォールバックする実装にします。
  - ローカルでは `.env.local` に `VUE_APP_API_URL=http://127.0.0.1:8000` を設定して起動します。
  - Xserver（本番）では `VUE_APP_API_URL=https://api.example.com` をビルド時に設定します。

### 6. PostgreSQL の設定

- `laravel-backend/.env` で以下を設定します。
  - `DB_CONNECTION=pgsql`
  - `DB_HOST`
  - `DB_PORT`
  - `DB_DATABASE`
  - `DB_USERNAME`
  - `DB_PASSWORD`
- 既存データを移行する場合は、`pg_dump` / `pg_restore` によりダンプ・リストアを実施してください。

### 7. CORS とストレージURLの方針

- CORS: フロントドメインを `laravel-backend/config/cors.php` の許可オリジンに設定してください。
- 画像/PDFのURLは、`APP_URL` を正しく設定し、`/storage/*` を「絶対URL」で返す構成にすると環境差異の影響を受けにくくなります。

### 8. チェックリスト（本番切替時）

- DNS 切替の前に `APP_URL` と CORS 設定を確認します。
- SSL 証明書を有効化し、HTTPS での動作を確認します。
- フロントのAPI接続先（固定URLまたは `VUE_APP_API_URL`）を本番に合わせてビルドします。
- 画像/PDFが正しく表示されるか（`/storage/*` のURL解決）を確認します。
