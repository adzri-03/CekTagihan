<?php

namespace App\Livewire\Front;

use App\Models\Customer;
use Livewire\Component;

class ScanPage extends Component
{
    public $customer;

    protected $listeners = ['handleScanSuccess'];

    public function handleScanSuccess($decodedText)
{
    info('QR Code scanned: ' . $decodedText); // Debug log

    $data = json_decode($decodedText, true);

    if (!$data || !isset($data['id'])) {
        session()->flash('error', 'Format QR Code tidak valid!');
        $this->dispatchBrowserEvent('qr-scanned-fail', ['message' => 'Format QR Code tidak valid!']);
        return;
    }

    $customer = Customer::find($data['id']);

    if ($customer) {
        session()->flash('message', 'Pelanggan ditemukan: ' . $customer->nama);
        $this->dispatchBrowserEvent('qr-scanned-success', ['url' => route('front.hitung', ['customer' => $customer->id])]);
    } else {
        session()->flash('error', 'Pelanggan tidak ditemukan!');
        $this->dispatchBrowserEvent('qr-scanned-fail', ['message' => 'Pelanggan tidak ditemukan!']);
    }
}

    public function render()
    {
        return view('livewire.front.scan-page', [
            'customers' => Customer::all(), 
            'selectedCustomer' => $this->customer
        ]);
    }
}
