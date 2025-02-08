<?php

namespace App\Livewire\Front;

use Livewire\Component;
use App\Models\Customer;

class Hitung extends Component
{
    public $customerId;
    public $customer;

    public function mount($customer)
    {
        $this->customerId = $customer; 
        $this->customer = Customer::find($customer);
    }

    public function render()
    {
        return view('livewire.front.hitung', [
            'customer' => $this->customer,
        ]);
    }
}
