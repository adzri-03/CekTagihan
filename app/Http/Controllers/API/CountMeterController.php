<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\PembacaanMeter;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Support\Facades\Log;
use Mpdf\Mpdf;

class CountMeterController extends Controller
{
    private const MAX_METER = 100000;

    public function store(Request $request)
    {
        logger()->channel('meter')->info('Pembacaan meter baru', [
            'request' => $request->all(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);
        Log::info('api store() dipanggil dengan data: ', $request->all());
        // Validate request
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'meter_akhir' => 'required|numeric|min:0',
        ]);

        try {
            $customerId = $validated['customer_id'];
            $meterAkhir = $validated['meter_akhir'];

            // Ambil harga dari cache atau database
            $price = cache()->remember("customer_{$customerId}_harga", 60, function () use ($customerId) {
                return Customer::with('golongan')->findOrFail($customerId)->golongan->harga ?? 1500;
            });

            // Get last reading
            $lastRecord = PembacaanMeter::where('customer_id', $customerId)
                ->latest()
                ->first();

            // Validate maximum meter reading
            if ($meterAkhir > self::MAX_METER) {
                return response()->json([
                    'status' => false,
                    'message' => "Meteran tidak valid, melebihi batas maksimum " . self::MAX_METER,
                ], 422);
            }

            $meterAwal = $lastRecord?->meter_akhir ?? 0;

            // Check for invalid meter readings
            if (!$this->isValidMeterReading($meterAwal, $meterAkhir)) {
                return response()->json([
                    'status' => false,
                    'message' => "Meteran akhir tidak valid. Mohon dicek kembali.",
                ], 422);
            }

            // Calculate usage and total
            $penggunaan = $this->calculateUsage($meterAwal, $meterAkhir);
            $total = $penggunaan * $price;

            // Create new reading
            $data = PembacaanMeter::create([
                'customer_id' => $customerId,
                'meter_awal' => $meterAwal % self::MAX_METER,
                'meter_akhir' => $meterAkhir,
                'pemakaian' => $penggunaan,
                'total' => $total,
            ]);
            Log::info('Data pembacaan meter berhasil disimpan', $data->toArray());
            return response()->json([
                'status' => true,
                'message' => "Pembacaan meter berhasil disimpan",
                'data' => $data,
            ]);
            logger()->channel('meter')->info('Pembacaan berhasil disimpan', [
                'data' => $data->toArray()
            ]);
        } catch (\Exception $e) {
            logger()->channel('meter')->error('Gagal menyimpan pembacaan', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            report($e);
            return response()->json([
                'status' => false,
                'message' => "Terjadi kesalahan sistem",
            ], 500);
        }
    }

    private function isValidMeterReading(int $meterAwal, int $meterAkhir): bool
    {
        $isReset = $meterAwal + $meterAkhir > self::MAX_METER;
        return $isReset || $meterAkhir >= $meterAwal;
    }

    private function calculateUsage(int $meterAwal, int $meterAkhir): int
    {
        return $meterAkhir >= $meterAwal
            ? $meterAkhir - $meterAwal
            : (self::MAX_METER - $meterAwal) + $meterAkhir;
    }

    public function invoice(PembacaanMeter $pembacaanMeter)
    {
        $data = $pembacaanMeter->load('customer');

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => [80, 200],
            'margin_left' => 2,
            'margin_right' => 2,
            'margin_top' => 2,
            'margin_bottom' => 2,
            'default_font_size' => 9,
            'tempDir' => storage_path('framework/mpdf')
        ]);

        $html = view('livewire.components.invoice', compact('data'))->render();
        $mpdf->WriteHTML($html);

        return response()->streamDownload(
            fn() => $mpdf->Output(),
            'invoice-' . $data->customer->pam_code . '-' . $data->created_at->format('Ymd') . '.pdf'
        );
    }
}
