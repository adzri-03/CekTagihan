<?php

namespace App\Livewire\Front;

use Livewire\Component;
use App\Models\PembacaanMeter;

class History extends Component
{
    public $customerId;
    public $history;

    public function mount($customerId = null)
    {
        $this->customerId = $customerId;

        $this->history = PembacaanMeter::where('customer_id', $customerId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.front.history', [
            'customerId' => $this->customerId
        ]);
    }
}
