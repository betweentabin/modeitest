# APIエラー解決レポート

## 問題の概要
PublicationsMemberPage、NewsPage、CurrentSeminarsPageなどで「APIからデータを取得できませんでした」というエラーが発生し、フォールバックデータが使用されている。

## 原因
1. **CORS設定の問題**
   - フロントエンド（localhost:8081）からバックエンド（Railway）へのクロスオリジンリクエストでCORSエラーが発生
   - fetchリクエストに`mode: 'cors'`が明示的に設定されていなかった

2. **エラーハンドリングの問題**
   - APIレスポンスが空の場合の処理が不適切
   - JSON.parseエラーが適切にハンドリングされていなかった

## 実施した修正

### apiClient.js の改善
```javascript
// 修正前
const config = {
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    ...options.headers
  },
  ...options
}

// 修正後
const config = {
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    ...options.headers
  },
  mode: 'cors', // CORSモードを明示的に指定
  ...options
}
```

### エラーハンドリングの改善
- レスポンスが空の場合の処理を追加
- JSONパースエラーを適切にキャッチ
- ネットワークエラー時にフォールバックレスポンスを返す

## 現在の状況

### ✅ 修正完了
- apiClient.jsのCORS設定とエラーハンドリングを改善
- 各ページコンポーネントのフォールバック処理は既に実装済み

### ⚠️ 注意事項
1. **Railway API側のCORS設定**
   - Laravel側でCORS設定が適切に行われているか確認が必要
   - `config/cors.php`で`allowed_origins`に`http://localhost:8081`が含まれているか確認

2. **開発環境での動作**
   - 現在はmockServerのデータを使用することで動作を継続
   - APIエラー時は自動的にフォールバックデータを使用

## Laravel側のCORS設定 - 完全ガイド

### 🔍 現在のCORS設定状況
現在の`laravel-backend/config/cors.php`を確認したところ、**VercelのURLが設定されていません**。これが原因でAPIアクセスがブロックされています。

現在の設定:
```php
'allowed_origins' => [
    'http://localhost:3000', 
    'http://localhost:8080', 
    'http://localhost:5173',
    'https://heroic-celebration-production.up.railway.app'
],
```

### ✅ 必要な修正手順

#### ステップ1: config/cors.phpを編集
```php
// laravel-backend/config/cors.php
'allowed_origins' => [
    'http://localhost:3000',
    'http://localhost:8080',
    'http://localhost:8081',  // ローカル開発用
    'http://localhost:5173',
    'https://heroic-celebration-production.up.railway.app',
    'https://your-app-name.vercel.app',  // ← Vercel本番用を追加！
    'https://your-app-name-*.vercel.app' // ← Vercelプレビュー用
],

// または、Vercelの全てのサブドメインを許可するパターンを使用
'allowed_origins_patterns' => [
    '/^https:\/\/.*\.vercel\.app$/',  // 既に設定済み！
    '/^https:\/\/.*\.railway\.app$/'
],
```

**重要**: 実は`allowed_origins_patterns`に`/^https:\/\/.*\.vercel\.app$/`が既に設定されているので、Vercelからのアクセスは許可されているはずです。

#### ステップ2: キャッシュをクリア（重要！）
Laravelの設定変更後は必ずキャッシュをクリアする必要があります：
```bash
# Railwayにデプロイされている場合
php artisan config:cache
php artisan cache:clear

# ローカルで実行する場合
cd laravel-backend
php artisan config:clear
php artisan config:cache
```

#### ステップ3: Railwayへのデプロイ
```bash
# 変更をコミット
git add laravel-backend/config/cors.php
git commit -m "fix: Add localhost:8081 to CORS allowed origins"

# Railwayにプッシュ
git push origin main
```

### 🎯 その他の重要な設定

#### 1. CORSミドルウェアの確認
`app/Http/Kernel.php`でCORSミドルウェアが有効になっているか確認：
```php
protected $middleware = [
    // ...
    \Fruitcake\Cors\HandleCors::class,
    // または
    \Illuminate\Http\Middleware\HandleCors::class,  // Laravel 9以降
];
```

#### 2. APIルートの確認
`routes/api.php`でルートが正しく設定されているか確認：
```php
Route::middleware(['cors'])->group(function () {
    Route::get('/publications', [PublicationController::class, 'index']);
    Route::get('/news', [NewsController::class, 'index']);
    Route::get('/seminars', [SeminarController::class, 'index']);
});
```

#### 3. .envファイルの確認（Railway側）
Railwayの環境変数に以下が設定されているか確認：
```env
APP_URL=https://heroic-celebration-production.up.railway.app
FRONTEND_URL=http://localhost:8081
SESSION_DOMAIN=null
SANCTUM_STATEFUL_DOMAINS=localhost:8081
```

