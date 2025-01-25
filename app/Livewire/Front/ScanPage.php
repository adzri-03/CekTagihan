<?php

namespace App\Livewire\Front;

use App\Models\Customer;
use Livewire\Component;

class ScanPage extends Component
{
    public $customerId;

    public function customers()
    {
        return Customer::all();
    }

    public function handleScanSuccess($decodedText)
    {
        $this->customerId = $decodedText;

        return redirect()->route('front.hitung', ['customerId' => $this->customerId]);
    }

    public function render()
    {
        return view('livewire.front.scan-page', [
            'customers' => $this->customers()
        ]);
    }
}
