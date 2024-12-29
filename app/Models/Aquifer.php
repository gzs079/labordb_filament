<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aquifer extends Model
{
    protected $table = 'aquifers';

    protected $fillable = [
        'aquifer',
    ];

    public function samples()
    {
        return $this->hasMany(Samplingsite::class, 'aquifer_id');
    }
}
