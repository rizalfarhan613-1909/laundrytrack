<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use App\Models\Laundry;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SubscriptionPlanSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Paket Sistem Gratis dengan Potongan Komisi 8%
        $freePlan = SubscriptionPlan::firstOrCreate(
            ['name' => 'Skema Gratis (Komisi 8%)'],
            [
                'monthly_price' => 0,
                'fee_percentage' => 8.00,
            ]
        );

        // 2. Buat contoh Paket Premium
        $premiumPlan = SubscriptionPlan::firstOrCreate(
            ['name' => 'SaaS Premium Fixed'],
            [
                'monthly_price' => 150000,
                'fee_percentage' => 0.00,
            ]
        );

        // 3. Pasangkan semua Toko Laundry yang belum punya paket ke paket gratis
        Laundry::whereNull('subscription_plan_id')->update([
            'subscription_plan_id' => $freePlan->id,
            'is_active' => true
        ]);

        // 4. BUAT AKUN SUPER ADMIN / CEO JIKA BELUM ADA
        User::firstOrCreate(
            ['email' => 'ceo@laundrytrack.com'],
            [
                'name' => 'Muhammad Farhan Rizal',
                'password' => Hash::make('ceo123'),
                'role' => 'super_admin',
                'laundry_id' => null, // Wajib NULL karena CEO mengawasi semua toko global
            ]
        );
    }
}