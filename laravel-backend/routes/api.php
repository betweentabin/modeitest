<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EconomicStatisticsController;
use App\Http\Controllers\Api\EconomicReportsController;
use App\Http\Controllers\Admin\EconomicReportManagementController;
use App\Http\Controllers\Api\FinancialReportsController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\ServicesController;
use App\Http\Controllers\Api\InquiriesController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdminAuthController;
use App\Http\Controllers\Api\PageContentController;
use App\Http\Controllers\Api\PublicationsController;
use App\Http\Controllers\Api\SeminarController;
use App\Http\Controllers\Api\NewsV2Controller;
use App\Http\Controllers\Api\PublicationController;
use App\Http\Controllers\Api\InquiryController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\NoticeController;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\MemberAccessController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// デバッグ用シンプルエンドポイント
Route::get('/test', function () {
    return response()->json([
        'message' => 'API is working!',
        'timestamp' => now(),
        'routes_loaded' => true
    ]);
});

Route::get('/debug-routes', function () {
    $routes = [];
    foreach (\Illuminate\Support\Facades\Route::getRoutes() as $route) {
        if (str_starts_with($route->uri(), 'api/')) {
            $routes[] = [
                'method' => implode('|', $route->methods()),
                'uri' => $route->uri(),
                'name' => $route->getName(),
            ];
        }
    }
    return response()->json(['api_routes' => $routes]);
});

// ヘルスチェックエンドポイント
Route::get('/health', function () {
    return response()->json([
        'status' => 'healthy',
        'timestamp' => now(),
        'service' => 'chikugin-api'
    ]);
});

// 認証エンドポイント
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// 後方互換性のための旧エンドポイント（非推奨）
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // auth prefix内のログアウト
    Route::post('/auth/logout', [AuthController::class, 'logout']);
});

// 会員認証API（Member用）
Route::prefix('member-auth')->group(function () {
    Route::post('/register', [App\Http\Controllers\Api\MemberAuthController::class, 'register']);
    Route::post('/login', [App\Http\Controllers\Api\MemberAuthController::class, 'login']);
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [App\Http\Controllers\Api\MemberAuthController::class, 'me']);
        Route::post('/logout', [App\Http\Controllers\Api\MemberAuthController::class, 'logout']);
    });
});

Route::prefix('economic-statistics')->group(function () {
    Route::get('/categories', [EconomicStatisticsController::class, 'categories']);
    Route::get('/latest', [EconomicStatisticsController::class, 'latest']);
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/', [EconomicStatisticsController::class, 'index'])->middleware('feature:economic_statistics_basic');
        Route::get('/{id}', [EconomicStatisticsController::class, 'show'])->middleware('feature:economic_statistics_basic');
    });
});

// 経済統計レポート関連のルート（パブリック）
Route::prefix('economic-reports')->name('economic-reports.')->group(function () {
    Route::get('/', [EconomicReportsController::class, 'index'])->name('index');
    Route::get('/featured', [EconomicReportsController::class, 'featured'])->name('featured');
    Route::get('/years', [EconomicReportsController::class, 'availableYears'])->name('years');
    Route::get('/categories', [EconomicReportsController::class, 'categories'])->name('categories');
    Route::get('/{id}', [EconomicReportsController::class, 'show'])->name('show');
    Route::post('/{id}/download', [EconomicReportsController::class, 'download'])->name('download');
});

Route::prefix('financial-reports')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/', [FinancialReportsController::class, 'index'])->middleware('membership:standard,premium');
        Route::get('/companies', [FinancialReportsController::class, 'companies'])->middleware('membership:standard,premium');
        Route::get('/latest', [FinancialReportsController::class, 'latest'])->middleware('membership:standard,premium');
        Route::get('/company/{companyName}', [FinancialReportsController::class, 'byCompany'])->middleware('membership:premium');
        Route::get('/{id}', [FinancialReportsController::class, 'show'])->middleware('membership:standard,premium');
    });
});

Route::prefix('news')->group(function () {
    Route::get('/', [NewsController::class, 'index']);
    Route::get('/categories', [NewsController::class, 'categories']);
    Route::get('/featured', [NewsController::class, 'featured']);
    Route::get('/popular', [NewsController::class, 'popular']);
    Route::get('/{slug}', [NewsController::class, 'show']);
    Route::get('/{slug}/related', [NewsController::class, 'related']);
});

