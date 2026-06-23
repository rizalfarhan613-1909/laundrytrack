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
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: 'Gratis' atau 'Premium Bulanan'
            $table->decimal('monthly_price', 12, 2)->default(0); // Harga langganan (0 jika gratis, atau misal 100000)
            $table->decimal('fee_percentage', 5, 2)->default(0); // Persentase potongan (misal: 8.00 untuk 8%)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
