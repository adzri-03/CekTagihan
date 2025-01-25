<?php

namespace App\Livewire\Components;

use Livewire\Component;

class MenuBar extends Component
{
    public $activeMenu = 'home';

    public $menus = [
        [
            'name' => 'Hitung',
            'icon' => 'scan.png',
            'route' => 'front.scan',
        ]
    ];

    public function setActiveMenu($menu)
    {
        $this->activeMenu = $menu;
    }

    public function render()
    {
        return view('livewire.components.menu-bar');
    }
}
