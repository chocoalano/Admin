<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRegist extends Model
{
    use HasFactory;
    protected $table = 'service_regists';
    protected $fillable = [
        'nama',
        'tanggal',
        'alamat',
        'keluhan',
    ];
}
