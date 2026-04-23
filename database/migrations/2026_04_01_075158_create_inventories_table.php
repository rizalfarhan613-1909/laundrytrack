<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('name');                          // Nama item: Detergen, Pelembut, Parfum
            $table->string('category')->default('bahan');   // bahan, peralatan, kemasan
            $table->decimal('stock', 10, 2)->default(0);    // Stok saat ini
            $table->string('unit', 20)->default('liter');   // liter, kg, pcs, botol
            $table->decimal('min_stock', 10, 2)->default(1); // Batas minimum alert
            $table->decimal('price_per_unit', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('inventory_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_id')->constrained('inventories')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users');
            $table->enum('type', ['in', 'out'])->default('out');
            $table->decimal('quantity', 10, 2);
            $table->decimal('stock_before', 10, 2);
            $table->decimal('stock_after', 10, 2);
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_logs');
        Schema::dropIfExists('inventories');
    }
};