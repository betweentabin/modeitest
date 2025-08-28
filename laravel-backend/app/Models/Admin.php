<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'full_name',
        'role',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
        'email_verified_at' => 'datetime',
    ];

    // リレーションシップ
    public function createdPages()
    {
        return $this->hasMany(Page::class, 'created_by');
    }

    public function updatedPages()
    {
        return $this->hasMany(Page::class, 'updated_by');
    }

    public function createdSeminars()
    {
        return $this->hasMany(Seminar::class, 'created_by');
    }

    public function updatedSeminars()
    {
        return $this->hasMany(Seminar::class, 'updated_by');
    }

    public function createdPublications()
    {
        return $this->hasMany(Publication::class, 'created_by');
    }

    public function updatedPublications()
    {
        return $this->hasMany(Publication::class, 'updated_by');
    }

    public function assignedInquiries()
    {
        return $this->hasMany(Inquiry::class, 'assigned_to');
    }

    public function uploadedMedia()
    {
        return $this->hasMany(Media::class, 'uploaded_by');
    }

    // アクセサー・ミューテーター
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    // スコープ
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    // ヘルパーメソッド
    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }

    public function isAdmin()
    {
        return in_array($this->role, ['super_admin', 'admin']);
    }

    public function canManage($resource)
    {
        if ($this->isSuperAdmin()) {
            return true;
        }
        
        // 各リソースに対する権限チェックのロジック
        return $this->isAdmin();
    }
}