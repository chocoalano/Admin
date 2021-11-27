<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryImg extends Model
{
    use HasFactory;
    protected $table = 'galleries_img';
    protected $fillable = [
        'photo'
    ];
    public function Gallery()
    {
        return $this->belongsTo('App\Models\Gallery');
    }
}
