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
        Schema::create('humviresponsibles', function (Blueprint $table) {
            $table->id();
            $table->string('responsible', length:10)->unique();
            $table->string('name', length:150);
            $table->string('address', length:150);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('humviresponsibles');
    }
};
