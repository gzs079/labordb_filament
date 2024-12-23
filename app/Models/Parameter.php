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
        'parametric_value_type'
    ];

    public function results()
    {
        return $this->hasMany(Result::class, 'parameter_id');
    }
}
