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
        Schema::create('visits', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('official_store_id')->constrained('official_stores')->cascadeOnDelete()->cascadeOnUpdate();

            $table->string('ip_address')->nullable();
            $table->dateTime('check_in');
            $table->dateTime('check_out')->nullable();

            $table->float('latitude', 10, 6)->nullable(); // Kolom untuk latitude
            $table->float('longitude', 10, 6)->nullable(); // Kolom untuk longitude

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
