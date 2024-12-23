<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Samplingsite extends Model
{
    protected $table = 'samplingsites';

    protected $fillable = [
        'site',
        'name_laboratory',
        'name_full',
        'name_short',
        'name_humvi_old',
        'aquifer',
        'settlement',
        'type',
        'GPS_N_Y',
        'GPS_E_X',
    ];

    protected $casts = [
        'GPS_N_Y' => 'float',
        'GPS_E_X' => 'float',
    ];

    public function samples()
    {
        return $this->hasMany(Sample::class, 'samplingsite_id');
    }
}
