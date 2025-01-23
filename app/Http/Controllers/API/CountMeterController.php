<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\PembacaanMeter;
use App\Http\Controllers\Controller;

class CountMeterController extends Controller
{
    public function store(Request $request)
    {
        $customerId = $request->input('customer_id');
        $meterAkhir = $request->input('meter_akhir');
        $maxMeter = 100000;

        // Ambil catatan terakhir pelanggan
        $lastRecord = PembacaanMeter::where('customer_id', $customerId)->orderBy('created_at', 'DESC')->first();

        // Validasi: Meter akhir tidak boleh melebihi batas maksimum
        if ($meterAkhir > $maxMeter) {
            return response()->json([
                'status' => false,
                'message' => "Meteran tidak valid, melebihi batas maksimum $maxMeter. Mohon dicek kembali.",
            ], 400);
        }

        // Tentukan nilai meter_awal
        $meterAwal = $lastRecord ? $lastRecord->meter_akhir : 0;
        $isReset = $meterAwal + $meterAkhir > $maxMeter;

        if (!$isReset && $lastRecord && $meterAkhir < $lastRecord->meter_akhir && $meterAkhir < $meterAwal) {
            return response()->json([
                'status' => false,
                'message' => "Meteran akhir tidak boleh lebih kecil dari meteran awal tanpa reset. Mohon dicek kembali.",
            ], 400);
        }

        // Logika jam bilangan: Hitung penggunaan
        $penggunaan = $meterAkhir >= $meterAwal
            ? $meterAkhir - $meterAwal
            : ($maxMeter - $meterAwal) + $meterAkhir;

        // Hitung total biaya
        $harga = 1500;
        $total = $penggunaan * $harga;

        // Simpan data pembacaan baru
        $data = PembacaanMeter::create([
            'customer_id' => $customerId,
            'meter_awal' => $meterAwal % $maxMeter, // Modular untuk mendukung reset
            'meter_akhir' => $meterAkhir,
            'pemakaian' => $penggunaan,
            'total' => $total,
            'created_at' => now(),
        ]);

        return response()->json([
            'status' => true,
            'message' => "Success",
            'data' => $data,
        ], 200);
    }

    public function invoice($customer_id) {
        $data = PembacaanMeter::where('customer_id', $customer_id)->orderBy('created_at', 'DESC')->first();

        return response()->json($data);
    }
}
