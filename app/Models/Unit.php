<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'units';

    protected $fillable = [
        'unit_code',
        'description_humvi',
        'description_labor'
    ];

    public function results()
    {
        return $this->hasMany(Result::class, 'unit_id');
    }
}
