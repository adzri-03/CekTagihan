<?php

namespace App\Livewire\Front;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use App\Models\Customer;

class Hitung extends Component
{
    public $customerId;
    public $meterAwal;
    public $meterAkhir;
    public $pemakaian;
    public $total;
    public $isFormVisible = false;
    public $responseMessage;

    protected $listeners = [
        'scanSuccess' => 'handleScanSuccess'
    ];

    public function handleScanSuccess($decodedText)
    {
        // Ambil data dari QR code
        $this->customerId = $decodedText;

        // Cari data customer berdasarkan ID
        $customer = Customer::findOrFail($this->customerId);

        // Masukkan data ke dalam properti
        $this->meterAwal = $customer->meter_awal;
        $this->isFormVisible = true;
    }

    public function submitForm()
    {
        // Validasi input
        $validated = $this->validate([
            'customerId' => 'required|exists:customers,id',
            'meterAkhir' => 'required|integer',
        ]);

        try {
            // Kirim data ke API
            $response = Http::post(route('api.hitung'), [
                'customer_id' => $this->customerId,
                'meter_akhir' => $this->meterAkhir,
            ]);

            $response->throw(); // Lempar error jika gagal

            // Ambil hasil dari API jika diperlukan
            $this->pemakaian = $response->json('pemakaian');
            $this->total = $response->json('total');

            $this->responseMessage = 'Data berhasil disimpan!';
        } catch (\Exception $e) {
            $this->responseMessage = 'Data gagal disimpan: ' . $e->getMessage();
        }
    }

    public function render()
    {
        return view('livewire.front.hitung')->layout('layouts.master');
    }
}
