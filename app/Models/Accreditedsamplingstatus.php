<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accreditedsamplingstatus extends Model
{
    protected $table = 'accreditedsamplingstatuses';

    protected $fillable = [
        'status',
        'description'
    ];

    public function samples()
    {
        return $this->hasMany(Sample::class, 'accreditedsamplingstatus_id');
    }

}
