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
    public $isLoading = false, $invoiceUrl = null, $showInvoice = false;

    const MAX_METER = 100000;

    public function mount($customer)
    {
        $this->customerId = $customer;
        $this->customer = Customer::with(['latestPembacaanMeters', 'golongan'])
            ->findOrFail($customer);

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
            $data = PembacaanMeter::create([
                'customer_id' => $this->customerId,
                'meter_awal' => $this->customer->latestPembacaanMeters?->meter_akhir ?? 0,
                'meter_akhir' => $this->meterAkhir,
                'pemakaian' => $this->penggunaan,
                'total' => $this->estimasiBiaya,
            ]);

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
        return $this->redirect('/scan-page', navigate: true);
    }

    public function render()
    {
        return view('livewire.front.hitung');
    }
}
