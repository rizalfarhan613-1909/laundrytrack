<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code', 20)->unique();              // e.g. LT-20240101-001
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services');
            $table->foreignId('kurir_id')->nullable()->constrained('users')->nullOnDelete();

            // Order Details
            $table->decimal('weight_kg', 8, 2)->nullable();          // Berat KG (diisi kasir)
            $table->decimal('price_per_kg', 10, 2);                  // Snapshot harga saat order
            $table->decimal('service_fee', 10, 2)->default(0);       // Convenience fee jemput = 1000
            $table->decimal('total_price', 10, 2)->default(0);       // weight * price + service_fee

            // Pickup/Delivery
            $table->enum('pickup_type', ['antar_sendiri', 'jemput'])->default('antar_sendiri');
            $table->text('pickup_address')->nullable();               // Alamat jika jemput
            $table->string('pickup_note')->nullable();

            // Status Tracking
            $table->enum('status', [
                'pending',      // Baru masuk
                'pickup',       // Kurir menjemput
                'in_process',   // Sedang dicuci/disetrika
                'ready',        // Selesai, siap diambil/diantar
                'finished',     // Selesai total
                'cancelled'     // Dibatalkan
            ])->default('pending');

            // Notes
            $table->text('notes')->nullable();
            $table->text('special_instructions')->nullable();

            // Timestamps
            $table->timestamp('pickup_at')->nullable();
            $table->timestamp('process_at')->nullable();
            $table->timestamp('ready_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index('customer_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};