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
        Schema::create('official_stores', function (Blueprint $table) {
            // $table->id();
            $table->uuid('id')->primary();

            // $table->foreignUuid('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignUuid('category_id')->constrained()->onDelete('cascade')->onUpdate('cascade');

            $table->string('name', 100);
            $table->enum('status', ['ACTIVE', 'INACTIVE'])->default('ACTIVE');
            $table->string('phone', 13)->nullable();
            $table->string('email', 50)->nullable();

            $table->string('city', 100)->nullable();
            $table->string('province', 100)->nullable();
            $table->string('address', 100)->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->string('latitude', 20)->nullable();
            $table->string('longitude', 20)->nullable();

            $table->string('slug')->unique();
            $table->longText('description')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('official_stores');
    }
};