// お知らせ関連API（パブリック）
Route::prefix('notices')->group(function () {
    Route::get('/', [NoticeController::class, 'index']);
    Route::get('/categories', [NoticeController::class, 'categories']);
    Route::get('/{id}', [NoticeController::class, 'show']);
});

Route::prefix('services')->group(function () {
    Route::get('/', [ServicesController::class, 'index']);
    Route::get('/featured', [ServicesController::class, 'featured']);
    Route::get('/{slug}', [ServicesController::class, 'show']);
});

Route::post('/inquiries', [InquiriesController::class, 'store']);

// セミナー関連API
Route::prefix('seminars')->group(function () {
    Route::get('/', [SeminarController::class, 'index']);
    Route::get('/{id}', [SeminarController::class, 'show']);
    Route::post('/{id}/register', [SeminarController::class, 'register']);
});

Route::prefix('admin')->group(function () {
    Route::post('/login', [AdminAuthController::class, 'login']);
    
    // テスト用: 認証なしエンドポイント
    Route::get('/test', function() {
        return response()->json([
            'status' => 'success',
            'message' => 'Admin API is working!',
            'timestamp' => now()
        ]);
    });
    
    Route::middleware(['auth:sanctum', 'is.admin'])->group(function () {
        Route::get('/me', [AdminAuthController::class, 'me']);
        Route::post('/logout', [AdminAuthController::class, 'logout']);
        
        Route::prefix('pages')->group(function () {
            Route::get('/', [PageContentController::class, 'index']);
            Route::post('/', [PageContentController::class, 'store']);
            Route::get('/{pageKey}', [PageContentController::class, 'show']);
            Route::put('/{pageKey}', [PageContentController::class, 'update']);
            Route::delete('/{pageKey}', [PageContentController::class, 'destroy']);
            Route::post('/{pageKey}/upload-image', [PageContentController::class, 'uploadImage']);
            Route::delete('/{pageKey}/delete-image', [PageContentController::class, 'deleteImage']);
        });
        
        Route::prefix('publications')->group(function () {
            Route::get('/', [PublicationsController::class, 'index']);
            Route::post('/', [PublicationsController::class, 'store']);
            Route::get('/{id}', [PublicationsController::class, 'show']);
            Route::put('/{id}', [PublicationsController::class, 'update']);
            Route::delete('/{id}', [PublicationsController::class, 'destroy']);
        });

        // 経済統計レポート管理関連のルート
        Route::prefix('economic-reports')->group(function () {
            Route::get('/', [EconomicReportManagementController::class, 'index']);
            Route::get('/{id}', [EconomicReportManagementController::class, 'show']);
            Route::post('/', [EconomicReportManagementController::class, 'store']);
            Route::put('/{id}', [EconomicReportManagementController::class, 'update']);
            Route::delete('/{id}', [EconomicReportManagementController::class, 'destroy']);
            
            // 公開状態の変更
            Route::patch('/{id}/toggle-publish', [EconomicReportManagementController::class, 'togglePublishStatus']);
            Route::patch('/{id}/toggle-feature', [EconomicReportManagementController::class, 'toggleFeaturedStatus']);
            
            // 統計情報
            Route::get('/stats/overview', [EconomicReportManagementController::class, 'statistics']);
        });
        
        Route::prefix('seminars')->group(function () {
            Route::get('/', [SeminarController::class, 'index']);
            Route::post('/', [SeminarController::class, 'store']);
            Route::get('/{id}', [SeminarController::class, 'show']);
            Route::put('/{id}', [SeminarController::class, 'update']);
            Route::delete('/{id}', [SeminarController::class, 'destroy']);

            // 申込承認（案B）
            Route::get('/{id}/registrations', [App\Http\Controllers\Admin\SeminarRegistrationApprovalController::class, 'index']);
            Route::post('/{id}/registrations/bulk-approve', [App\Http\Controllers\Admin\SeminarRegistrationApprovalController::class, 'bulkApprove']);
            Route::post('/{id}/registrations/{regId}/approve', [App\Http\Controllers\Admin\SeminarRegistrationApprovalController::class, 'approve']);
            Route::post('/{id}/registrations/{regId}/reject', [App\Http\Controllers\Admin\SeminarRegistrationApprovalController::class, 'reject']);
        });
        
        // 管理者用ニュースAPI
        Route::prefix('news-v2')->group(function () {
            Route::get('/', [NewsV2Controller::class, 'index']);
            Route::post('/', [NewsV2Controller::class, 'store']);
            Route::get('/{id}', [NewsV2Controller::class, 'show']);
            Route::put('/{id}', [NewsV2Controller::class, 'update']);
            Route::delete('/{id}', [NewsV2Controller::class, 'destroy']);
        });

        // メールグループ管理
        Route::prefix('mail-groups')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\MailGroupController::class, 'index']);
            Route::post('/', [App\Http\Controllers\Admin\MailGroupController::class, 'store']);
            Route::get('/{id}', [App\Http\Controllers\Admin\MailGroupController::class, 'show']);
            Route::put('/{id}', [App\Http\Controllers\Admin\MailGroupController::class, 'update']);
            Route::delete('/{id}', [App\Http\Controllers\Admin\MailGroupController::class, 'destroy']);
            Route::post('/{id}/members', [App\Http\Controllers\Admin\MailGroupController::class, 'members']);
        });

        // メールキャンペーン管理
        Route::prefix('emails')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\EmailCampaignController::class, 'index']);
            Route::post('/', [App\Http\Controllers\Admin\EmailCampaignController::class, 'store']);
            Route::get('/{id}', [App\Http\Controllers\Admin\EmailCampaignController::class, 'show']);
            Route::post('/{id}/preview', [App\Http\Controllers\Admin\EmailCampaignController::class, 'preview']);
            Route::post('/{id}/schedule', [App\Http\Controllers\Admin\EmailCampaignController::class, 'schedule']);
            Route::post('/{id}/send-now', [App\Http\Controllers\Admin\EmailCampaignController::class, 'sendNow']);
            Route::post('/{id}/resend-failed', [App\Http\Controllers\Admin\EmailCampaignController::class, 'resendFailed']);
            Route::post('/{id}/recipients/{recipientId}/resend', [App\Http\Controllers\Admin\EmailCampaignController::class, 'resendRecipient']);
        });
        
        // 管理者用刊行物API
        Route::prefix('publications-v2')->group(function () {
            Route::get('/', [PublicationController::class, 'index']);
            Route::post('/', [PublicationController::class, 'store']);
            Route::get('/{id}', [PublicationController::class, 'show']);
            Route::put('/{id}', [PublicationController::class, 'update']);
            Route::delete('/{id}', [PublicationController::class, 'destroy']);
        });
        
        // 管理者用お問い合わせAPI
        Route::prefix('inquiries-v2')->group(function () {
            Route::get('/', [InquiryController::class, 'index']);
            Route::get('/{id}', [InquiryController::class, 'show']);
            Route::put('/{id}', [InquiryController::class, 'update']);
            Route::delete('/{id}', [InquiryController::class, 'destroy']);
            Route::post('/{id}/respond', [InquiryController::class, 'markAsResponded']);
        });
        
        // 会員管理API
        Route::prefix('members')->group(function () {
            Route::get('/', [MemberController::class, 'index']);
            Route::post('/', [MemberController::class, 'store']);
            Route::get('/stats', [MemberController::class, 'stats']);
            Route::get('/{id}', [MemberController::class, 'show']);
            Route::put('/{id}', [MemberController::class, 'update']);
            Route::delete('/{id}', [MemberController::class, 'destroy']);
            Route::patch('/{id}/status', [MemberController::class, 'updateStatus']);
            Route::patch('/{id}/membership', [MemberController::class, 'updateMembership']);
            Route::patch('/{id}/extend', [MemberController::class, 'extendMembership']);
        });
        
        // お知らせ管理API
        Route::prefix('notices')->group(function () {
            Route::get('/', [NoticeController::class, 'index']);
            Route::post('/', [NoticeController::class, 'store']);
            Route::get('/stats', [NoticeController::class, 'stats']);
            Route::get('/categories', [NoticeController::class, 'categories']);
            Route::get('/{id}', [NoticeController::class, 'show']);
            Route::put('/{id}', [NoticeController::class, 'update']);
            Route::delete('/{id}', [NoticeController::class, 'destroy']);
            Route::patch('/{id}/status', [NoticeController::class, 'updateStatus']);
        });
        
        // メディア管理API
        Route::prefix('media')->group(function () {
            Route::get('/', [MediaController::class, 'index']);
            Route::post('/upload', [MediaController::class, 'upload']);
            Route::delete('/delete', [MediaController::class, 'destroy']);
            Route::put('/rename', [MediaController::class, 'update']);
            Route::get('/directories', [MediaController::class, 'directories']);
            Route::post('/directories', [MediaController::class, 'createDirectory']);
            Route::get('/stats', [MediaController::class, 'stats']);
        });
    });
});

