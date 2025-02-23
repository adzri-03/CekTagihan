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

<section id="content" class="max-w-[640px] w-full min-h-screen mx-auto flex flex-col bg-white overflow-x-hidden relative">
    <div class="w-full h-[303px] flex shrink-0 overflow-hidden">
        <img src="{{ asset('assets/images/bg-login.png') }}" class="w-full h-full object-cover" alt="background" loading="lazy">
    </div>
    <form wire:submit="login" class="flex flex-col justify-between flex-1 px-[18px] pt-8 pb-6">
        <div class="flex flex-col gap-5">
            <div class="flex flex-col gap-1 items-center justify-center text-center">
                <img src="{{ asset('assets/icons/meteran.png') }}" class="w-24 h-24" alt="PDAM Logo">
                <h1 class="font-semibold text-2xl leading-[36px]">Login Page </h1>
                <p class="font-medium text-sm leading-[21px] text-[#757C98]">Excited to have you on board!</p>
            </div>
            <div class="flex flex-col gap-6">
                <div class="input-container flex flex-col gap-2">
                    <p class="font-medium text-sm leading-[21px]">Email Address</p>
                    <input wire:model="form.email" id="email" class="appearance-none outline-none w-full bg-white border border-[#DCDFE6] rounded-lg p-3 placeholder:text-[#757C98] placeholder:font-medium text-sm font-semibold" type="email" name="email" placeholder="example@gmail.com" required>
                    @error('form.email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="input-container flex flex-col gap-2">
                    <p class="font-medium text-sm leading-[21px]">Password</p>
                    <input wire:model="form.password" id="password" class="appearance-none outline-none w-full bg-white border border-[#DCDFE6] rounded-lg p-3 placeholder:text-[#757C98] placeholder:font-medium text-sm font-semibold" type="password" name="password" placeholder="Enter your password" required>
                </div>
                <div class="flex items-center justify-between mt-1">
                    <label class="font-medium text-sm leading-[21px] text-[#757C98] flex items-center gap-[6px]">
                        <input wire:model="form.remember" type="checkbox" id="remember" class="w-5 h-5 appearance-none checked:border-2 checked:border-solid checked:border-white rounded-md checked:bg-[#4041DA] ring-1 ring-[#757C98] transition-all duration-300">
                        <span class="peer-checked:text-[#070625] transition-all duration-300">Remember me</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="font-medium text-sm leading-[21px] text-[#757C98]">Forgot Password?</a>
                </div>
            </div>
            <button type="submit" class="!bg-[#4041DA] p-[12px_24px] h-12 flex items-center gap-3 rounded-lg justify-center">
                <p class="font-semibold text-sm leading-[21px] text-white">Sign In</p>
            </button>
        </div>
        <p class="font-medium text-sm leading-[21px] text-[#757C98] text-center mt-3">Don’t have an account? <a href="{{ route('register') }}" class="font-semibold text-[#4041DA]">Create Account</a></p>
    </form>
</section>
