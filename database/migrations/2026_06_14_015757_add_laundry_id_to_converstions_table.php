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
        Schema::table('conversations', function (Blueprint $table) {
            // Menambahkan kolom laundry_id setelah kolom order_id
            $table->foreignId('laundry_id')
                  ->nullable()
                  ->after('order_id')
                  ->constrained('laundries')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('conversations', function (Blueprint $table) {
            // Menghapus foreign key dan kolomnya jika migrasi di-rollback
            $table->dropForeign(['laundry_id']);
            $table->dropColumn('laundry_id');
        });
    }
};