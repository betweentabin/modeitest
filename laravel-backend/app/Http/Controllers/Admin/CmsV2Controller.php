<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsV2Media;
use App\Models\CmsV2Page;
use App\Models\CmsV2Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class CmsV2Controller extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('manage-content');
        $q = CmsV2Page::query();
        if ($request->filled('search')) {
            $s = $request->get('search');
            $q->where(function ($x) use ($s) {
                $x->where('slug','like',"%{$s}%")->orWhere('title','like',"%{$s}%");
            });
        }
        $pages = $q->orderBy('updated_at','desc')->paginate($request->get('per_page', 20));
        return response()->json(['success' => true, 'data' => $pages]);
    }

    public function show($id)
    {
        Gate::authorize('manage-content');
        $page = CmsV2Page::with('sections')->findOrFail($id);
        return response()->json(['success' => true, 'data' => $page]);
    }

    public function store(Request $request)
    {
        Gate::authorize('manage-content');
        $data = $request->validate([
            'slug' => 'required|string|max:255|unique:cms_v2_pages,slug',
            'title' => 'required|string|max:255',
            'meta_json' => 'array',
        ]);
        $id = method_exists(new CmsV2Page, 'getKeyType') && method_exists(\Schema::class, 'hasTable') ? (string) Str::ulid() : (string) Str::uuid();
        $page = CmsV2Page::create([
            'id' => $id,
            'slug' => $data['slug'],
            'title' => $data['title'],
            'meta_json' => $data['meta_json'] ?? [],
        ]);
        return response()->json(['success' => true, 'data' => $page], 201);
    }

    public function update(Request $request, $id)
    {
        Gate::authorize('manage-content');
        $page = CmsV2Page::findOrFail($id);
        $data = $request->validate([
            'title' => 'sometimes|string|max:255',
            'meta_json' => 'sometimes|array',
        ]);
        $page->update($data);
        return response()->json(['success' => true, 'data' => $page]);
    }

    public function upsertSection(Request $request, $id, $sid)
    {
        Gate::authorize('manage-content');
        $page = CmsV2Page::findOrFail($id);
        $data = $request->validate([
            'sort' => 'required|integer',
            'component_type' => 'required|string|max:255',
            'props_json' => 'array',
            'status' => 'in:draft,published',
        ]);
        $section = CmsV2Section::find($sid);
        if (!$section) {
            $sidVal = (string) Str::ulid();
            $section = CmsV2Section::create([
                'id' => $sidVal,
                'page_id' => $page->id,
                'sort' => $data['sort'],
                'component_type' => $data['component_type'],
                'props_json' => $data['props_json'] ?? [],
                'status' => $data['status'] ?? 'draft',
            ]);
        } else {
            $section->update([
                'sort' => $data['sort'],
                'component_type' => $data['component_type'],
                'props_json' => $data['props_json'] ?? [],
                'status' => $data['status'] ?? $section->status,
            ]);
        }
        return response()->json(['success' => true, 'data' => $section]);
    }

    public function publish($id)
    {
        Gate::authorize('manage-content');
        $page = CmsV2Page::with('sections')->findOrFail($id);
        $snapshot = [
            'slug' => $page->slug,
            'title' => $page->title,
            'meta' => $page->meta_json ?? [],
            'sections' => $page->sections->map(function ($s) {
                return [
                    'id' => $s->id,
                    'sort' => $s->sort,
                    'component_type' => $s->component_type,
                    'props' => $s->props_json ?? [],
                ];
            })->values()->all(),
        ];
        $page->update(['published_snapshot_json' => $snapshot]);
        return response()->json(['success' => true, 'data' => $page]);
    }

    public function uploadMedia(Request $request)
    {
        Gate::authorize('manage-content');
        $request->validate(['file' => 'required|file|max:10240']);
        $file = $request->file('file');
        $data = file_get_contents($file->getRealPath());
        $media = CmsV2Media::create([
            'id' => (string) Str::ulid(),
            'filename' => $file->getClientOriginalName(),
            'mime' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'data' => $data,
        ]);
        return response()->json(['success' => true, 'data' => [
            'id' => $media->id,
            'filename' => $media->filename,
            'mime' => $media->mime,
            'size' => $media->size,
        ]], 201);
    }
}
