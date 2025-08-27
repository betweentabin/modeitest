#!/bin/bash

echo "🚀 Laravel API Starting..."

# データベースディレクトリを作成
mkdir -p database
touch database/database.sqlite
chmod 664 database/database.sqlite

# ストレージディレクトリの権限設定
mkdir -p storage/logs
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# マイグレーション実行
php artisan migrate --force
php artisan db:seed --force

# Laravel 起動
echo "✅ Starting Laravel server on port $PORT"
php artisan serve --host=0.0.0.0 --port=$PORT
