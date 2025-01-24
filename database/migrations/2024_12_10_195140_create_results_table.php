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
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sample_id')->constrained()->cascadeOnDelete();
            $table->foreignId('parameter_id')->constrained()->restrictOnDelete();
            $table->unique(['sample_id', 'parameter_id']);
            $table->foreignId('unit_id')->constrained()->restrictOnDelete();
            $table->string('value', length:25);
            $table->double('loq')->nullable();
            $table->double('maxrange')->nullable();
            $table->double('valueassigned')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
