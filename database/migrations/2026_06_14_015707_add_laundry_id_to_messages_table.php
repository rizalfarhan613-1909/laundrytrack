<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // Menambahkan kolom laundry_id sebagai foreign key terhubung ke tabel laundries
            $table->foreignId('laundry_id')->nullable()->after('conversation_id')->constrained('laundries')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign(['laundry_id']);
            $table->dropColumn('laundry_id');
        });
    }
};