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
        Schema::table('users', function (Blueprint $table) {
            // Mengubah tipe ENUM menjadi VARCHAR(50) agar fleksibel menampung 'super_admin'
            $table->string('role', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Jika dikembalikan, kembali ke enum bawaan kamu (sesuaikan jika berbeda)
            $table->enum('role', ['admin', 'kasir', 'kurir', 'customer'])->change();
        });
    }
};