<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EconomicStatisticsController;
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

Route::prefix('economic-statistics')->group(function () {
    Route::get('/categories', [EconomicStatisticsController::class, 'categories']);
    Route::get('/latest', [EconomicStatisticsController::class, 'latest']);
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/', [EconomicStatisticsController::class, 'index'])->middleware('feature:economic_statistics_basic');
        Route::get('/{id}', [EconomicStatisticsController::class, 'show'])->middleware('feature:economic_statistics_basic');
    });
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
        
        Route::prefix('seminars')->group(function () {
            Route::get('/', [SeminarController::class, 'index']);
            Route::post('/', [SeminarController::class, 'store']);
            Route::get('/{id}', [SeminarController::class, 'show']);
            Route::put('/{id}', [SeminarController::class, 'update']);
            Route::delete('/{id}', [SeminarController::class, 'destroy']);
        });
        
        // 管理者用ニュースAPI
        Route::prefix('news-v2')->group(function () {
            Route::get('/', [NewsV2Controller::class, 'index']);
            Route::post('/', [NewsV2Controller::class, 'store']);
            Route::get('/{id}', [NewsV2Controller::class, 'show']);
            Route::put('/{id}', [NewsV2Controller::class, 'update']);
            Route::delete('/{id}', [NewsV2Controller::class, 'destroy']);
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
