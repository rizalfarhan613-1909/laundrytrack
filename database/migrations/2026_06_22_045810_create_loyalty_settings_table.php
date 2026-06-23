<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('loyalty_settings', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke toko laundry (asumsi tabel 'laundries')
            $table->foreignId('laundry_id')->constrained('laundries')->onDelete('cascade');

            $table->boolean('is_active')->default(true); // Fitur aktif/nonaktif
            $table->integer('threshold_amount')->default(50000); // Nominal per 1 poin
            $table->integer('points_earned')->default(1); // Jumlah poin yang didapat

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyalty_settings');
    }
};
