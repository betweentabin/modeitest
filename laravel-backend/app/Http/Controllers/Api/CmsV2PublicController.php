<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CmsV2Page;

class CmsV2PublicController extends Controller
{
    public function showBySlug($slug)
    {
        $page = CmsV2Page::where('slug', $slug)->firstOrFail();
        $snapshot = $page->published_snapshot_json;
        return response()->json([
            'success' => true,
            'data' => $snapshot ?? [
                'slug' => $page->slug,
                'title' => $page->title,
                'meta' => $page->meta_json ?? [],
                'sections' => [],
            ]
        ]);
    }
}

