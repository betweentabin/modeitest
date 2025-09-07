<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EconomicReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category',
        'year',
        'publication_date',
        'author',
        'publisher',
        'keywords',
        'cover_image',
        'file_url',
        'file_size',
        'file_size_bytes',
        'pages',
        'is_downloadable',
        'members_only',
        'membership_level',
        'is_featured',
        'is_published',
        'download_count',
        'sort_order'
    ];

    protected $casts = [
        'publication_date' => 'date',
        'is_downloadable' => 'boolean',
        'members_only' => 'boolean',
        'membership_level' => 'string',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
    ];

    // JSONレスポンスに含めたいアクセサ
    protected $appends = ['cover_image_url'];

    // カテゴリの定数
    const CATEGORIES = [
        'quarterly' => '四半期経済レポート',
        'annual' => '年次経済統計',
        'regional' => '地域経済調査',
        'industry' => '産業別統計'
    ];

    /**
     * 公開されているレポートのスコープ
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * 特集レポートのスコープ
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * カテゴリでフィルタリングするスコープ
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * 年でフィルタリングするスコープ
     */
    public function scopeByYear($query, $year)
    {
        return $query->where('year', $year);
    }

    /**
     * カテゴリ名を取得
     */
    public function getCategoryNameAttribute()
    {
        return self::CATEGORIES[$this->category] ?? $this->category;
    }

    /**
     * ファイルサイズを人間が読みやすい形式で取得
     */
    public function getFormattedFileSizeAttribute()
    {
        // 優先: バイトカラム
        if (!is_null($this->file_size_bytes) && $this->file_size_bytes > 0) {
            $bytes = (int) $this->file_size_bytes;
            $units = ['B', 'KB', 'MB', 'GB'];
            $factor = 0;
            while ($bytes >= 1024 && $factor < count($units) - 1) {
                $bytes /= 1024;
                $factor++;
            }
            return sprintf('%.2f %s', $bytes, $units[$factor]);
        }

        // 後方互換: 旧decimal(8,2)のMB値
        if (!is_null($this->file_size) && $this->file_size > 0) {
            return sprintf('%.2f MB', (float) $this->file_size);
        }

        return null;
    }

    /**
     * カバー画像のフルURLを取得
     */
    public function getCoverImageUrlAttribute()
    {
        if (!$this->cover_image) {
            return '/img/image-1.png'; // デフォルト画像
        }
        
        // すでにフルURLの場合はそのまま返す
        if (str_starts_with($this->cover_image, 'http')) {
            return $this->cover_image;
        }
        
        return asset('storage/' . $this->cover_image);
    }

    /**
     * ファイルのフルURLを取得
     */
    public function getFileUrlFullAttribute()
    {
        if (!$this->file_url) {
            return null;
        }
        
        // すでにフルURLの場合はそのまま返す
        if (str_starts_with($this->file_url, 'http')) {
            return $this->file_url;
        }
        
        return asset('storage/' . $this->file_url);
    }
}
