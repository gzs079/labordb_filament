<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Samplingreason extends Model
{
    protected $table = 'samplingreasons';

    protected $fillable = [
        'reason',
        'description',
    ];

    public function samples()
    {
        return $this->hasMany(Sample::class, 'samplingreason_id');
    }
}
