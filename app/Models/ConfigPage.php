<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigPage extends Model
{
    use HasFactory;
    protected $table = 'config_pages';
    protected $fillable = [
        'text',
        'option',
        'state',
    ];
}
