<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Member extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'password',
        'company_name',
        'representative_name',
        'phone',
        'postal_code',
        'address',
        'membership_type',
        'status',
        'joined_date',
        'expiry_date',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'joined_date' => 'date',
        'expiry_date' => 'date',
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    // リレーションシップ
    public function activityLogs()
    {
        return $this->hasMany(MemberActivityLog::class);
    }

    public function seminarRegistrations()
    {
        return $this->hasMany(SeminarRegistration::class);
    }

    public function publicationDownloads()
    {
        return $this->hasMany(PublicationDownload::class);
    }

    public function pageViews()
    {
        return $this->hasMany(PageView::class);
    }

    // アクセサー・ミューテーター
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function getFullNameAttribute()
    {
        return $this->representative_name;
    }

    // スコープ
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByMembershipType($query, $type)
    {
        return $query->where('membership_type', $type);
    }

    public function scopeExpiring($query, $days = 30)
    {
        return $query->where('expiry_date', '<=', now()->addDays($days))
                    ->where('status', 'active');
    }

    // ヘルパーメソッド
    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isSuspended()
    {
        return $this->status === 'suspended';
    }

    public function hasAccess($membershipLevel)
    {
        if (!$this->isActive()) {
            return false;
        }

        $levels = [
            'free' => 0,
            'basic' => 1,
            'standard' => 2,
            'premium' => 3,
        ];

        $currentLevel = $levels[$this->membership_type] ?? 0;
        $requiredLevel = $levels[$membershipLevel] ?? 0;

        return $currentLevel >= $requiredLevel;
    }

    public function canRegisterSeminar($seminar)
    {
        if (!$this->isActive()) {
            return false;
        }

        // セミナーの会員要件チェック
        if ($seminar->membership_requirement !== 'none') {
            if (!$this->hasAccess($seminar->membership_requirement)) {
                return false;
            }
        }

        // 定員チェック
        if ($seminar->capacity > 0 && $seminar->current_participants >= $seminar->capacity) {
            return false;
        }

        // 申込期限チェック
        if ($seminar->application_deadline && now()->gt($seminar->application_deadline)) {
            return false;
        }

        return true;
    }

    public function canDownloadPublication($publication)
    {
        if (!$this->isActive()) {
            return false;
        }

        return $this->hasAccess($publication->membership_level);
    }

    public function getMembershipLevelValue()
    {
        $levels = [
            'basic' => 1,
            'standard' => 2,
            'premium' => 3,
        ];

        return $levels[$this->membership_type] ?? 0;
    }

    public function isExpiringSoon($days = 30)
    {
        if (!$this->expiry_date) {
            return false;
        }

        return $this->expiry_date <= now()->addDays($days);
    }
}