Route::get('/pages/{pageKey}', [PageContentController::class, 'show']);

// 公開ページコンテンツAPI（認証不要）
Route::prefix('public')->group(function () {
    Route::get('/pages', [PageContentController::class, 'index']);
    Route::get('/pages/{pageKey}', [PageContentController::class, 'show']);
});

// 新しいニュースAPI（v2）
Route::prefix('news-v2')->group(function () {
    Route::get('/', [NewsV2Controller::class, 'index']);
    Route::get('/{id}', [NewsV2Controller::class, 'show']);
});

// 新しい刊行物API
Route::prefix('publications-v2')->group(function () {
    Route::get('/', [PublicationController::class, 'index']);
    Route::get('/{id}', [PublicationController::class, 'show']);
    Route::get('/{id}/download', [PublicationController::class, 'download']);
});

// お問い合わせAPI
Route::prefix('inquiries-v2')->group(function () {
    Route::post('/', [InquiryController::class, 'store']); // 公開：お問い合わせ送信
});

// 会員アクセス権限API
Route::prefix('member')->middleware('auth:sanctum')->group(function () {
    Route::get('/can-access/{type}/{id}', [MemberAccessController::class, 'canAccess']);
    Route::post('/log-access', [MemberAccessController::class, 'logAccess']);
    Route::get('/upgrade-history', [MemberAccessController::class, 'getUpgradeHistory']);
    
    // プロフィール管理
    Route::get('/my-profile', [App\Http\Controllers\Api\MemberProfileController::class, 'show']);
    Route::put('/my-profile', [App\Http\Controllers\Api\MemberProfileController::class, 'update']);
    Route::put('/my-profile/password', [App\Http\Controllers\Api\MemberProfileController::class, 'updatePassword']);
    Route::delete('/my-profile', [App\Http\Controllers\Api\MemberProfileController::class, 'deleteAccount']);
    
    // お気に入り機能
    Route::get('/favorites', [App\Http\Controllers\Api\MemberFavoritesController::class, 'index']);
    Route::post('/favorites/{favorite_member_id}', [App\Http\Controllers\Api\MemberFavoritesController::class, 'store']);
    Route::delete('/favorites/{favorite_member_id}', [App\Http\Controllers\Api\MemberFavoritesController::class, 'destroy']);
    Route::get('/favorites/{favorite_member_id}/check', [App\Http\Controllers\Api\MemberFavoritesController::class, 'check']);
    
    // 会員名簿（standard以上）
    Route::get('/directory', [App\Http\Controllers\Api\MemberDirectoryController::class, 'index']);
    Route::get('/directory/{id}', [App\Http\Controllers\Api\MemberDirectoryController::class, 'show']);
    Route::get('/directory/export/csv', [App\Http\Controllers\Api\MemberDirectoryController::class, 'exportCsv']);
});

