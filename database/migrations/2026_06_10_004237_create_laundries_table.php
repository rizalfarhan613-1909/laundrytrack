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
        Schema::create('laundries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address');
            $table->string('phone')->nullable();

            // KOLOM PAKET BISNIS (Pemasukan Startup)
            // free_commission = Paket Gratis (Potongan 8%)
            // premium_flat = Paket Premium (Rp 150.000 / bulan)
            $table->enum('subscription_type', ['free_commission', 'premium_flat'])->default('free_commission');

            // Masa aktif paket premium (jika memilih premium_flat)
            $table->timestamp('subscription_until')->nullable();

            // Menampung akumulasi hutang komisi 8% yang belum dibayar oleh mitra (untuk paket free_commission)
            $table->decimal('unpaid_commission', 12, 2)->default(0);

            $table->enum('status', ['pending', 'active', 'suspended'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laundries');
    }
};
