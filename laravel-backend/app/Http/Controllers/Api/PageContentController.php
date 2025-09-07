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
    public function mediaUsage(): JsonResponse
    {
        $pages = PageContent::all();
        $items = [];

        foreach ($pages as $page) {
            $content = $page->content;

            // 1) JSON images registry: content.images[<type>] = { url, ... } or string
            if (is_array($content) && isset($content['images']) && is_array($content['images'])) {
                foreach ($content['images'] as $key => $val) {
                    $url = null;
                    $path = null;
                    $filename = null;
                    if (is_string($val)) {
                        $url = $val;
                    } elseif (is_array($val)) {
                        $url = $val['url'] ?? null;
                        $path = $val['path'] ?? null;
                        $filename = $val['filename'] ?? null;
                    }
                    if ($url) {
                        $items[] = [
                            'page_key' => $page->page_key,
                            'model' => 'page_content',
                            'id' => $page->id,
                            'key' => (string)$key,
                            'url' => $url,
                            'path' => $path,
                            'filename' => $filename,
                            'source' => 'json',
                            'updated_at' => $page->updated_at,
                        ];
                    }
                }
            }

            // 2) HTML body: scan for <img src="...">
            $html = null;
            if (is_string($content)) {
                $html = $content;
            } elseif (is_array($content) && isset($content['html']) && is_string($content['html'])) {
                $html = $content['html'];
            }
            if (is_string($html) && strlen($html)) {
                // Lightweight regex to extract image sources
                if (preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/i', $html, $m)) {
                    foreach ($m[1] as $src) {
                        $items[] = [
                            'page_key' => $page->page_key,
                            'model' => 'page_content',
                            'id' => $page->id,
                            'key' => 'html',
                            'url' => $src,
                            'path' => null,
                            'filename' => null,
                            'source' => 'html',
                            'updated_at' => $page->updated_at,
                        ];
                    }
                }
            }
        }

        // 追加: 他モデルの画像参照も集計
        try {
            // News (CMS版)
            if (class_exists(\App\Models\News::class)) {
                $allNews = \App\Models\News::query()->get();
                foreach ($allNews as $news) {
                    // featured_image
                    if (!empty($news->featured_image)) {
                        $items[] = [
                            'page_key' => 'news',
                            'model' => 'news',
                            'id' => $news->id,
                            'key' => 'featured_image',
                            'url' => (string)$news->featured_image,
                            'path' => null,
                            'filename' => null,
                            'source' => 'column',
                            'updated_at' => $news->updated_at,
                        ];
                    }
                    // content の <img>
                    $html = (string)($news->content ?? '');
                    if ($html && preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/i', $html, $m)) {
                        foreach ($m[1] as $src) {
                            $items[] = [
                                'page_key' => 'news',
                                'model' => 'news',
                                'id' => $news->id,
                                'key' => 'html',
                                'url' => $src,
                                'path' => null,
                                'filename' => null,
                                'source' => 'html',
                                'updated_at' => $news->updated_at,
                            ];
                        }
                    }
                }
            }
        } catch (\Throwable $e) {
            // 例外は握りつぶして続行（環境差異吸収）
        }

        try {
            // Notice (NewsArticle)
            if (class_exists(\App\Models\NewsArticle::class)) {
                $articles = \App\Models\NewsArticle::query()->get();
                foreach ($articles as $a) {
                    if (!empty($a->featured_image)) {
                        $items[] = [
                            'page_key' => 'notice',
                            'model' => 'news_article',
                            'id' => $a->id,
                            'key' => 'featured_image',
                            'url' => (string)$a->featured_image,
                            'path' => null,
                            'filename' => null,
                            'source' => 'column',
                            'updated_at' => $a->updated_at,
                        ];
                    }
                    $html = (string)($a->content ?? '');
                    if ($html && preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/i', $html, $m)) {
                        foreach ($m[1] as $src) {
                            $items[] = [
                                'page_key' => 'notice',
                                'model' => 'news_article',
                                'id' => $a->id,
                                'key' => 'html',
                                'url' => $src,
                                'path' => null,
                                'filename' => null,
                                'source' => 'html',
                                'updated_at' => $a->updated_at,
                            ];
                        }
                    }
                }
            }
        } catch (\Throwable $e) {}

        try {
            // Publications
            if (class_exists(\App\Models\Publication::class)) {
                $pubs = \App\Models\Publication::query()->get();
                foreach ($pubs as $p) {
                    if (!empty($p->cover_image)) {
                        $items[] = [
                            'page_key' => 'publications',
                            'model' => 'publication',
                            'id' => $p->id,
                            'key' => 'cover_image',
                            'url' => (string)$p->cover_image,
                            'path' => null,
                            'filename' => null,
                            'source' => 'column',
                            'updated_at' => $p->updated_at,
                        ];
                    }
                }
            }
        } catch (\Throwable $e) {}

        try {
            // Economic Reports
            if (class_exists(\App\Models\EconomicReport::class)) {
                $reps = \App\Models\EconomicReport::query()->get();
                foreach ($reps as $r) {
                    if (!empty($r->cover_image)) {
                        $items[] = [
                            'page_key' => 'economic-reports',
                            'model' => 'economic_report',
                            'id' => $r->id,
                            'key' => 'cover_image',
                            'url' => (string)$r->cover_image,
                            'path' => null,
                            'filename' => null,
                            'source' => 'column',
                            'updated_at' => $r->updated_at,
                        ];
                    }
                }
            }
        } catch (\Throwable $e) {}

        try {
            // Seminars
            if (class_exists(\App\Models\Seminar::class)) {
                $sems = \App\Models\Seminar::query()->get();
                foreach ($sems as $s) {
                    if (!empty($s->featured_image)) {
                        $items[] = [
                            'page_key' => 'seminars',
                            'model' => 'seminar',
                            'id' => $s->id,
                            'key' => 'featured_image',
                            'url' => (string)$s->featured_image,
                            'path' => null,
                            'filename' => null,
                            'source' => 'column',
                            'updated_at' => $s->updated_at,
                        ];
                    }
                }
            }
        } catch (\Throwable $e) {}

        // URL正規化
        foreach ($items as &$it) {
            $u = (string)($it['url'] ?? '');
            if ($u === '') continue;
            $lower = strtolower($u);
            $isAbsolute = str_starts_with($lower, 'http://') || str_starts_with($lower, 'https://') || str_starts_with($u, '//');
            if ($isAbsolute) {
                // keep absolute URLs
                continue;
            }

            // keep app-root relative assets as-is (e.g. '/img/...', '/assets/...')
            if (str_starts_with($u, '/img/') || str_starts_with($u, '/images/') || str_starts_with($u, '/assets/') || str_starts_with($u, '/favicon')) {
                continue;
            }

            // already normalized storage path
            if (str_starts_with($u, '/storage/')) {
                continue;
            }

            // 'storage/...'
            if (str_starts_with($u, 'storage/')) {
                $it['url'] = '/' . $u;
                continue;
            }

            // other relative paths without leading slash: try public disk mapping
            if (!str_starts_with($u, '/')) {
                $path = ltrim(preg_replace('/^public\//', '', $u), '/');
                $it['url'] = Storage::url($path); // '/storage/...'
                continue;
            }

            // default: leave as-is (other root-relative, e.g. '/pages/...')
        }

        return response()->json([
            'success' => true,
            'data' => [
                'items' => $items,
                'count' => count($items),
            ]
        ]);
    }
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

    // 管理者向け: 公開状態に関わらず取得
    public function adminShow(string $pageKey): JsonResponse
    {
        $page = PageContent::where('page_key', $pageKey)->first();

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
            // JSON or raw HTML/string どちらも許容
            'content' => 'required',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        // content が文字列ならラップして保存（互換保持）
        $content = $validated['content'];
        if (is_string($content)) {
            $validated['content'] = [ 'html' => $content ];
        }

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
            // JSONまたは文字列どちらも許容
            'content' => 'sometimes',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        if (array_key_exists('content', $validated) && is_string($validated['content'])) {
            $validated['content'] = [ 'html' => $validated['content'] ];
        }

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

    // 管理: content.images[<key>] を差し替え
    public function replaceImage(Request $request, string $pageKey): JsonResponse
    {
        $page = PageContent::where('page_key', $pageKey)->first();
        if (!$page) {
            return response()->json(['message' => 'Page not found'], 404);
        }

        $request->validate([
            'key' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ]);

        $file = $request->file('image');
        $fileName = Str::slug($pageKey) . '-' . Str::slug($request->key) . '-' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('pages/' . $pageKey, $fileName, 'public');

        $content = $page->content ?? [];
        if (!is_array($content)) {
            $content = ['html' => (string)$content];
        }
        $content['images'] = $content['images'] ?? [];
        $content['images'][$request->key] = [
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
            'success' => true,
            'message' => 'Image replaced',
            'data' => [ 'image' => $content['images'][$request->key] ]
        ]);
    }

    // 管理: content.html 内の <img src> を置換
    public function replaceHtmlImage(Request $request, string $pageKey): JsonResponse
    {
        $page = PageContent::where('page_key', $pageKey)->first();
        if (!$page) {
            return response()->json(['message' => 'Page not found'], 404);
        }

        $request->validate([
            'old_url' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ]);

        $content = $page->content ?? [];
        $html = '';
        if (is_string($content)) { $html = $content; $content = ['html' => $html]; }
        elseif (is_array($content)) { $html = (string)($content['html'] ?? ''); }

        if ($html === '') {
            return response()->json(['success' => false, 'message' => 'HTML content not found'], 400);
        }

        $file = $request->file('image');
        $fileName = Str::slug($pageKey) . '-htmlimg-' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('pages/' . $pageKey, $fileName, 'public');
        $newUrl = Storage::url($path);

        $replaced = str_replace($request->old_url, $newUrl, $html);
        if ($replaced === $html) {
            // URL差異で失敗した場合、クオートやエンコードの差も考慮せずそのまま返す
            // 呼び出し側で old_url を見直す想定
            return response()->json(['success' => false, 'message' => 'Old URL not found in HTML'], 400);
        }

        $content['html'] = $replaced;
        $page->update([
            'content' => $content,
            'updated_by' => auth()->id()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'HTML image replaced',
            'data' => ['new_url' => $newUrl]
        ]);
    }
}
