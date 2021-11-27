<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoMeta extends Model
{
    use HasFactory;
    protected $table = 'seo_metas';
    protected $fillable = [
        'hid',
        'name',
        'content',
        'title',
        'page',
    ];
}
