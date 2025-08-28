#!/bin/bash

echo "🚀 Laravel API Starting..."

# APP_KEYが設定されていない場合は生成
if [ -z "$APP_KEY" ]; then
  echo "APP_KEYが設定されていません。生成中..."
  php artisan key:generate --force
else
  echo "APP_KEY設定済み"
fi

# データベースディレクトリを作成
mkdir -p database
touch database/database.sqlite
chmod 664 database/database.sqlite

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
