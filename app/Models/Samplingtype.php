<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Samplingtype extends Model
{
    protected $table = 'samplingtypes';

    protected $fillable = [
        'type',
        'description',
    ];

    public function samples()
    {
        return $this->hasMany(Sample::class, 'samplingtype_id');
    }
}
