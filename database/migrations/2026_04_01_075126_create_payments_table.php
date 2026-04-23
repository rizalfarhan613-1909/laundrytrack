<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->string('payment_code', 30)->unique();             // PAY-20240101-001
            $table->decimal('amount', 12, 2);
            $table->enum('method', ['cash', 'transfer', 'qris'])->default('cash');
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->string('proof_image')->nullable();                // Path upload bukti transfer
            $table->text('notes')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};