Route::prefix('publications')->group(function () {
    Route::get('/', [PublicationsController::class, 'index']);
    Route::get('/featured', [PublicationsController::class, 'featured']);
    Route::get('/latest', [PublicationsController::class, 'latest']);
    Route::get('/{id}', [PublicationsController::class, 'show']);
    Route::get('/{id}/download', [PublicationsController::class, 'download'])->middleware('auth:sanctum');
});

// デバッグ用: Admin テーブル確認エンドポイント
Route::get('/debug/admins', function() {
    try {
        $admins = \App\Models\Admin::select('id', 'username', 'email', 'full_name', 'role', 'is_active')->get();
        return response()->json([
            'status' => 'success',
            'admin_count' => $admins->count(),
            'admins' => $admins,
            'timestamp' => now()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'timestamp' => now()
        ]);
    }
});

// デバッグ用: 管理者パスワード修正エンドポイント
Route::post('/debug/fix-admin-password', function() {
    try {
        $admin = \App\Models\Admin::where('email', 'admin@chikugin-cri.co.jp')->first();
        
        if (!$admin) {
            return response()->json(['status' => 'error', 'message' => 'Admin not found']);
        }
        
        // パスワードを直接更新（Admin モデルのミューテーターを回避）
        $admin->forceFill(['password' => \Illuminate\Support\Facades\Hash::make('admin123')])->save();
        
        // 検証
        $passwordCheck = \Illuminate\Support\Facades\Hash::check('admin123', $admin->fresh()->password);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Admin password updated successfully',
            'password_check' => $passwordCheck,
            'admin_email' => $admin->email
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'timestamp' => now()
        ]);
    }
});

