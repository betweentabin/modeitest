<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PageContentController extends Controller
{
    public function index(): JsonResponse
    {
        $pages = PageContent::all();
        return response()->json($pages);
    }

    public function show(string $pageKey): JsonResponse
    {
        $page = PageContent::where('page_key', $pageKey)
            ->where('is_published', true)
            ->first();

        if (!$page) {
            return response()->json(['message' => 'Page not found'], 404);
        }

        return response()->json($page);
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
}