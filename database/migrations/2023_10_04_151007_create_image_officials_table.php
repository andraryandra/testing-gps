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
        Schema::create('image_officials', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('official_store_id')->constrained('official_stores')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('visit_schedules_id')->constrained('visit_schedules')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('image');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image_officials');
    }
};
