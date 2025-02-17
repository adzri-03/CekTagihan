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

        if ($customerId) {
            $this->history = PembacaanMeter::with('customer')
                ->where('customer_id', $customerId)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Jika tidak ada customerId, ambil semua history
            $this->history = PembacaanMeter::with('customer')
                ->latest()
                ->get();
        }
    }

    public function render()
    {
        return view('livewire.front.history', [
            'history' => $this->history,
            'customerId' => $this->customerId
        ]);
    }
}
