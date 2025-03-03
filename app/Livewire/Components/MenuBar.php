<?php

namespace App\Livewire\Components;

use Livewire\Component;

class MenuBar extends Component
{
    public $activeMenu = ['index', 'scan'];

    public $menus = [
        [
            'name' => 'Home',
            'icon' => 'home.png',
            'route' => 'front.index',
        ],
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
