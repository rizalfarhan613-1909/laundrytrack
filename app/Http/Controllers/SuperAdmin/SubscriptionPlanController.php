<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::withCount('laundries')->get();
        return view('superadmin.plans.index', compact('plans'));
    }

    public function create()
    {
        // Method tetap dipertahankan jika kedepannya kamu ingin memakai halaman terpisah
        return view('superadmin.plans.create');
    }

    public function store(Request $request)
    {
        // Menambahkan validasi 'unique' agar tidak ada nama paket yang kembar
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:subscription_plans,name',
            'monthly_price' => 'required|numeric|min:0',
            'fee_percentage' => 'required|numeric|min:0|max:100',
        ]);

        // Menggunakan $validated jauh lebih aman dibanding $request->all()
        SubscriptionPlan::create($validated);

        return redirect()->route('superadmin.plans.index')->with('success', 'Paket langganan berhasil ditambahkan.');
    }

    public function edit(SubscriptionPlan $plan)
    {
        // Method tetap dipertahankan jika kedepannya kamu ingin memakai halaman terpisah
        return view('superadmin.plans.edit', compact('plan'));
    }

    public function update(Request $request, SubscriptionPlan $plan)
    {
        // Validasi unique dengan mengabaikan ID paket ini sendiri agar tidak bentrok saat di-update
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:subscription_plans,name,' . $plan->id,
            'monthly_price' => 'required|numeric|min:0',
            'fee_percentage' => 'required|numeric|min:0|max:100',
        ]);

        // Menggunakan data yang sudah lolos validasi
        $plan->update($validated);

        return redirect()->route('superadmin.plans.index')->with('success', 'Paket langganan berhasil diperbarui.');
    }

    public function destroy(SubscriptionPlan $plan)
    {
        // Proteksi relasi data agar database tidak error berantai (constraint integrity)
        if ($plan->laundries()->count() > 0) {
            return back()->with('error', 'Paket tidak bisa dihapus karena sedang digunakan oleh beberapa toko.');
        }

        $plan->delete();
        return redirect()->route('superadmin.plans.index')->with('success', 'Paket langganan berhasil dihapus.');
    }
}