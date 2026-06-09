<?php

// database/migrations/2024_01_01_000010_create_conversations_table.php
//
// Tabel conversations menyimpan "ruang chat" antara dua pihak.
// Setiap conversation bisa terikat ke satu order (opsional).
// Contoh: Customer A chat dengan Kasir terkait Order #LT-001

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();

            // Dua peserta dalam percakapan
            // participant_one selalu user dengan ID lebih kecil (untuk mencegah duplikat)
            $table->foreignId('participant_one_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->foreignId('participant_two_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Konteks order — OPSIONAL
            // Jika null = chat umum, jika ada = chat terkait order tertentu
            $table->foreignId('order_id')
                  ->nullable()
                  ->constrained('orders')
                  ->nullOnDelete();

            // Cache pesan terakhir untuk ditampilkan di inbox tanpa JOIN
            $table->text('last_message')->nullable();
            $table->timestamp('last_message_at')->nullable();

            // Siapa yang kirim pesan terakhir (untuk menentukan badge unread)
            $table->foreignId('last_sender_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            // Jumlah pesan yang belum dibaca per peserta
            // Disimpan terpisah untuk performa (tidak perlu COUNT setiap saat)
            $table->unsignedInteger('unread_one')->default(0); // unread untuk participant_one
            $table->unsignedInteger('unread_two')->default(0); // unread untuk participant_two

            // Status conversation
            $table->enum('status', ['active', 'archived', 'resolved'])->default('active');

            $table->timestamps();

            // Unique: satu conversation per pasangan user + order
            // Mencegah duplikasi ruang chat yang sama
            $table->unique(['participant_one_id', 'participant_two_id', 'order_id'], 'conv_p1_p2_o_unique');
            // Index untuk query cepat
            $table->index('last_message_at');
            $table->index('order_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};