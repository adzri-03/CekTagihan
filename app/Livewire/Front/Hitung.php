<?php

namespace App\Livewire\Front;

use Livewire\Component;

class Hitung extends Component
{
    public $customerId;

    public function mount($customerId)
    {
        $this->customerId = $customerId;
    }

    public function render()
    {
        return view('livewire.form-page');
    }
}
