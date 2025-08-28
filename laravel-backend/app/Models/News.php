<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'content',
        'category',
        'type',
        'featured_image',
        'published_date',
        'status',
        'membership_requirement',
        'view_count',
        'is_featured',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'published_date' => 'date',
        'is_featured' => 'boolean',
        'view_count' => 'integer'
    ];

    // Relationships
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeForMembership($query, $membershipLevel = 'none')
    {
        $levels = ['none', 'basic', 'standard', 'premium'];
        $allowedLevels = array_slice($levels, 0, array_search($membershipLevel, $levels) + 1);
        
        return $query->whereIn('membership_requirement', $allowedLevels);
    }

    // Accessors
    public function getFormattedDateAttribute()
    {
        return $this->published_date->format('Y.m.d');
    }

    public function getExcerptAttribute()
    {
        return strlen($this->description) > 100 
            ? substr($this->description, 0, 100) . '...' 
            : $this->description;
    }
}