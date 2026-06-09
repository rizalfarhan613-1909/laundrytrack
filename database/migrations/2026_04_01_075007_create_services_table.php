<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');                          // e.g. "Cuci + Setrika", "Cuci Saja", "Express"
            $table->text('description')->nullable();
            $table->decimal('price_per_kg', 10, 2);          // Harga per KG
            $table->integer('estimated_days')->default(2);   // Estimasi hari
            $table->boolean('is_active')->default(true);
            $table->string('icon')->nullable();              // Lucide icon name
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};