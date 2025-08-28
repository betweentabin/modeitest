<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    /**
     * メディアファイル一覧を取得
     */
    public function index(Request $request): JsonResponse
    {
        $directory = $request->get('directory', 'public/media');
        $search = $request->get('search', '');
        $type = $request->get('type', ''); // image, document, video, etc.
        
        try {
            $files = Storage::files($directory);
            $mediaFiles = [];

            foreach ($files as $file) {
                $fileName = basename($file);
                
                // 検索フィルター
                if ($search && stripos($fileName, $search) === false) {
                    continue;
                }

                $fileInfo = [
                    'id' => md5($file),
                    'name' => $fileName,
                    'path' => $file,
                    'url' => Storage::url($file),
                    'size' => Storage::size($file),
                    'type' => $this->getFileType($fileName),
                    'mime_type' => Storage::mimeType($file),
                    'last_modified' => Storage::lastModified($file),
                    'created_at' => Storage::lastModified($file), // Fallback
                ];

                // タイプフィルター
                if ($type && $fileInfo['type'] !== $type) {
                    continue;
                }

                $mediaFiles[] = $fileInfo;
            }

            // ソート
            $sortBy = $request->get('sort_by', 'last_modified');
            $sortDirection = $request->get('sort_direction', 'desc');
            
            usort($mediaFiles, function ($a, $b) use ($sortBy, $sortDirection) {
                $valueA = $a[$sortBy] ?? 0;
                $valueB = $b[$sortBy] ?? 0;
                
                if ($sortDirection === 'desc') {
                    return $valueB <=> $valueA;
                }
                return $valueA <=> $valueB;
            });

            // ページネーション（簡易版）
            $perPage = $request->get('per_page', 20);
            $page = $request->get('page', 1);
            $offset = ($page - 1) * $perPage;
            $paginatedFiles = array_slice($mediaFiles, $offset, $perPage);

            return response()->json([
                'data' => $paginatedFiles,
                'total' => count($mediaFiles),
                'per_page' => $perPage,
                'current_page' => $page,
                'last_page' => ceil(count($mediaFiles) / $perPage),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'メディアファイルの取得に失敗しました',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * ファイルをアップロード
     */
    public function upload(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|max:10240', // 10MB
            'directory' => 'nullable|string',
            'name' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'バリデーションエラー',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $file = $request->file('file');
            $directory = $request->get('directory', 'public/media');
            
            // ファイル名を生成
            $fileName = $request->get('name');
            if (!$fileName) {
                $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            } else {
                $fileName = Str::slug(pathinfo($fileName, PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            }

            // ファイルを保存
            $path = $file->storeAs($directory, $fileName);

            $fileInfo = [
                'id' => md5($path),
                'name' => $fileName,
                'original_name' => $file->getClientOriginalName(),
                'path' => $path,
                'url' => Storage::url($path),
                'size' => Storage::size($path),
                'type' => $this->getFileType($fileName),
                'mime_type' => $file->getMimeType(),
                'uploaded_at' => now(),
            ];

            return response()->json([
                'message' => 'ファイルをアップロードしました',
                'file' => $fileInfo
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'ファイルのアップロードに失敗しました',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * ファイルを削除
     */
    public function destroy(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'path' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'バリデーションエラー',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $path = $request->path;
            
            if (!Storage::exists($path)) {
                return response()->json([
                    'message' => 'ファイルが見つかりません'
                ], 404);
            }

            Storage::delete($path);

            return response()->json([
                'message' => 'ファイルを削除しました'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'ファイルの削除に失敗しました',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * ファイル情報を更新（名前変更）
     */
    public function update(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'old_path' => 'required|string',
            'new_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'バリデーションエラー',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $oldPath = $request->old_path;
            $newName = $request->new_name;
            
            if (!Storage::exists($oldPath)) {
                return response()->json([
                    'message' => 'ファイルが見つかりません'
                ], 404);
            }

            // 新しいパスを生成
            $directory = dirname($oldPath);
            $extension = pathinfo($oldPath, PATHINFO_EXTENSION);
            $newFileName = Str::slug(pathinfo($newName, PATHINFO_FILENAME)) . '.' . $extension;
            $newPath = $directory . '/' . $newFileName;

            // ファイルを移動（名前変更）
            Storage::move($oldPath, $newPath);

            $fileInfo = [
                'id' => md5($newPath),
                'name' => $newFileName,
                'path' => $newPath,
                'url' => Storage::url($newPath),
                'size' => Storage::size($newPath),
                'type' => $this->getFileType($newFileName),
                'mime_type' => Storage::mimeType($newPath),
                'updated_at' => now(),
            ];

            return response()->json([
                'message' => 'ファイル名を変更しました',
                'file' => $fileInfo
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'ファイル名の変更に失敗しました',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * ディレクトリ一覧を取得
     */
    public function directories(): JsonResponse
    {
        try {
            $directories = Storage::directories('public');
            $formattedDirectories = array_map(function ($dir) {
                return [
                    'name' => basename($dir),
                    'path' => $dir,
                    'file_count' => count(Storage::files($dir)),
                ];
            }, $directories);

            return response()->json($formattedDirectories);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'ディレクトリの取得に失敗しました',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 新しいディレクトリを作成
     */
    public function createDirectory(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'parent' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'バリデーションエラー',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $parent = $request->get('parent', 'public');
            $name = Str::slug($request->name);
            $directoryPath = $parent . '/' . $name;

            if (Storage::exists($directoryPath)) {
                return response()->json([
                    'message' => 'ディレクトリは既に存在します'
                ], 409);
            }

            Storage::makeDirectory($directoryPath);

            return response()->json([
                'message' => 'ディレクトリを作成しました',
                'directory' => [
                    'name' => $name,
                    'path' => $directoryPath,
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'ディレクトリの作成に失敗しました',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * メディア統計を取得
     */
    public function stats(): JsonResponse
    {
        try {
            $files = Storage::allFiles('public/media');
            $totalSize = 0;
            $typeCount = [
                'image' => 0,
                'document' => 0,
                'video' => 0,
                'audio' => 0,
                'other' => 0,
            ];

            foreach ($files as $file) {
                $totalSize += Storage::size($file);
                $type = $this->getFileType(basename($file));
                $typeCount[$type] = ($typeCount[$type] ?? 0) + 1;
            }

            return response()->json([
                'total_files' => count($files),
                'total_size' => $totalSize,
                'total_size_formatted' => $this->formatBytes($totalSize),
                'file_types' => $typeCount,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => '統計の取得に失敗しました',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * ファイルタイプを判定
     */
    private function getFileType(string $fileName): string
    {
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        $imageTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp'];
        $documentTypes = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt'];
        $videoTypes = ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm'];
        $audioTypes = ['mp3', 'wav', 'ogg', 'aac', 'flac'];

        if (in_array($extension, $imageTypes)) return 'image';
        if (in_array($extension, $documentTypes)) return 'document';
        if (in_array($extension, $videoTypes)) return 'video';
        if (in_array($extension, $audioTypes)) return 'audio';
        
        return 'other';
    }

    /**
     * バイト数をフォーマット
     */
    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes >= 1024 && $i < 4; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
