<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sampler extends Model
{
    protected $table = 'samplers';

    protected $fillable = [
        'sampler',
        'accreditation_number',
        'name',
        'address',
        'valid_starts',
        'valid_ends'
    ];

    protected $casts = [
        'valid_starts' => 'date',
        'valid_ends' => 'date',
    ];

    public function samples()
    {
        return $this->hasMany(Sample::class, 'sampler_id');
    }

}
