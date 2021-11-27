<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigService extends Model
{
    use HasFactory;
    protected $table = 'config_services';
    protected $fillable = [
        'icon',
        'title',
        'status',
    ];
}
