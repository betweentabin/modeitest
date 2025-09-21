<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NoticeCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class NoticeCategoryController extends Controller
{
    private function makeUniqueSlug(string $base, ?int $ignoreId = null): string
    {
        $base = trim($base);
        if ($base === '') {
            $base = 'cat';
        }
        $slug = $base;
        $i = 2;
        while (
            NoticeCategory::where('slug', $slug)
                ->when($ignoreId, function ($q) use ($ignoreId) { return $q->where('id', '<>', $ignoreId); })
                ->exists()
        ) {
            $slug = $base . '-' . $i;
            $i++;
        }
        return $slug;
    }
    public function index()
    {
        return response()->json(['success'=>true, 'data'=> NoticeCategory::ordered()->get()]);
    }
    public function show($id)
    {
        return response()->json(['success'=>true, 'data'=> NoticeCategory::findOrFail($id)]);
    }
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:notice_categories,slug',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);
        if ($v->fails()) return response()->json(['success'=>false,'errors'=>$v->errors()], 422);
        $data = $request->only(['name','slug','sort_order','is_active']);
        // Robust slug generation: handle multibyte (e.g., Japanese) names and ensure uniqueness
        $base = isset($data['slug']) && trim((string)$data['slug']) !== ''
            ? Str::slug($data['slug'])
            : Str::slug($data['name'] ?? '');
        if (!$base) { $base = 'cat'; }
        $data['slug'] = $this->makeUniqueSlug($base);
        $item = NoticeCategory::create($data);
        return response()->json(['success'=>true,'data'=>$item], 201);
    }
    public function update(Request $request, $id)
    {
        $item = NoticeCategory::findOrFail($id);
        $v = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:notice_categories,slug,' . $item->id,
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);
        if ($v->fails()) return response()->json(['success'=>false,'errors'=>$v->errors()], 422);
        $data = $request->only(['name','slug','sort_order','is_active']);
        // If slug is provided (even empty), or if name changes without slug, regenerate robustly
        if (array_key_exists('slug', $data)) {
            $base = trim((string)($data['slug'] ?? ''));
            if ($base === '') { $base = Str::slug($data['name'] ?? $item->name); }
            if (!$base) { $base = 'cat'; }
            $data['slug'] = $this->makeUniqueSlug($base, $item->id);
        } elseif (isset($data['name'])) {
            $base = Str::slug($data['name']);
            if (!$base) { $base = 'cat'; }
            $data['slug'] = $this->makeUniqueSlug($base, $item->id);
        }
        $item->update($data);
        return response()->json(['success'=>true,'data'=>$item]);
    }
    public function destroy($id)
    {
        $item = NoticeCategory::findOrFail($id);
        $item->delete();
        return response()->json(['success'=>true]);
    }
}
