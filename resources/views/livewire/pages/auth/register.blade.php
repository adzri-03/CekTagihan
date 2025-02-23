<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $validated['status'] = 0;

        event(new Registered($user = User::create($validated)));

        session()->flash('status', 'Akun anda telah terdaftar, menunggu untuk diaktivasi oleh admin.');

        $this->redirect(route('login', absolute: false), navigate: true);
    }
}; ?>

<section id="content" class="max-w-[640px] w-full min-h-screen mx-auto flex flex-col bg-white overflow-x-hidden relative">
    <div class="w-full h-[303px] flex shrink-0 overflow-hidden">
        <img src="{{ asset('assets/images/bg-login.png') }}" class="w-full h-full object-cover" alt="background" loading="lazy">
    </div>
    <form wire:submit="register" class="flex flex-col justify-between flex-1 px-[18px] pt-8 pb-6">
        <div class="flex flex-col gap-5">
            <div class="flex flex-col gap-1 items-center justify-center text-center">
                <img src="{{ asset('assets/icons/meteran.png') }}" class="w-24 h-24" alt="PDAM Logo">
                <h1 class="font-semibold text-2xl leading-[36px]">Halaman Register</h1>
                <p class="font-medium text-sm leading-[21px] text-[#757C98]">Join us today!</p>
            </div>
            <div class="flex flex-col gap-6">
                <!-- Name -->
                <div class="input-container flex flex-col gap-2">
                    <p class="font-medium text-sm leading-[21px]">Name</p>
                    <input wire:model="name" id="name" class="appearance-none outline-none w-full bg-white border border-[#DCDFE6] rounded-lg p-3 placeholder:text-[#757C98] placeholder:font-medium text-sm font-semibold" type="text" name="name" placeholder="Enter your name" required autofocus autocomplete="name">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Email -->
                <div class="input-container flex flex-col gap-2">
                    <p class="font-medium text-sm leading-[21px]">Email Address</p>
                    <input wire:model="email" id="email" class="appearance-none outline-none w-full bg-white border border-[#DCDFE6] rounded-lg p-3 placeholder:text-[#757C98] placeholder:font-medium text-sm font-semibold" type="email" name="email" placeholder="example@gmail.com" required autocomplete="username">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Password -->
                <div class="input-container flex flex-col gap-2">
                    <p class="font-medium text-sm leading-[21px]">Password</p>
                    <input wire:model="password" id="password" class="appearance-none outline-none w-full bg-white border border-[#DCDFE6] rounded-lg p-3 placeholder:text-[#757C98] placeholder:font-medium text-sm font-semibold" type="password" name="password" placeholder="Enter your password" required autocomplete="new-password">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Confirm Password -->
                <div class="input-container flex flex-col gap-2">
                    <p class="font-medium text-sm leading-[21px]">Confirm Password</p>
                    <input wire:model="password_confirmation" id="password_confirmation" class="appearance-none outline-none w-full bg-white border border-[#DCDFE6] rounded-lg p-3 placeholder:text-[#757C98] placeholder:font-medium text-sm font-semibold" type="password" name="password_confirmation" placeholder="Confirm your password" required autocomplete="new-password">
                    @error('password_confirmation')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <button type="submit" class="!bg-[#4041DA] p-[12px_24px] h-12 flex items-center gap-3 rounded-lg justify-center">
                <p class="font-semibold text-sm leading-[21px] text-white">Register</p>
            </button>
        </div>
        <p class="font-medium text-sm leading-[21px] text-[#757C98] text-center mt-3">Already have an account? <a href="{{ route('login') }}" class="font-semibold text-[#4041DA]">Sign In</a></p>
    </form>
</section>
