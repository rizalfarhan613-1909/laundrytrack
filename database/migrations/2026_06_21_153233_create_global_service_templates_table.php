<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('global_service_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: "Cuci + Setrika"
            $table->string('unit'); // Contoh: "Kg", "Pcs", "Meter"
            $table->decimal('base_price', 12, 2); // Harga standar rekomendasi pusat
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('global_service_templates');
    }
};