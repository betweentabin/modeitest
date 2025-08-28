<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NewsArticle;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class NoticeController extends Controller
{
    /**
     * お知らせ一覧を取得
     */
    public function index(Request $request): JsonResponse
    {
        $query = NewsArticle::where('type', 'notice');

        // 検索フィルター
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('content', 'LIKE', "%{$search}%")
                  ->orWhere('excerpt', 'LIKE', "%{$search}%");
            });
        }

        // ステータスフィルター
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // カテゴリフィルター
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        // ソート
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        // ページネーション
        $perPage = $request->get('per_page', 15);
        $notices = $query->paginate($perPage);

        return response()->json($notices);
    }

    /**
     * お知らせ詳細を取得
     */
    public function show($id): JsonResponse
    {
        $notice = NewsArticle::where('type', 'notice')->findOrFail($id);
        return response()->json($notice);
    }

    /**
     * 新規お知らせを作成
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'category' => 'required|string|max:100',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
            'featured' => 'boolean',
            'priority' => 'integer|min:0|max:10',
            'tags' => 'nullable|string',
            'featured_image' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'バリデーションエラー',
                'errors' => $validator->errors()
            ], 422);
        }

        $notice = NewsArticle::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'excerpt' => $request->excerpt,
            'category' => $request->category,
            'status' => $request->status,
            'type' => 'notice',
            'published_at' => $request->published_at ?? ($request->status === 'published' ? now() : null),
            'featured' => $request->featured ?? false,
            'priority' => $request->priority ?? 0,
            'tags' => $request->tags,
            'featured_image' => $request->featured_image,
            'author_id' => auth()->id(),
        ]);

        return response()->json([
            'message' => 'お知らせを作成しました',
            'notice' => $notice
        ], 201);
    }

    /**
     * お知らせを更新
     */
    public function update(Request $request, $id): JsonResponse
    {
        $notice = NewsArticle::where('type', 'notice')->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'category' => 'required|string|max:100',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
            'featured' => 'boolean',
            'priority' => 'integer|min:0|max:10',
            'tags' => 'nullable|string',
            'featured_image' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'バリデーションエラー',
                'errors' => $validator->errors()
            ], 422);
        }

        $updateData = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'excerpt' => $request->excerpt,
            'category' => $request->category,
            'status' => $request->status,
            'published_at' => $request->published_at,
            'featured' => $request->featured ?? false,
            'priority' => $request->priority ?? 0,
            'tags' => $request->tags,
            'featured_image' => $request->featured_image,
        ];

        // 公開状態に変更された場合は公開日時を設定
        if ($request->status === 'published' && !$notice->published_at) {
            $updateData['published_at'] = now();
        }

        $notice->update($updateData);

        return response()->json([
            'message' => 'お知らせを更新しました',
            'notice' => $notice
        ]);
    }

    /**
     * お知らせを削除
     */
    public function destroy($id): JsonResponse
    {
        $notice = NewsArticle::where('type', 'notice')->findOrFail($id);
        $notice->delete();

        return response()->json([
            'message' => 'お知らせを削除しました'
        ]);
    }

    /**
     * お知らせ統計を取得
     */
    public function stats(): JsonResponse
    {
        $stats = [
            'total_notices' => NewsArticle::where('type', 'notice')->count(),
            'published_notices' => NewsArticle::where('type', 'notice')->where('status', 'published')->count(),
            'draft_notices' => NewsArticle::where('type', 'notice')->where('status', 'draft')->count(),
            'featured_notices' => NewsArticle::where('type', 'notice')->where('featured', true)->count(),
            'recent_notices' => NewsArticle::where('type', 'notice')->where('created_at', '>=', now()->subDays(30))->count(),
        ];

        return response()->json($stats);
    }

    /**
     * お知らせステータスを更新
     */
    public function updateStatus(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:draft,published,archived',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'バリデーションエラー',
                'errors' => $validator->errors()
            ], 422);
        }

        $notice = NewsArticle::where('type', 'notice')->findOrFail($id);
        
        $updateData = ['status' => $request->status];
        
        // 公開状態に変更された場合は公開日時を設定
        if ($request->status === 'published' && !$notice->published_at) {
            $updateData['published_at'] = now();
        }
        
        $notice->update($updateData);

        return response()->json([
            'message' => 'お知らせステータスを更新しました',
            'notice' => $notice
        ]);
    }

    /**
     * カテゴリ一覧を取得
     */
    public function categories(): JsonResponse
    {
        $categories = NewsArticle::where('type', 'notice')
            ->distinct()
            ->pluck('category')
            ->filter()
            ->values();

        return response()->json($categories);
    }
}
