<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laboratory extends Model
{
    protected $table = 'laboratories';

    protected $fillable = [
        'laboratory',
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
        return $this->hasMany(Sample::class, 'laboratory_id');
    }
}
