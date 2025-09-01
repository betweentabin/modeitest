#!/bin/bash

echo "🚀 Laravel API Starting..."

# APP_KEYの確認（Railway環境変数を使用）
if [ -z "$APP_KEY" ]; then
  echo "⚠️  APP_KEYが設定されていません。Railway環境変数を確認してください。"
  # Railway環境ではAPP_KEYが自動設定されるはず
else
  echo "✅ APP_KEY設定済み"
fi

# Railway環境変数の確認
echo "🔍 Railway環境変数確認:"
echo "DATABASE_URL: ${DATABASE_URL:0:30}..." 
echo "PGHOST: $PGHOST"
echo "PGPORT: $PGPORT"
echo "PGDATABASE: $PGDATABASE"
echo "PGUSER: $PGUSER"

# PostgreSQL接続確認
echo "📊 データベース接続確認中..."
php artisan migrate:status || echo "⚠️  データベース接続に問題があります - 内部ネットワーク接続を確認中"

# 接続テスト
echo "🔗 環境変数を使った接続テスト..."
php artisan tinker --execute="
try {
    \$result = DB::connection()->getPdo();
    echo 'データベース接続成功!' . PHP_EOL;
    echo 'PostgreSQLバージョン: ' . DB::select('SELECT version()')[0]->version . PHP_EOL;
} catch (Exception \$e) {
    echo 'データベース接続失敗: ' . \$e->getMessage() . PHP_EOL;
}
" || echo "⚠️  接続テストスキップ"

# ストレージディレクトリの権限設定
mkdir -p storage/logs
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# マイグレーション実行（エラーでも続行）
php artisan migrate --force || echo "マイグレーション失敗、続行します"

# シードの実行（エラーでも続行）
php artisan db:seed --force || echo "シード失敗、続行します"

# キャッシュクリア（ルートキャッシュは無効化）
php artisan config:cache || echo "設定キャッシュ失敗"
php artisan route:clear || echo "ルートキャッシュクリア失敗"
# php artisan route:cache || echo "ルートキャッシュ失敗" # 一時的に無効化

# Laravel 起動
echo "✅ Starting Laravel server on port $PORT"
php artisan serve --host=0.0.0.0 --port=$PORT
