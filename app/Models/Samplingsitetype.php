<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Samplingsitetype extends Model
{
    protected $table = 'samplingsitetypes';

    protected $fillable = [
        'samplingsitetype',
    ];

    public function samples()
    {
        return $this->hasMany(Samplingsite::class, 'samplingsitetype_id');
    }
}
