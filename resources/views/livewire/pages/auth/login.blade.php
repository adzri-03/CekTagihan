<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Filament\Notifications\Notification;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        // Regenerate session
        Session::forget('url.intended');
        Session::regenerate();

        $user = auth()->user();

        // Notifikasi login berhasil
        Notification::make()
            ->title('Login berhasil!')
            ->success()
            ->send();

        // Redirect berdasarkan role
        match ($user->role) {
            'staff' => $this->redirect(route('front.index'), navigate: true),
            'admin' => $this->redirect(url('/admin'), navigate: true),
            default => $this->redirect(route('front.index'), navigate: true),
        };
    }
};
?>

<div class="card-login p-8 shadow-md w-[450px]">
    <div class="flex flex-col items-center">
        <img src="{{ asset('assets/icons/meteran.png') }}" class="w-24 h-24" alt="PDAM Logo">
        <h2 class="text-xl font-semibold mt-5 mb-10 text-gray-700">Halaman login Untuk Petugas</h2>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-6">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full" type="email"
                name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2 text-red-500" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full" type="password"
                name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-red-500" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input wire:model="form.remember" id="remember" type="checkbox"
                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" name="remember">
            <label for="remember" class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</label>
        </div>

        <!-- Login Button -->
        <div class="flex justify-between items-center">
            @if (Route::has('password.request'))
                <a class="text-sm text-indigo-600 hover:text-indigo-800" href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="bg-indigo-600 text-white hover:bg-indigo-700 px-4 py-2 rounded-lg">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <!-- Register Button -->
        <div class="text-center mt-4">
            <button type="button" class="text-sm text-gray-700 hover:text-gray-900"
                onclick="window.location.href='{{ route('register') }}'">
                {{ __('Create an account') }}
            </button>
        </div>
    </form>
</div>
