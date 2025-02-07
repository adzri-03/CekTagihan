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

        $customer = Customer::find($decodedText);

        if ($customer) {
            session()->flash('message', 'Pelanggan ditemukan: ' . $customer->name);
            $this->dispatchBrowserEvent('qr-scanned-success', ['url' => route('front.hitung', ['customerId' => $customer->id])]);
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
