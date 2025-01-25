<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    protected $table = 'parameters';

    protected $fillable = [
        'par_code',
        'description_humvi',
        'description_labor',
        'parametric_value',
        'parametric_value_type',
        'parametric_value_min',
        'parametric_value_max',
        'unit_id',
        'parameter_group'
    ];

    public function results()
    {
        return $this->hasMany(Result::class, 'parameter_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
