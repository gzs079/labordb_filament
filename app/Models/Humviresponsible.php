<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Humviresponsible extends Model
{
    protected $table = 'humviresponsibles';

    protected $fillable = [
        'responsible',
        'name',
        'address'
    ];

    public function samples()
    {
        return $this->hasMany(Sample::class, 'humviresponsible_id');
    }

}
