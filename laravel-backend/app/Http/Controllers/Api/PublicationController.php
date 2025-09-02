<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PublicationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            // 管理者（/api/admin/* 経由）または認証済み管理ユーザーの場合は全件を対象
            $isAdminContext = str_starts_with($request->path(), 'api/admin/')
                || ($request->user() && method_exists($request->user(), 'isAdmin') && $request->user()->isAdmin());

            $query = $isAdminContext
                ? Publication::query()->orderBy('publication_date', 'desc')
                : Publication::where('is_published', true)->orderBy('publication_date', 'desc');

            // フィルタリング（空文字は無視）
            if ($request->filled('category')) {
                $query->where('category', $request->category);
            }

            if ($request->filled('type')) {
                $query->where('type', $request->type);
            }

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('author', 'like', "%{$search}%")
                      ->orWhere('tags', 'like', "%{$search}%");
                });
            }

            // 一般公開APIでは会員限定を除外。管理者APIは常に全件。
            if (!$isAdminContext) {
                if (!$request->boolean('members_only_included')) {
                    $query->where('members_only', false);
                }
            }

            // ページネーション
            $perPage = $request->get('per_page', 12);
            $publications = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => [
                    'publications' => $publications->items(),
                    'pagination' => [
                        'current_page' => $publications->currentPage(),
                        'total_pages' => $publications->lastPage(),
                        'total_items' => $publications->total(),
                        'per_page' => $publications->perPage()
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '刊行物の取得に失敗しました。',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $publication = Publication::where('is_published', true)
                ->findOrFail($id);

            // ビュー数をインクリメント
            $publication->increment('view_count');

            return response()->json([
                'success' => true,
                'data' => [
                    'publication' => $publication,
                    'formatted_date' => $publication->publication_date->format('Y.m.d'),
                    'formatted_price' => $publication->price ? '¥' . number_format($publication->price) : '無料',
                    'can_download' => $publication->is_downloadable && $publication->file_url
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '刊行物が見つかりません。',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function download($id): JsonResponse
    {
        try {
            $publication = Publication::where('is_published', true)
                ->where('is_downloadable', true)
                ->findOrFail($id);

            if (!$publication->file_url) {
                return response()->json([
                    'success' => false,
                    'message' => 'ダウンロードファイルが見つかりません。'
                ], 404);
            }

            // ダウンロード数をインクリメント
            $publication->increment('download_count');

            return response()->json([
                'success' => true,
                'data' => [
                    'download_url' => $publication->file_url,
                    'filename' => $publication->title . '.pdf'
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'ダウンロードに失敗しました。',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'category' => 'required|string',
                'type' => 'required|string',
                'publication_date' => 'required|date',
                'issue_number' => 'nullable|string',
                'author' => 'nullable|string',
                'pages' => 'nullable|integer|min:1',
                'file_url' => 'nullable|string',
                'cover_image' => 'nullable|string',
                'price' => 'nullable|numeric|min:0',
                'tags' => 'nullable|string',
                'is_downloadable' => 'boolean',
                'members_only' => 'boolean'
            ]);

            $publication = Publication::create([
                ...$validatedData,
                'is_published' => true
            ]);

            return response()->json([
                'success' => true,
                'message' => '刊行物が作成されました。',
                'data' => ['publication' => $publication]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '刊行物の作成に失敗しました。',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $publication = Publication::findOrFail($id);

            $validatedData = $request->validate([
                'title' => 'sometimes|required|string|max:255',
                'description' => 'sometimes|required|string',
                'category' => 'sometimes|required|string',
                'type' => 'sometimes|required|string',
                'publication_date' => 'sometimes|required|date',
                'issue_number' => 'nullable|string',
                'author' => 'nullable|string',
                'pages' => 'nullable|integer|min:1',
                'file_url' => 'nullable|string',
                'cover_image' => 'nullable|string',
                'price' => 'nullable|numeric|min:0',
                'tags' => 'nullable|string',
                'is_published' => 'boolean',
                'is_downloadable' => 'boolean',
                'members_only' => 'boolean'
            ]);

            $publication->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => '刊行物が更新されました。',
                'data' => ['publication' => $publication]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '刊行物の更新に失敗しました。',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $publication = Publication::findOrFail($id);
            $publication->delete();

            return response()->json([
                'success' => true,
                'message' => '刊行物が削除されました。'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '刊行物の削除に失敗しました。',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
