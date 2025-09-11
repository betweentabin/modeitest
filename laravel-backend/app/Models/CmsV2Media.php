<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CmsV2Media extends Model
{
    protected $table = 'cms_v2_media';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id','filename','mime','size','data'];
}

