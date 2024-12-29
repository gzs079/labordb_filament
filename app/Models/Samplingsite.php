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
        'aquifer_id',
        'settlement_id',
        'samplingsitetype_id',
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

    public function aquifer()
    {
        return $this->belongsTo(Aquifer::class, 'aquifer_id');
    }

    public function settlement()
    {
        return $this->belongsTo(Settlement::class, 'settlement_id');
    }

    public function samplingsitetype()
    {
        return $this->belongsTo(Samplingsitetype::class, 'samplingsitetype_id');
    }
}
