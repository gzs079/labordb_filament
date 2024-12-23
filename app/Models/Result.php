<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $table = 'results';

    protected $fillable = [
        'sample_id',
        'parameter_id',
        'unit_id',
        'value',
        'loq',
        'maxrange',
        'valueassigned',
    ];

    protected $casts = [
        'loq' => 'float',
        'maxrange' => 'float',
        'valueassigned' => 'float',
    ];

    public function sample()
    {
        return $this->belongsTo(Sample::class, 'sample_id');
    }

    public function parameter()
    {
        return $this->belongsTo(Parameter::class, 'parameter_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
