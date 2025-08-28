# API設計書

## 概要
ちくぎん地域経済研究所のWebサイト・CMSシステムのRESTful API設計書です。

## ベースURL
- **開発環境**: `http://localhost:8000/api`
- **本番環境**: `https://api.chikugin-cri.co.jp/api`

## 認証

### JWT認証
- すべての認証が必要なエンドポイントには`Authorization: Bearer {token}`ヘッダーが必要
- 管理者用と会員用で異なる認証システム

```
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...
```

## レスポンス形式

### 成功レスポンス
```json
{
    "success": true,
    "data": {
        // レスポンスデータ
    },
    "message": "操作が正常に完了しました"
}
```

### エラーレスポンス
```json
{
    "success": false,
    "error": {
        "code": "VALIDATION_ERROR",
        "message": "入力データに誤りがあります",
        "details": {
            "email": ["メールアドレスの形式が正しくありません"]
        }
    }
}
```

## エンドポイント一覧

### 1. 認証（Authentication）

#### 管理者ログイン
```
POST /admin/login
```

**リクエスト:**
```json
{
    "email": "admin@chikugin-cri.co.jp",
    "password": "password123"
}
```

**レスポンス:**
```json
{
    "success": true,
    "data": {
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
        "admin": {
            "id": 1,
            "username": "admin",
            "email": "admin@chikugin-cri.co.jp",
            "full_name": "管理者",
            "role": "super_admin"
        }
    }
}
```

#### 会員ログイン
```
POST /member/login
```

#### 会員登録
```
POST /member/register
```

**リクエスト:**
```json
{
    "email": "member@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "company_name": "株式会社サンプル",
    "representative_name": "山田太郎",
    "phone": "092-123-4567",
    "postal_code": "810-0001",
    "address": "福岡県福岡市中央区...",
    "membership_type": "standard"
}
```

### 2. セミナー管理（Seminars）

#### セミナー一覧取得
```
GET /seminars
```

**クエリパラメータ:**
- `page`: ページ番号（デフォルト: 1）
- `per_page`: 1ページあたりの件数（デフォルト: 10）
- `status`: ステータスフィルタ（scheduled, ongoing, completed）
- `membership_requirement`: 会員種別フィルタ
- `date_from`: 開始日フィルタ
- `date_to`: 終了日フィルタ

**レスポンス:**
```json
{
    "success": true,
    "data": {
        "seminars": [
            {
                "id": 1,
                "title": "採用力強化！経営・人事向け　面接官トレーニングセミナー",
                "description": "優秀な人材を見極め、獲得するための面接技術を習得できるセミナーです。",
                "date": "2025-06-15",
                "start_time": "14:00:00",
                "end_time": "17:00:00",
                "location": "ちくぎん地域経済研究所 会議室A",
                "capacity": 30,
                "current_participants": 15,
                "fee": 5000.00,
                "status": "scheduled",
                "membership_requirement": "basic",
                "featured_image": "/storage/seminars/seminar1.jpg"
            }
        ],
        "pagination": {
            "current_page": 1,
            "total_pages": 5,
            "total_items": 47,
            "per_page": 10
        }
    }
}
```

#### セミナー詳細取得
```
GET /seminars/{id}
```

#### セミナー作成（管理者のみ）
```
POST /admin/seminars
Authorization: Bearer {admin_token}
```

#### セミナー申込
```
POST /seminars/{id}/register
Authorization: Bearer {member_token} (会員の場合)
```

**リクエスト:**
```json
{
    "name": "山田太郎",
    "email": "yamada@example.com",
    "company": "株式会社サンプル",
    "phone": "092-123-4567",
    "special_requests": "車いす対応をお願いします"
}
```

### 3. 刊行物管理（Publications）

#### 刊行物一覧取得
```
GET /publications
```

**クエリパラメータ:**
- `category_id`: カテゴリフィルタ
- `membership_level`: 会員レベルフィルタ
- `is_featured`: 注目刊行物フィルタ
- `search`: 検索キーワード

#### 刊行物詳細取得
```
GET /publications/{id}
```

#### 刊行物ダウンロード
```
GET /publications/{id}/download
Authorization: Bearer {member_token}
```

**注意:** 会員レベルに応じたアクセス制御あり

#### 刊行物作成（管理者のみ）
```
POST /admin/publications
Authorization: Bearer {admin_token}
Content-Type: multipart/form-data
```

### 4. お知らせ管理（News）

#### お知らせ一覧取得
```
GET /news
```

#### お知らせ詳細取得
```
GET /news/{id}
```

#### お知らせ作成（管理者のみ）
```
POST /admin/news
Authorization: Bearer {admin_token}
```

### 5. ページ管理（Pages）

#### ページ一覧取得（管理者のみ）
```
GET /admin/pages
Authorization: Bearer {admin_token}
```

#### ページ詳細取得
```
GET /pages/{page_key}
```

#### ページ更新（管理者のみ）
```
PUT /admin/pages/{id}
Authorization: Bearer {admin_token}
```

### 6. お問い合わせ（Inquiries）

#### お問い合わせ送信
```
POST /inquiries
```

**リクエスト:**
```json
{
    "category_id": 1,
    "name": "山田太郎",
    "email": "yamada@example.com",
    "company": "株式会社サンプル",
    "phone": "092-123-4567",
    "subject": "セミナーについて",
    "message": "来月のセミナーについて詳しく教えてください。"
}
```

#### お問い合わせ一覧取得（管理者のみ）
```
GET /admin/inquiries
Authorization: Bearer {admin_token}
```

