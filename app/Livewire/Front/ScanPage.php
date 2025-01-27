<?php

namespace App\Livewire\Front;

use App\Models\Customer;
use Livewire\Component;

class ScanPage extends Component
{
    public $customerId;

    protected $listeners = ['handleScanSuccess'];

    public function handleScanSuccess($decodedText)
    {
        info('QR Code scanned: ' . $decodedText); // Debug log
        $this->customerId = $decodedText;
        return redirect()->route('front.hitung', ['customerId' => $this->customerId]);
    }

    public function render()
    {
        return view('livewire.front.scan-page', [
            'customers' => $this->customers()
        ]);
    }

    private function customers()
    {
        return Customer::all();
    }
}
