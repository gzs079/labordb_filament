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
        Schema::create('samplingsites', function (Blueprint $table) {
            $table->id();
            $table->string('site', length:25)->unique();
            $table->string('name_laboratory', length:75);
            $table->string('name_full', length:75);
            $table->string('name_short', length:75);
            $table->string('name_humvi_old', length:75)->nullable();
            $table->string('aquifer', length:75);
            $table->string('settlement', length:75);
            $table->string('type', length:75);
            $table->float('GPS_N_Y')->nullable();
            $table->float('GPS_E_X')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('samplingsites');
    }
};
