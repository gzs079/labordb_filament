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
        Schema::create('laboratories', function (Blueprint $table) {
            $table->id();
            $table->string('laboratory', length:10);
            $table->string('accreditation_number', length:20);
            $table->string('name', length:150);
            $table->string('address', length:150);
            $table->date('valid_starts')->default('1900-01-01');
            $table->date('valid_ends')->default('1900-01-01');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laboratories');
    }
};
