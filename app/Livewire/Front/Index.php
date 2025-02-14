<?php

namespace App\Livewire\Front;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\RiwayatPetugas;
use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $notifications = [];
    public $recentActivities = [];
    public $riwayat = [];
    public $notificationCount = 0;

    protected $listeners = [
        'refreshNotifications' => 'loadNotifications',
        'refreshActivities' => 'loadRecentActivities',
        'refreshRiwayat' => 'loadRiwayat',
    ];

    public function mount()
    {
        $this->loadNotifications();
        $this->loadRecentActivities();
        $this->loadRiwayat();
    }

    public function loadNotifications()
    {
        // In a real app, you'd load these from your database
        $this->notifications = [
            [
                'id' => 1,
                'message' => 'Perhitungan selesai',
                'time' => '2 menit yang lalu',
                'read' => false,
                'type' => 'calculation'
            ],
            // Add more notifications as needed
        ];

        $this->notificationCount = collect($this->notifications)
            ->where('read', false)
            ->count();
    }

    public function loadRecentActivities()
    {
        // In a real app, you'd load these from your database
        $this->recentActivities = [
            [
                'id' => 1,
                'action' => 'Perhitungan Selesai',
                'time' => '2 menit yang lalu',
                'icon' => 'calculator'
            ],
            // Add more activities as needed
        ];
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

    public function markNotificationAsRead($notificationId)
    {
        // In a real app, you'd update the database
        $notification = collect($this->notifications)
            ->firstWhere('id', $notificationId);

        if ($notification) {
            $notification['read'] = true;
            $this->notificationCount--;
            $this->dispatch('notification', [
                'message' => 'Notifikasi ditandai sebagai telah dibaca'
            ]);
        }
    }

    public function markAllNotificationsAsRead()
    {
        // In a real app, you'd update the database
        $this->notifications = collect($this->notifications)
            ->map(function ($notification) {
                $notification['read'] = true;
                return $notification;
            })
            ->toArray();

        $this->notificationCount = 0;
        $this->dispatch('notification', [
            'message' => 'Semua notifikasi telah ditandai sebagai dibaca'
        ]);
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
            'userName' => Auth::check() ? Auth::user()->name : 'Tamu',
            'riwayat' => $this->riwayat
        ]);
    }
}
