<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    protected $table = 'galleries';
    protected $fillable = [
        'group_name',
        'page_display',
        'status',
    ];
    public function Img()
    {
        return $this->hasMany('App\Models\GalleryImg');
    }
}
