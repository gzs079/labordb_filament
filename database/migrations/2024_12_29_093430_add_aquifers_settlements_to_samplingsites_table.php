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
        Schema::table('samplingsites', function (Blueprint $table) {
            $table->dropColumn(['aquifer', 'settlement', 'type']);
            $table->foreignId('aquifer_id')->constrained()->restrictOnDelete();
            $table->foreignId('settlement_id')->constrained()->restrictOnDelete();
            $table->foreignId('samplingsitetype_id')->constrained()->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('samplingsites', function (Blueprint $table) {
            //
        });
    }
};
