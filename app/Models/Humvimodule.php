<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Humvimodule extends Model
{
    protected $table = 'humvimodules';

    protected $fillable = [
        'modul',
        'description',
    ];

    public function samples()
    {
        return $this->hasMany(Sample::class, 'humvimodule_id');
    }

}
