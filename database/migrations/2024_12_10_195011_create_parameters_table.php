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
        Schema::create('parameters', function (Blueprint $table) {
            $table->id();
            $table->string('par_code', length:25)->unique();
            $table->string('description_humvi', length:75);
            $table->string('description_labor', length:75);
            $table->string('parametric_value', length:255)->nullable();
            $table->enum('parametric_value_type',['határérték','parametrikus érték'])->nullable();
            $table->double('parametric_value_min')->nullable();
            $table->double('parametric_value_max')->nullable();
            $table->foreignId('unit_id')->constrained()->restrictOnDelete();
            $table->enum('parameter_group',['Indikátor','Kémia','Mikrobiológia','Mikroszkópos biológia','Peszticidek','Radiológia','Szerves mikroszennyezők']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parameters');
    }
};