#### お問い合わせ返信（管理者のみ）
```
POST /admin/inquiries/{id}/respond
Authorization: Bearer {admin_token}
```

### 7. 会員管理（Members）

#### 会員一覧取得（管理者のみ）
```
GET /admin/members
Authorization: Bearer {admin_token}
```

#### 会員詳細取得（管理者のみ）
```
GET /admin/members/{id}
Authorization: Bearer {admin_token}
```

#### 会員情報更新
```
PUT /member/profile
Authorization: Bearer {member_token}
```

### 8. メディア管理（Media）

#### ファイルアップロード（管理者のみ）
```
POST /admin/media
Authorization: Bearer {admin_token}
Content-Type: multipart/form-data
```

#### メディア一覧取得（管理者のみ）
```
GET /admin/media
Authorization: Bearer {admin_token}
```

### 9. サイト設定（Site Settings）

#### 設定一覧取得
```
GET /settings
```

#### 設定更新（管理者のみ）
```
PUT /admin/settings
Authorization: Bearer {admin_token}
```

### 10. 統計・分析（Analytics）

#### ダッシュボード統計（管理者のみ）
```
GET /admin/analytics/dashboard
Authorization: Bearer {admin_token}
```

**レスポンス:**
```json
{
    "success": true,
    "data": {
        "total_members": 1250,
        "new_members_this_month": 45,
        "total_seminars": 128,
        "upcoming_seminars": 8,
        "total_publications": 89,
        "total_downloads": 15420,
        "pending_inquiries": 12,
        "page_views_this_month": 8540
    }
}
```

## HTTPステータスコード

| コード | 説明 |
|-------|------|
| 200 | 成功 |
| 201 | 作成成功 |
| 400 | リクエストエラー |
| 401 | 認証エラー |
| 403 | 権限不足 |
| 404 | リソース不在 |
| 422 | バリデーションエラー |
| 500 | サーバーエラー |

## エラーコード一覧

| コード | 説明 |
|-------|------|
| VALIDATION_ERROR | 入力データ検証エラー |
| AUTHENTICATION_FAILED | 認証失敗 |
| UNAUTHORIZED | 権限不足 |
| RESOURCE_NOT_FOUND | リソースが見つからない |
| MEMBERSHIP_REQUIRED | 会員登録が必要 |
| INSUFFICIENT_MEMBERSHIP | 会員レベル不足 |
| CAPACITY_EXCEEDED | 定員超過 |
| REGISTRATION_CLOSED | 申込期間終了 |

## レート制限

### 一般API
- 1時間あたり1000リクエスト

### 認証API
- 1時間あたり50リクエスト

### ファイルアップロード
- 1日あたり100ファイル

## セキュリティ

### 1. 入力検証
- 全入力データのサニタイゼーション
- SQLインジェクション対策
- XSS対策

### 2. 認証・認可
- JWTトークンの有効期限管理
- 権限レベル別アクセス制御
- リフレッシュトークン機能

### 3. ログ記録
- API呼び出しログ
- エラーログ
- セキュリティイベントログ

## APIバージョニング

### バージョン管理
- URLパス方式: `/api/v1/seminars`
- ヘッダー方式: `Accept: application/vnd.api+json;version=1`

### 互換性
- 破壊的変更時は新バージョンを作成
- 旧バージョンのサポート期間を明示

## テスト

### テストデータ
- 開発環境用のサンプルデータ提供
- テスト用アカウント情報

### API仕様書
- OpenAPI 3.0形式での詳細仕様
- Postmanコレクション提供

## 実装ガイド

### Laravel実装例

#### ルート定義（routes/api.php）
```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    AuthController,
    SeminarController,
    PublicationController,
    NewsController,
    InquiryController
};

// 認証不要エンドポイント
Route::get('/seminars', [SeminarController::class, 'index']);
Route::get('/seminars/{seminar}', [SeminarController::class, 'show']);
Route::get('/publications', [PublicationController::class, 'index']);
Route::get('/news', [NewsController::class, 'index']);
Route::post('/inquiries', [InquiryController::class, 'store']);

// 管理者認証
Route::prefix('admin')->group(function () {
    Route::post('/login', [AuthController::class, 'adminLogin']);
    
    Route::middleware('auth:admin')->group(function () {
        Route::apiResource('seminars', SeminarController::class);
        Route::apiResource('publications', PublicationController::class);
        Route::apiResource('news', NewsController::class);
        Route::get('/inquiries', [InquiryController::class, 'index']);
    });
});

// 会員認証
Route::prefix('member')->group(function () {
    Route::post('/login', [AuthController::class, 'memberLogin']);
    Route::post('/register', [AuthController::class, 'memberRegister']);
    
    Route::middleware('auth:member')->group(function () {
        Route::put('/profile', [AuthController::class, 'updateProfile']);
        Route::post('/seminars/{seminar}/register', [SeminarController::class, 'register']);
        Route::get('/publications/{publication}/download', [PublicationController::class, 'download']);
    });
});
```

### コントローラー例
```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Seminar;
use Illuminate\Http\Request;

class SeminarController extends Controller
{
    public function index(Request $request)
    {
        $seminars = Seminar::query()
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->date_from, function ($query, $date) {
                return $query->where('date', '>=', $date);
            })
            ->paginate($request->per_page ?? 10);

        return response()->json([
            'success' => true,
            'data' => [
                'seminars' => $seminars->items(),
                'pagination' => [
                    'current_page' => $seminars->currentPage(),
                    'total_pages' => $seminars->lastPage(),
                    'total_items' => $seminars->total(),
                    'per_page' => $seminars->perPage(),
                ]
            ]
        ]);
    }
}
```
