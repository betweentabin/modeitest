<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'category',
        'type',
        'publication_date',
        'issue_number',
        'author',
        'pages',
        'file_url',
        'cover_image',
        'price',
        'tags',
        'is_published',
        'is_downloadable',
        'members_only',
        'download_count',
        'view_count',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'publication_date' => 'date',
        'is_published' => 'boolean',
        'is_downloadable' => 'boolean',
        'members_only' => 'boolean',
        'pages' => 'integer',
        'download_count' => 'integer',
        'view_count' => 'integer',
        'price' => 'decimal:2',
    ];
}