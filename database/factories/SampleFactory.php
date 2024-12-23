<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\HumviModule;
use App\Models\HumviResponsible;
use App\Models\SamplingType;
use App\Models\Laboratory;
use App\Models\SamplingReason;
use App\Models\SamplingSite;
use App\Models\AccreditedSamplingStatus;
use App\Models\Sample;
use App\Models\Sampler;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sample>
 */
class SampleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Sample::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sample_lab_id' => $this->faker->regexify('[A-Za-z0-9]{25}'),
            'humvimodule_id' => HumviModule::inRandomOrder()->first()->id,
            'humviresponsible_id' => HumviResponsible::inRandomOrder()->first()->id,
            'samplingtype_id' => SamplingType::inRandomOrder()->first()->id,
            'date_sampling' => $this->faker->date('Y-m-d', '2000-01-01'),
            'laboratory_id' => Laboratory::inRandomOrder()->first()->id,
            'date_samplereceipt' => $this->faker->optional()->date('Y-m-d'),
            'date_analyses_start' => $this->faker->optional()->date('Y-m-d'),
            'date_analyses_end' => $this->faker->optional()->date('Y-m-d'),
            'samplingreason_id' => SamplingReason::inRandomOrder()->first()->id,
            'sampling_reason_details' => $this->faker->optional()->sentence(),
            'samplingsite_id' => SamplingSite::inRandomOrder()->first()->id,
            'sampling_site_details' => $this->faker->optional()->sentence(),
            'accreditedsamplingstatus_id' => AccreditedSamplingStatus::inRandomOrder()->first()->id,
            'sampler_id' => Sampler::inRandomOrder()->first()->id,
            'humvi_export' => $this->faker->boolean(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
