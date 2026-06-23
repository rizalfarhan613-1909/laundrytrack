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
        Schema::create('loyalty_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('laundry_id')->constrained('laundries')->onDelete('cascade');
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade'); // Link ke order

            $table->integer('amount'); // Jumlah poin (misal: 10)
            $table->string('type'); // 'earning' atau 'redemption'
            $table->string('description'); // Keterangan (misal: "Poin Order #ORD123")

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyalty_transactions');
    }
};
