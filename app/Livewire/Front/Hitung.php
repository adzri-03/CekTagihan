<?php

namespace App\Livewire\Front;

use Livewire\Component;
use App\Models\Customer;
use App\Models\PembacaanMeter;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Hitung extends Component
{
    public $customerId, $customer, $meterAkhir, $errorMessage, $successMessage;
    public $penggunaan = 0, $estimasiBiaya = 0, $hargaPerM3 = 1500;
    public $isLoading = false, $invoiceUrl = null, $showInvoice = false, $existingScan = false;

    const MAX_METER = 100000;

    public function mount($customer)
    {
        $this->customer = Customer::with([
            'latestPembacaanMeters' => function ($query) {
            $query->select('customer_id', 'meter_akhir');
            },
            'golongan' => function ($query) {
            $query->select('id', 'harga');
            }
        ])->findOrFail($customer);
        $this->customerId = $this->customer->id;

        $this->existingScan = PembacaanMeter::where('customer_id', $this->customerId)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->exists();

        $this->hargaPerM3 = $this->customer->golongan->harga ?? 1500;
    }

    public function calculateEstimates()
    {
        if (!$this->meterAkhir) {
            $this->penggunaan = 0;
            $this->estimasiBiaya = 0;
            return;
        }

        $meterAwal = $this->customer->latestPembacaanMeters?->meter_akhir ?? 0;

        $this->penggunaan = $this->meterAkhir >= $meterAwal
            ? $this->meterAkhir - $meterAwal
            : (self::MAX_METER - $meterAwal) + $this->meterAkhir;

        $this->estimasiBiaya = $this->penggunaan * $this->hargaPerM3;
    }

    public function submit()
    {
        $this->validate([
            'meterAkhir' => [
                'required',
                'numeric',
                'min:0',
                'max:' . self::MAX_METER,
                function ($attribute, $value, $fail) {
                    $meterAwal = $this->customer->latestPembacaanMeters?->meter_akhir ?? 0;
                    $isReset = ($meterAwal + $value) > self::MAX_METER;

                    if ($value < $meterAwal && !$isReset) {
                        $fail("Meter akhir tidak valid. Jika reset meter, pastikan total melebihi " . self::MAX_METER);
                    }
                }
            ]
        ]);

        $this->isLoading = true;
        $this->errorMessage = null;
        $this->successMessage = null;

        try {
            if (!$this->existingScan) {
                $data = PembacaanMeter::create([
                    'customer_id' => $this->customerId,
                    'meter_awal' => $this->customer->latestPembacaanMeters?->meter_akhir ?? 0,
                    'meter_akhir' => $this->meterAkhir,
                    'pemakaian' => $this->penggunaan,
                    'total' => $this->estimasiBiaya,
                ]);
            } else {
                return $this->errorMessage = 'Customer ini sudah discan untuk bulan ini';
            }

            $this->invoiceUrl = route('api.invoice', $data->id);
            $this->showInvoice = true;
            Log::debug('API Response: ', $data->toArray());
        } catch (\Exception $e) {
            $this->errorMessage = $e->getMessage();
        }
    }

    public function closeInvoice()
    {
        $this->reset(['showInvoice', 'invoiceUrl', 'meterAkhir']);
        $this->successMessage = 'Pembacaan meter berhasil disimpan';
        return $this->redirect('/scan', navigate: true);
    }

    public function render()
    {
        return view('livewire.front.hitung');
    }
}
