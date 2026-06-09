<?php

/**
 * Migration: add_halal_workflow_columns_to_orders_table
 *
 * Menambahkan 3 kolom baru ke tabel 'orders' untuk mendukung
 * fitur Smart Sorting & Halal Workflow.
 *
 * Jalankan dengan: php artisan migrate
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration (tambah kolom).
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            // ── Kolom 1: is_halal_service ──────────────────────────────────
            // Menandai apakah order ini meminta layanan laundry halal.
            // Default false = layanan biasa (non-halal).
            $table->boolean('is_halal_service')
                  ->default(false)
                  ->after('notes')
                  ->comment('Apakah order menggunakan layanan laundry halal');

            // ── Kolom 2: has_najis ─────────────────────────────────────────
            // Menandai apakah pakaian mengandung najis (darah, ompol, kotoran).
            // Hanya relevan jika is_halal_service = true.
            // Jika true → halal_status otomatis = 'pending_thaharah'.
            $table->boolean('has_najis')
                  ->default(false)
                  ->after('is_halal_service')
                  ->comment('Apakah pakaian mengandung najis - memerlukan thaharah dahulu');

            // ── Kolom 3: halal_status ──────────────────────────────────────
            // Melacak tahap alur halal dari sebuah order.
            //
            // Alur status:
            //   none               → Order biasa / halal tapi tidak ada najis
            //   pending_thaharah   → Perlu proses bilas najis terlebih dahulu
            //   thaharah_completed → Bilas najis selesai, siap masuk cuci utama
            //   main_wash          → Sudah masuk proses cuci utama halal
            $table->enum('halal_status', [
                        'none',               // default: tidak perlu thaharah
                        'pending_thaharah',   // menunggu proses bilas najis
                        'thaharah_completed', // thaharah selesai
                        'main_wash',          // sedang dalam cuci utama
                    ])
                  ->default('none')
                  ->after('has_najis')
                  ->comment('Status alur halal: none | pending_thaharah | thaharah_completed | main_wash');

            // ── Kolom 4: thaharah_completed_at ────────────────────────────
            // Timestamp kapan proses thaharah selesai dikonfirmasi kasir.
            // Null jika belum atau tidak memerlukan thaharah.
            $table->timestamp('thaharah_completed_at')
                  ->nullable()
                  ->after('halal_status')
                  ->comment('Waktu konfirmasi thaharah selesai oleh kasir');

            // ── Kolom 5: thaharah_confirmed_by ────────────────────────────
            // Menyimpan ID kasir/admin yang mengkonfirmasi thaharah selesai.
            // Foreign key ke tabel users.
            $table->foreignId('thaharah_confirmed_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete()
                  ->after('thaharah_completed_at')
                  ->comment('ID user (kasir/admin) yang mengkonfirmasi thaharah selesai');

            // ── Index untuk performa query ─────────────────────────────────
            // Index pada halal_status agar query filter order thaharah cepat.
            $table->index(['halal_status', 'is_halal_service'], 'idx_halal_workflow');
        });
    }

    /**
     * Batalkan migration (hapus kolom yang ditambahkan).
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Hapus index terlebih dahulu sebelum hapus kolom
            $table->dropIndex('idx_halal_workflow');

            // Hapus foreign key constraint
            $table->dropForeign(['thaharah_confirmed_by']);

            // Hapus semua kolom yang ditambahkan
            $table->dropColumn([
                'is_halal_service',
                'has_najis',
                'halal_status',
                'thaharah_completed_at',
                'thaharah_confirmed_by',
            ]);
        });
    }
};