<?php

namespace App\Livewire\Front;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\RiwayatPetugas;
use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $riwayat = [];

    protected $listeners = [
        'refreshRiwayat' => 'loadRiwayat',
    ];

    public function mount()
    {
        $this->loadRiwayat();
    }

    public function loadRiwayat()
    {
        // Ambil data riwayat berdasarkan user yang login
        if (Auth::check()) {
            $this->riwayat = RiwayatPetugas::where('user_id', Auth::id())
                ->latest()
                ->take(5)
                ->get();
        }
    }

    public function logout(Logout $logout)
    {
        $logout();
        $this->redirect('/', navigate: true);
    }

    public function getGreeting()
    {
        $hour = Carbon::now()->hour;

        if ($hour >= 5 && $hour < 12) {
            return 'Selamat Pagi';
        } elseif ($hour >= 12 && $hour < 15) {
            return 'Selamat Siang';
        } elseif ($hour >= 15 && $hour < 18) {
            return 'Selamat Sore';
        } else {
            return 'Selamat Malam';
        }
    }

    public function render()
    {
        return view('livewire.front.index', [
            'greeting' => $this->getGreeting(),
            'currentDate' => Carbon::now()->isoFormat('dddd, D MMMM Y'),
            'userName' => Auth::check() ? Auth::user()->name : '',
            'riwayat' => $this->riwayat
        ]);
    }
}
