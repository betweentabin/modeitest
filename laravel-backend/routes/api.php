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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
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
    
    Route::middleware(['auth:sanctum', 'is.admin'])->group(function () {
        Route::get('/me', [AdminAuthController::class, 'me']);
        Route::post('/logout', [AdminAuthController::class, 'logout']);
        
        Route::prefix('pages')->group(function () {
            Route::get('/', [PageContentController::class, 'index']);
            Route::post('/', [PageContentController::class, 'store']);
            Route::get('/{pageKey}', [PageContentController::class, 'show']);
            Route::put('/{pageKey}', [PageContentController::class, 'update']);
            Route::delete('/{pageKey}', [PageContentController::class, 'destroy']);
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
    });
});

Route::get('/pages/{pageKey}', [PageContentController::class, 'show']);

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

Route::prefix('publications')->group(function () {
    Route::get('/', [PublicationsController::class, 'index']);
    Route::get('/featured', [PublicationsController::class, 'featured']);
    Route::get('/latest', [PublicationsController::class, 'latest']);
    Route::get('/{id}', [PublicationsController::class, 'show']);
    Route::get('/{id}/download', [PublicationsController::class, 'download'])->middleware('auth:sanctum');
});
