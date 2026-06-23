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
    Schema::table('laundries', function (Blueprint $table) {
        // Hubungkan toko ke tabel subscription_plans
        $table->foreignId('subscription_plan_id')->nullable()->after('name')->constrained('subscription_plans')->onDelete('set null');
        $table->boolean('is_active')->default(true)->after('subscription_plan_id');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laundries', function (Blueprint $table) {
            //
        });
    }
};
