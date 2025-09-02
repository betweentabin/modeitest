<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PageContentController extends Controller
{
    public function index(): JsonResponse
    {
        $pages = PageContent::all();
        return response()->json([
            'success' => true,
            'data' => [
                'pages' => $pages
            ]
        ]);
    }

    public function show(string $pageKey): JsonResponse
    {
        $page = PageContent::where('page_key', $pageKey)
            ->where('is_published', true)
            ->first();

        if (!$page) {
            return response()->json([
                'success' => false,
                'message' => 'Page not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'page' => $page
            ]
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'page_key' => 'required|string|unique:page_contents',
            'title' => 'required|string',
            'content' => 'required|array',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        $validated['updated_by'] = auth()->id();
        $page = PageContent::create($validated);

        return response()->json($page, 201);
    }

    public function update(Request $request, string $pageKey): JsonResponse
    {
        $page = PageContent::where('page_key', $pageKey)->first();

        if (!$page) {
            return response()->json(['message' => 'Page not found'], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string',
            'content' => 'sometimes|array',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        $validated['updated_by'] = auth()->id();
        $page->update($validated);

        return response()->json($page);
    }

    public function destroy(string $pageKey): JsonResponse
    {
        $page = PageContent::where('page_key', $pageKey)->first();

        if (!$page) {
            return response()->json(['message' => 'Page not found'], 404);
        }

        $page->delete();
        return response()->json(['message' => 'Page deleted successfully']);
    }

    public function uploadImage(Request $request, string $pageKey): JsonResponse
    {
        $page = PageContent::where('page_key', $pageKey)->first();

        if (!$page) {
            return response()->json(['message' => 'Page not found'], 404);
        }

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'type' => 'required|in:hero,content,gallery'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = Str::slug($pageKey) . '-' . $request->type . '-' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('pages/' . $pageKey, $fileName, 'public');

            // contentの中に画像情報を保存
            $content = $page->content ?? [];
            if (!isset($content['images'])) {
                $content['images'] = [];
            }
            
            $content['images'][$request->type] = [
                'url' => Storage::url($path),
                'path' => $path,
                'filename' => $fileName,
                'uploaded_at' => now()
            ];

            $page->update([
                'content' => $content,
                'updated_by' => auth()->id()
            ]);

            return response()->json([
                'message' => 'Image uploaded successfully',
                'image' => $content['images'][$request->type]
            ]);
        }

        return response()->json(['message' => 'No image file provided'], 400);
    }

    public function deleteImage(Request $request, string $pageKey): JsonResponse
    {
        $page = PageContent::where('page_key', $pageKey)->first();

        if (!$page) {
            return response()->json(['message' => 'Page not found'], 404);
        }

        $request->validate([
            'type' => 'required|in:hero,content,gallery'
        ]);

        $content = $page->content ?? [];
        
        if (isset($content['images'][$request->type])) {
            // ストレージから画像を削除
            if (isset($content['images'][$request->type]['path'])) {
                Storage::disk('public')->delete($content['images'][$request->type]['path']);
            }
            
            // contentから画像情報を削除
            unset($content['images'][$request->type]);
            
            $page->update([
                'content' => $content,
                'updated_by' => auth()->id()
            ]);

            return response()->json(['message' => 'Image deleted successfully']);
        }

        return response()->json(['message' => 'Image not found'], 404);
    }
}