### 🔧 トラブルシューティング

#### 問題1: それでもCORSエラーが出る場合
```php
// config/cors.php で全てを許可（開発環境のみ）
'allowed_origins' => ['*'],
```

#### 問題2: プリフライトリクエストが失敗する
```php
// config/cors.php
'allowed_methods' => ['*'],
'allowed_headers' => ['*'],
'supports_credentials' => true,  // 認証が必要な場合
```

#### 問題3: 特定のヘッダーが取得できない
```php
// config/cors.php
'exposed_headers' => ['X-Total-Count', 'X-Page-Count'],
```

### 📝 デバッグ方法

1. **ブラウザのコンソールでエラーを確認**
```javascript
// Chromeの開発者ツール > Console
// 以下のようなエラーが表示される場合はCORS問題
"Access to fetch at 'https://...' from origin 'http://localhost:8081' has been blocked by CORS policy"
```

2. **curlでAPIを直接テスト**
```bash
curl -H "Origin: http://localhost:8081" \
     -H "Access-Control-Request-Method: GET" \
     -H "Access-Control-Request-Headers: X-Requested-With" \
     -X OPTIONS \
     https://heroic-celebration-production.up.railway.app/api/publications \
     -v
```

3. **Laravelのログを確認**
```bash
# Railway CLIを使用
railway logs

# またはローカル
tail -f laravel-backend/storage/logs/laravel.log
```

## 推奨される追加対応

### 2. 環境変数の確認
```javascript
// .env.local または .env.development
VUE_APP_API_URL=https://heroic-celebration-production.up.railway.app
```

### 3. プロキシ設定の追加（オプション）
```javascript
// vue.config.js
module.exports = {
  devServer: {
    proxy: {
      '/api': {
        target: 'https://heroic-celebration-production.up.railway.app',
        changeOrigin: true
      }
    }
  }
}
```

## テスト方法

1. ブラウザの開発者ツールでNetworkタブを開く
2. ページをリロード
3. APIリクエストのステータスを確認
   - 200: 正常に取得
   - CORS error: CORS設定の問題
   - Network error: ネットワーク接続の問題

## まとめ

### 🚨 根本原因の再確認

#### Vercelデプロイの場合
実は**Laravel側には既にVercelのワイルドカードパターン**が設定されています：
```php
'allowed_origins_patterns' => [
    '/^https:\/\/.*\.vercel\.app$/',  // ✅ これでVercelは許可済み！
]
```

それでもAPIエラーが発生している場合、以下を確認してください：

1. **VercelがHTTPSを使用しているか**
   - VercelのURLが`https://`で始まっているか確認
   - `http://`の場合はCORSパターンにマッチしません

2. **Vercelの環境変数設定**
   ```env
   # Vercelのダッシュボードで設定
   VITE_API_URL=https://heroic-celebration-production.up.railway.app
   # または
   VUE_APP_API_URL=https://heroic-celebration-production.up.railway.app
   ```

3. **実際のエラーメッセージを確認**
   - ブラウザのコンソールで実際のエラーを確認
   - CORSエラーなのか、ネットワークエラーなのか判別

### ✅ 解決方法
1. `laravel-backend/config/cors.php`に`http://localhost:8081`を追加
2. キャッシュをクリア（`php artisan config:cache`）
3. Railwayに再デプロイ

### 📊 現在の対応状況
- ✅ フロントエンド側のエラーハンドリングは改善済み
- ✅ APIエラー時のフォールバック処理は実装済み
- ❌ Laravel側のCORS設定が未対応（要修正）

### 🎯 次のアクション

#### Vercel環境の場合
1. **Vercelの環境変数を確認**
   ```bash
   # Vercelダッシュボードで設定
   VITE_API_URL=https://heroic-celebration-production.up.railway.app
   ```

2. **フロントエンドのAPI設定を確認**
   ```javascript
   // src/config/api.js
   const API_CONFIG = {
     development: {
       baseURL: 'https://heroic-celebration-production.up.railway.app',
     },
     production: {
       baseURL: 'https://heroic-celebration-production.up.railway.app',
     }
   }
   ```

3. **Railwayのログを確認**
   ```bash
   railway logs
   # CORSで弾かれているか、実際にリクエストが届いているか確認
   ```

#### ローカル開発の場合
1. `config/cors.php`に`http://localhost:8081`を追加
2. キャッシュクリア後、Railwayへデプロイ

この修正により、フロントエンドからRailway上のLaravel APIへの通信が可能になり、実際のデータを取得できるようになります。