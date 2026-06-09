<?php

// database/migrations/2024_01_01_000011_create_messages_table.php
//
// Tabel messages menyimpan setiap pesan individual dalam sebuah conversation.

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();

            // Relasi ke conversation (ruang chat)
            $table->foreignId('conversation_id')
                  ->constrained('conversations')
                  ->onDelete('cascade');

            // Siapa yang mengirim pesan ini
            $table->foreignId('sender_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Isi pesan (teks)
            $table->text('body');

            // Tipe pesan — untuk extensibility di masa depan
            // 'text'   : pesan biasa
            // 'image'  : attachment foto (bukti, dll)
            // 'system' : pesan otomatis sistem (misal: "Order diperbarui ke status Ready")
            $table->enum('type', ['text', 'image', 'system'])->default('text');

            // Path file jika type = 'image'
            $table->string('attachment_path')->nullable();

            // Status baca — kapan penerima membaca pesan ini
            // NULL = belum dibaca, ada timestamp = sudah dibaca
            $table->timestamp('read_at')->nullable();

            // Soft delete — pesan bisa dihapus tanpa hilang dari database
            $table->softDeletes();

            $table->timestamps();

            // Index untuk query pesan per conversation (urut waktu)
            $table->index(['conversation_id', 'created_at']);

            // Index untuk hitung unread per sender
            $table->index(['conversation_id', 'sender_id', 'read_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};