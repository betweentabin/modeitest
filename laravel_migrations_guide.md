# Laravel マイグレーション作成ガイド

## 概要
このドキュメントは、設計したデータベーススキーマをLaravelマイグレーションとして実装する手順を説明します。

## マイグレーション作成コマンド

### 1. 基本テーブル作成

```bash
# 管理者テーブル
php artisan make:migration create_admins_table

# 会員テーブル
php artisan make:migration create_members_table

# 会員活動ログテーブル
php artisan make:migration create_member_activity_logs_table

# ページテーブル
php artisan make:migration create_pages_table

# セミナーテーブル
php artisan make:migration create_seminars_table

# セミナー申込テーブル
php artisan make:migration create_seminar_registrations_table

# 刊行物カテゴリテーブル
php artisan make:migration create_publication_categories_table

# 刊行物テーブル
php artisan make:migration create_publications_table

# 刊行物ダウンロードログテーブル
php artisan make:migration create_publication_downloads_table

# お知らせカテゴリテーブル
php artisan make:migration create_news_categories_table

# お知らせテーブル
php artisan make:migration create_news_table

# メディアテーブル
php artisan make:migration create_media_table

# お問い合わせカテゴリテーブル
php artisan make:migration create_inquiry_categories_table

# お問い合わせテーブル
php artisan make:migration create_inquiries_table

# お問い合わせ返信テーブル
php artisan make:migration create_inquiry_responses_table

# サイト設定テーブル
php artisan make:migration create_site_settings_table

# ページビューテーブル
php artisan make:migration create_page_views_table
```

## 主要マイグレーションファイルのサンプル

### 1. 管理者テーブル（create_admins_table.php）

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50)->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('full_name', 100);
            $table->enum('role', ['super_admin', 'admin', 'editor'])->default('admin');
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();
            
            $table->index(['email']);
            $table->index(['username']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('admins');
    }
};
```

### 2. 会員テーブル（create_members_table.php）

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('company_name', 200);
            $table->string('representative_name', 100);
            $table->string('phone', 20)->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->text('address')->nullable();
            $table->enum('membership_type', ['basic', 'standard', 'premium'])->default('basic');
            $table->enum('status', ['pending', 'active', 'suspended', 'cancelled'])->default('pending');
            $table->date('joined_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            
            $table->index(['email']);
            $table->index(['membership_type']);
            $table->index(['status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('members');
    }
};
```

### 3. セミナーテーブル（create_seminars_table.php）

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('seminars', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->text('description')->nullable();
            $table->longText('detailed_description')->nullable();
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('location', 200)->nullable();
            $table->integer('capacity')->default(0);
            $table->integer('current_participants')->default(0);
            $table->decimal('fee', 10, 2)->default(0.00);
            $table->enum('status', ['draft', 'scheduled', 'ongoing', 'completed', 'cancelled'])->default('draft');
            $table->enum('membership_requirement', ['none', 'basic', 'standard', 'premium'])->default('none');
            $table->string('featured_image', 500)->nullable();
            $table->date('application_deadline')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone', 20)->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('admins')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('admins')->onDelete('set null');
            $table->timestamps();
            
            $table->index(['date']);
            $table->index(['status']);
            $table->index(['membership_requirement']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('seminars');
    }
};
```

### 4. 刊行物テーブル（create_publications_table.php）

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('publications', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('publication_categories')->onDelete('set null');
            $table->date('publication_date');
            $table->string('author', 200)->default('ちくぎん地域経済研究所');
            $table->integer('pages')->default(0);
            $table->string('file_url', 500)->nullable();
            $table->decimal('file_size', 8, 2)->nullable();
            $table->string('cover_image', 500)->nullable();
            $table->enum('membership_level', ['free', 'basic', 'standard', 'premium'])->default('free');
            $table->integer('download_count')->default(0);
            $table->boolean('is_published')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->text('tags')->nullable();
            $table->string('isbn', 20)->nullable();
            $table->decimal('price', 10, 2)->default(0.00);
            $table->foreignId('created_by')->nullable()->constrained('admins')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('admins')->onDelete('set null');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            
            $table->index(['category_id']);
            $table->index(['publication_date']);
            $table->index(['membership_level']);
            $table->index(['is_published']);
            $table->index(['is_featured']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('publications');
    }
};
```

## シーダー作成

### 基本シーダー作成コマンド

```bash
# シーダーファイル作成
php artisan make:seeder AdminSeeder
php artisan make:seeder SiteSettingsSeeder
php artisan make:seeder NewsCategoriesSeeder
php artisan make:seeder PublicationCategoriesSeeder
php artisan make:seeder InquiryCategoriesSeeder
```

### AdminSeeder.php サンプル

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::create([
            'username' => 'admin',
            'email' => 'admin@chikugin-cri.co.jp',
            'password' => Hash::make('password123'),
            'full_name' => '管理者',
            'role' => 'super_admin',
        ]);
    }
}
```

## モデル作成

### モデル作成コマンド

```bash
php artisan make:model Admin
php artisan make:model Member
php artisan make:model Seminar
php artisan make:model SeminarRegistration
php artisan make:model Publication
php artisan make:model PublicationCategory
php artisan make:model News
php artisan make:model NewsCategory
php artisan make:model Inquiry
php artisan make:model Media
php artisan make:model SiteSetting
```

### モデルサンプル（Member.php）

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'email',
        'password',
        'company_name',
        'representative_name',
        'phone',
        'postal_code',
        'address',
        'membership_type',
        'status',
        'joined_date',
        'expiry_date',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'joined_date' => 'date',
        'expiry_date' => 'date',
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    // リレーション
    public function activityLogs()
    {
        return $this->hasMany(MemberActivityLog::class);
    }

    public function seminarRegistrations()
    {
        return $this->hasMany(SeminarRegistration::class);
    }

    public function publicationDownloads()
    {
        return $this->hasMany(PublicationDownload::class);
    }
}
```

## 実行手順

### 1. マイグレーション実行

```bash
# マイグレーション実行
php artisan migrate

# ロールバック（必要に応じて）
php artisan migrate:rollback

# 全て削除して再実行
php artisan migrate:fresh

# シーダー込みで実行
php artisan migrate:fresh --seed
```

### 2. シーダー実行

```bash
# 全シーダー実行
php artisan db:seed

# 特定シーダー実行
php artisan db:seed --class=AdminSeeder
```

## 注意事項

### 1. 外部キー制約
- 依存関係のあるテーブルの作成順序に注意
- カテゴリテーブルを先に作成する

### 2. インデックス
- 検索・ソートで使用するカラムにインデックスを設定
- 外部キーには自動的にインデックスが作成される

### 3. データ型
- 文字列長の適切な設定
- decimal型の精度・スケール設定
- enum型の値の一貫性

### 4. 本番環境への適用
- 必ずバックアップを取得
- ダウンタイムを考慮した実行計画
- 段階的な実行を検討

## トラブルシューティング

### よくあるエラーと対処法

1. **外部キー制約エラー**
   - 参照先テーブルが存在しない
   - データ型が一致しない

2. **インデックス名重複エラー**
   - インデックス名を明示的に指定

3. **文字化けエラー**
   - データベース・テーブルの文字エンコーディング確認

4. **権限エラー**
   - データベースユーザーの権限確認
