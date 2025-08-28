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