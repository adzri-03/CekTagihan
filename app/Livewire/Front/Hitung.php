<?php

namespace App\Livewire\Front;

use Livewire\Component;
use App\Models\Customer;

class Hitung extends Component
{
    public $customer;

    public function mount(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function render()
    {
        return view('livewire.front.hitung', [
            'customer' => $this->customer,
        ]);
    }
}
