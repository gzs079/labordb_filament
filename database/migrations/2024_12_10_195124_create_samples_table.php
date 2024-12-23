<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('samples', function (Blueprint $table) {
            $table->id();
            $table->string('sample_lab_id', length:25);
            $table->foreignId('humvimodule_id')->constrained()->restrictOnDelete();
            $table->foreignId('humviresponsible_id')->constrained()->restrictOnDelete();
            $table->foreignId('samplingtype_id')->constrained()->restrictOnDelete();
            $table->date('date_sampling')->default('1900-01-01');
            $table->foreignId('laboratory_id')->constrained()->restrictOnDelete();
            $table->date('date_samplereceipt')->nullable();
            $table->date('date_analyses_start')->nullable();
            $table->date('date_analyses_end')->nullable();
            $table->foreignId('samplingreason_id')->constrained()->restrictOnDelete();
            $table->string('sampling_reason_details', length:255)->nullable();
            $table->foreignId('samplingsite_id')->constrained()->restrictOnDelete();
            $table->string('sampling_site_details', length:255)->nullable();
            $table->foreignId('accreditedsamplingstatus_id')->nullable()->constrained()->restrictOnDelete();
            $table->foreignId('sampler_id')->nullable()->constrained()->restrictOnDelete();
            $table->boolean('humvi_export')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('samples');
    }
};
