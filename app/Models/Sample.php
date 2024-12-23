<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sample extends Model
{
    use HasFactory;

    protected $table = 'samples';

    protected $fillable = [
        'sample_lab_id',
        'humvimodule_id',
        'humviresponsible_id',
        'samplingtype_id',
        'date_sampling',
        'laboratory_id',
        'date_samplereceipt',
        'date_analyses_start',
        'date_analyses_end',
        'samplingreason_id',
        'sampling_reason_details',
        'samplingsite_id',
        'sampling_site_details',
        'accreditedsamplingstatus_id',
        'sampler_id',
        'humvi_export',
    ];

    protected $casts = [
        'date_sampling' => 'date',
        'date_samplereceipt' => 'date',
        'date_analyses_start' => 'date',
        'date_analyses_end' => 'date',
        'humvi_export' => 'boolean',
    ];

    //Dátum előre formázása
    public function getFormattedDateSamplingAttribute()
    {
        return $this->date_sampling ? Carbon::parse($this->date_sampling)->format('Y-m-d') : null;
    }

    public function getFormattedDateSamplereceiptAttribute()
    {
        return $this->date_samplereceipt ? Carbon::parse($this->date_samplereceipt)->format('Y-m-d') : null;
    }
    public function getFormattedDateAnalysesStartAttribute()
    {
        return $this->date_analyses_start ? Carbon::parse($this->date_analyses_start)->format('Y-m-d') : null;
    }
    public function getFormattedDateAnalysesEndAttribute()
    {
        return $this->date_analyses_end ? Carbon::parse($this->date_analyses_end)->format('Y-m-d') : null;
    }

    public function humviModule()
    {
        return $this->belongsTo(HumviModule::class, 'humvimodule_id');
    }

    public function humviResponsible()
    {
        return $this->belongsTo(HumviResponsible::class, 'humviresponsible_id');
    }

    public function samplingType()
    {
        return $this->belongsTo(SamplingType::class, 'samplingtype_id');
    }

    public function laboratory()
    {
        return $this->belongsTo(Laboratory::class, 'laboratory_id');
    }

    public function samplingReason()
    {
        return $this->belongsTo(SamplingReason::class, 'samplingreason_id');
    }

    public function samplingSite()
    {
        return $this->belongsTo(SamplingSite::class, 'samplingsite_id');
    }

    public function accreditedSamplingStatus()
    {
        return $this->belongsTo(AccreditedSamplingStatus::class, 'accreditedsamplingstatus_id');
    }

    public function sampler()
    {
        return $this->belongsTo(Sampler::class, 'sampler_id');
    }

    public function results()
    {
        return $this->hasMany(Result::class, 'sample_id');
    }
}
