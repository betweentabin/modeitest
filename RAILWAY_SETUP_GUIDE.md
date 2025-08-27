# Railway デプロイメント設定ガイド

## 1. APP_KEYの設定

### 自動生成の場合
start.shで自動的にAPP_KEYが生成されるようになっています。
手動で設定したい場合は以下の手順で行ってください。

### 手動設定の場合

1. ローカルでAPP_KEYを生成:
```bash
cd laravel-backend
php artisan key:generate --show
```

2. Railway の管理画面で環境変数を設定:
- Railway プロジェクトのダッシュボードにアクセス
- 「Variables」タブをクリック
- 「New Variable」をクリック
- 以下の環境変数を追加:

## 2. 必要な環境変数

### 基本設定
```
APP_NAME=ちくぎん地域経済研究所
APP_ENV=production
APP_DEBUG=false
APP_URL=https://heroic-celebration-production.up.railway.app
```

### APP_KEY (必須)
```
APP_KEY=base64:your-generated-key-here
```

### データベース設定
```
DB_CONNECTION=sqlite
DB_DATABASE=/app/database/database.sqlite
```

### セッション・キャッシュ設定
```
SESSION_DRIVER=file
SESSION_LIFETIME=120
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

### CORS設定
```
SANCTUM_STATEFUL_DOMAINS=localhost:3000,localhost:8080,localhost:5173,heroic-celebration-production.up.railway.app
```

### 管理者認証設定
```
ADMIN_EMAIL=admin@example.com
ADMIN_PASSWORD=securepassword123
```

## 3. デプロイ後の確認

1. ログの確認:
- Railway ダッシュボードで「Deployments」タブ
- 最新のデプロイメントをクリック
- 「View Logs」でエラーログを確認

2. API動作確認:
```
https://heroic-celebration-production.up.railway.app/
```

## 4. トラブルシューティング

### 500 Internal Server Error の場合

1. APP_KEYが設定されているか確認
2. データベースマイグレーションが成功しているか確認
3. ストレージディレクトリの権限が正しいか確認

### デバッグ用設定 (一時的)
本番環境でのデバッグが必要な場合:
```
APP_DEBUG=true
LOG_LEVEL=debug
```

**注意**: デバッグ完了後は必ず `APP_DEBUG=false` に戻してください。

## 5. セキュリティ考慮事項

- APP_KEYは絶対に外部に漏らさない
- 管理者パスワードは強力なものを設定
- 本番環境では APP_DEBUG=false に設定
- ログレベルは error または warning に設定

## 6. 更新手順

環境変数を更新した後:
1. Railway で変数を保存
2. 自動的に再デプロイが実行される
3. デプロイメントログで成功を確認
