<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    protected $table = 'settlements';

    protected $fillable = [
        'settlement',
    ];

    public function samples()
    {
        return $this->hasMany(Samplingsite::class, 'settlement_id');
    }
}