// デバッグ用: 管理者自動ログイン
Route::post('/debug/admin-login', [App\Http\Controllers\Api\AdminAuthController::class, 'debugLogin']);

// デバッグ用: テーブル構造確認
Route::get('/debug/tables', function() {
    try {
        $tables = [];
        
        // Newsテーブルの存在確認と構造
        if (Schema::hasTable('news')) {
            $columns = Schema::getColumnListing('news');
            $count = \App\Models\News::count();
            $tables['news'] = [
                'exists' => true,
                'columns' => $columns,
                'count' => $count,
                'sample' => \App\Models\News::first()
            ];
        } else {
            $tables['news'] = ['exists' => false];
        }
        
        // NewsArticlesテーブルの存在確認
        if (Schema::hasTable('news_articles')) {
            $columns = Schema::getColumnListing('news_articles');
            $count = \App\Models\NewsArticle::count();
            $tables['news_articles'] = [
                'exists' => true,
                'columns' => $columns,
                'count' => $count
            ];
        } else {
            $tables['news_articles'] = ['exists' => false];
        }
        
        // Publicationsテーブルの存在確認
        if (Schema::hasTable('publications')) {
            $columns = Schema::getColumnListing('publications');
            $count = \App\Models\Publication::count();
            $tables['publications'] = [
                'exists' => true,
                'columns' => $columns,
                'count' => $count,
                'sample' => \App\Models\Publication::first()
            ];
        } else {
            $tables['publications'] = ['exists' => false];
        }
        
        return response()->json([
            'status' => 'success',
            'tables' => $tables,
            'timestamp' => now()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'timestamp' => now()
        ]);
    }
});

// デバッグ用: AdminSeederを再実行するエンドポイント
Route::post('/debug/run-admin-seeder', function() {
    try {
        Artisan::call('db:seed', ['--class' => 'AdminSeeder', '--force' => true]);
        
        return response()->json([
            'status' => 'success',
            'message' => 'AdminSeeder executed successfully.',
            'output' => Artisan::output(),
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ], 500);
    }
});

// デバッグ用: ログインテストエンドポイント
Route::post('/debug/login-test', function(Request $request) {
    try {
        $admin = \App\Models\Admin::where('email', 'admin@chikugin-cri.co.jp')->first();
        
        if (!$admin) {
            return response()->json(['status' => 'error', 'message' => 'Admin not found']);
        }
        
        $passwordCheck = \Illuminate\Support\Facades\Hash::check('admin123', $admin->password);
        
        return response()->json([
            'status' => 'success',
            'admin_found' => true,
            'password_check' => $passwordCheck,
            'admin_email' => $admin->email,
            'is_active' => $admin->is_active
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile()
        ]);
    }
});

// デバッグ用: データベース接続確認エンドポイント
Route::get('/debug/database', function() {
    try {
        $members = DB::table('members')->select('id', 'email', 'membership_type')->take(3)->get();
        $publications = DB::table('publications')->select('id', 'title', 'membership_level')->take(3)->get();
        $seminars = DB::table('seminars')->select('id', 'title', 'status', 'membership_requirement')->take(5)->get();
        
        return response()->json([
            'status' => 'success',
            'database_connection' => 'OK',
            'sample_data' => [
                'members' => $members,
                'publications' => $publications,
                'seminars' => $seminars
            ],
            'timestamp' => now()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'timestamp' => now()
        ], 500);
    }
});

// デバッグ用: セミナーステータス詳細確認
Route::get('/debug/seminars', function() {
    try {
        $allSeminars = DB::table('seminars')
            ->select('id', 'title', 'status', 'date', 'created_at')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
            
        $statusCounts = DB::table('seminars')
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();
        
        return response()->json([
            'status' => 'success',
            'recent_seminars' => $allSeminars,
            'status_counts' => $statusCounts,
            'published_scope_filter' => "status IN ('scheduled', 'ongoing')",
            'timestamp' => now()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'timestamp' => now()
        ], 500);
    }
});
