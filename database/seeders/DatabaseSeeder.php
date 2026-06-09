<?php

namespace Database\Seeders;

use App\Models\Inventory;
use App\Models\Service;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Users ──────────────────────────────────────────────────
        $users = [
            [
                'name'     => 'Admin LaundryTrack',
                'email'    => 'admin@laundrytrack.id',
                'phone'    => '081234567890',
                'role'     => 'admin',
                'password' => Hash::make('admin123'),
            ],
            [
                'name'     => 'Kasir Satu',
                'email'    => 'kasir@laundrytrack.id',
                'phone'    => '081234567891',
                'role'     => 'kasir',
                'password' => Hash::make('kasir123'),
            ],
            [
                'name'     => 'Budi Kurir',
                'email'    => 'kurir@laundrytrack.id',
                'phone'    => '081234567892',
                'role'     => 'kurir',
                'password' => Hash::make('kurir123'),
            ],
            [
                'name'     => 'Andi Mahasiswa',
                'email'    => 'customer@laundrytrack.id',
                'phone'    => '081234567893',
                'role'     => 'customer',
                'address'  => 'Jl. Kampus No. 10, Kost Mawar',
                'password' => Hash::make('customer123'),
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(['email' => $user['email']], $user);
        }

        // ── Services ───────────────────────────────────────────────
        $services = [
            [
                'name'           => 'Cuci + Setrika',
                'description'    => 'Cuci bersih + setrika rapi. Paket terlengkap.',
                'price_per_kg'   => 7000,
                'estimated_days' => 2,
                'icon'           => 'dry_cleaning', // Menggunakan ikon laundry Google
            ],
            [
                'name'           => 'Cuci Saja',
                'description'    => 'Dicuci bersih tanpa setrika.',
                'price_per_kg'   => 5000,
                'estimated_days' => 1,
                'icon'           => 'water_drop', // Google menggunakan 'water_drop', bukan 'droplets'
            ],
            [
                'name'           => 'Setrika Saja',
                'description'    => 'Hanya setrika untuk baju sudah cuci.',
                'price_per_kg'   => 4000,
                'estimated_days' => 1,
                'icon'           => 'bolt', // Google menggunakan 'bolt', bukan 'zap'
            ],
            [
                'name'           => 'Express (6 Jam)',
                'description'    => 'Cuci + setrika selesai dalam 6 jam!',
                'price_per_kg'   => 12000,
                'estimated_days' => 0,
                'icon'           => 'schedule', // Google menggunakan 'schedule' atau 'watch_later', bukan 'clock'
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['name' => $service['name']], $service);
        }

        // ── Inventory ──────────────────────────────────────────────
        $inventories = [
            ['name' => 'Detergen Bubuk', 'category' => 'bahan', 'stock' => 15,   'unit' => 'kg',   'min_stock' => 3,  'price_per_unit' => 25000],
            ['name' => 'Pelembut Pakaian', 'category' => 'bahan', 'stock' => 8,    'unit' => 'liter', 'min_stock' => 2,  'price_per_unit' => 18000],
            ['name' => 'Parfum Laundry',  'category' => 'bahan', 'stock' => 2,    'unit' => 'liter', 'min_stock' => 2,  'price_per_unit' => 55000], // low!
            ['name' => 'Plastik Kemas',   'category' => 'kemasan', 'stock' => 200, 'unit' => 'pcs',  'min_stock' => 50, 'price_per_unit' => 500],
            ['name' => 'Hanger',          'category' => 'peralatan', 'stock' => 50, 'unit' => 'pcs', 'min_stock' => 20, 'price_per_unit' => 3000],
        ];

        foreach ($inventories as $item) {
            Inventory::updateOrCreate(['name' => $item['name']], $item);
        }

        // ── Settings ───────────────────────────────────────────────
        $settings = [
            ['key' => 'kurir_enabled',       'value' => '1',              'type' => 'boolean',  'group' => 'kurir',   'description' => 'Aktifkan layanan jemput antar'],
            ['key' => 'convenience_fee',     'value' => '1000',           'type' => 'integer',  'group' => 'order',   'description' => 'Biaya convenience layanan jemput (Rp)'],
            ['key' => 'laundry_name',        'value' => 'LaundryTrack',   'type' => 'string',   'group' => 'general', 'description' => 'Nama usaha laundry'],
            ['key' => 'laundry_phone',       'value' => '081234567890',   'type' => 'string',   'group' => 'general', 'description' => 'Nomor WA Admin'],
            ['key' => 'laundry_address',     'value' => 'Jl. Bersih No. 1, Kota Bersih', 'type' => 'string', 'group' => 'general', 'description' => 'Alamat laundry'],
            ['key' => 'qris_image',          'value' => null,             'type' => 'string',   'group' => 'payment', 'description' => 'Path gambar QRIS'],
            ['key' => 'bank_account_name',   'value' => 'LaundryTrack',   'type' => 'string',   'group' => 'payment', 'description' => 'Nama rekening bank'],
            ['key' => 'bank_account_number', 'value' => '1234567890',     'type' => 'string',   'group' => 'payment', 'description' => 'Nomor rekening bank'],
            ['key' => 'bank_name',           'value' => 'BCA',            'type' => 'string',   'group' => 'payment', 'description' => 'Nama bank'],
        ];

        foreach ($settings as $s) {
            Setting::updateOrCreate(['key' => $s['key']], $s);
        }
    }
}
