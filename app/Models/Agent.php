<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;
    protected $table = 'agents';
    protected $fillable = [
        'ip',
        'version',
        'city',
        'region',
        'region_code',
        'country',
        'country_name',
        'country_code',
        'country_code_iso3',
        'country_capital',
        'country_tld',
        'continent_code',
        'in_eu',
        'postal',
        'latitude',
        'longitude',
        'timezone',
        'utc_offset',
        'country_calling_code',
        'currency',
        'currency_name',
        'languages',
        'country_area',
        'country_population',
        'asn',
        'org',
    ];
}
