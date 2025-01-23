@extends('layouts.master')
@section('content')
    <section id="content"
        class="max-w-[640px] w-full min-h-screen mx-auto flex flex-col bg-[#F8F8F8] overflow-x-hidden pb-[122px] relative">
        <header class="relative h-[376px] flex justify-center overflow-hidden -mb-[106px]">
            <!-- SVG sebagai background -->
            <div class="absolute w-full h-full z-0">
                <svg viewBox="0 0 440 133" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M-39.1334 0H503.818V35.7855C398.168 25.0381 371.174 32.2669 274.298 55.5292C160.171 92.5945 69.8167 93.463 -39.1334 87.6127V0Z"
                        fill="#2C499B" />
                    <path
                        d="M289.106 132.653C183.6 137.589 149.049 88.2297 149.049 88.2297C272.707 99.0094 35.66 111.562 149.049 88.2297C160.772 77.7409 155.415 75.5749 282.936 81.4428C330.549 82.3797 519.488 68.4857 562.433 82.6769C480.879 126.21 394.611 127.717 289.106 132.653Z"
                        fill="#B0D137" />
                    <path
                        d="M31.2035 108.591L109.561 93.1658C127.043 91.3148 162.376 87.6129 163.857 87.6129C165.337 87.6129 169.821 76.507 171.877 70.9541C171.877 70.9541 113.745 82.8979 67.606 82.6769C21.4665 82.456 -2.55793 79.1526 -44.0693 70.9541V98.7187L31.2035 108.591Z"
                        fill="#B0D137" />
                    <path
                        d="M314.402 130.802C208.904 141.794 -227.933 100.569 -227.933 100.569L-227.933 64.6763C-104.274 75.456 -38.0143 118.808 75.3745 95.4759C208.955 58.299 311.513 34.8535 439.034 40.7214C486.647 41.6583 511.467 47.5079 554.412 61.6991C472.858 105.232 419.901 119.81 314.402 130.802Z"
                        fill="#3CBEEE" />
                </svg>
            </div>

            <!-- Ikon -->
            <div class="absolute top-10 right-10 flex gap-4 z-10">
                <!-- User Icon -->
                <a href="#">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-md">
                        <img src="https://img.icons8.com/ios-filled/50/null/user.png" alt="User Icon" class="w-5 h-5"
                            aria-label="User">
                    </div>
                </a>
                <!-- Notification Icon -->
                <a href="#">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-md">
                        <img src="https://img.icons8.com/ios-filled/50/null/bell.png" alt="Notification Icon"
                            class="w-5 h-5" aria-label="Notifications">
                    </div>
                </a>
            </div>
        </header>

        <div id="Feature" class="px-[18px] relative z-10">
            <div class="bg-white p-[18px_16px] rounded-xl overflow-hidden grid grid-cols-4 gap-[27px]">
                <a href="{{ route('front.hitung') }}">
                    <div class="flex flex-col items-center gap-2">
                        <div class="w-[35px] h-[35px] flex shrink-0">
                            <img src="https://img.icons8.com/?size=100&id=cX0dPS0YEepJ&format=png&color=000000" class="object-cover" alt="icon">
                        </div>
                        <p class="font-medium text-sm text-[#757C98] leading-[21px]">Hitung</p>
                    </div>
                </a>
            </div>
        </div>
        {{-- <div id="Menu-bar" class="fixed bottom-[24px] px-[18px] max-w-[640px] w-full z-30">
            <div
                class="bg-white p-[14px_12px] rounded-full flex items-center justify-center gap-8 shadow-[0_8px_30px_0_#0A093212]">
                <a href="{{ route('front.index')}}">
                    <div class="flex flex-col gap-1 items-center">
                        <div class="w-6 h-6 flex shrink-0">
                            <img src="assets/images/icons/home-active.svg" alt="icon">
                        </div>
                        <p class="text-xs leading-[18px] font-semibold text-[#4041DA]">Home</p>
                    </div>
                </a>
                <a href="">
                    <div class="flex flex-col gap-1 items-center">
                        <div class="w-6 h-6 flex shrink-0">
                            <img src="assets/images/icons/search-nonactive.svg" alt="icon">
                        </div>
                        <p class="text-xs leading-[18px] font-medium text-[#757C98]">Search</p>
                    </div>
                </a>
                <a href="{{ route('front.hitung') }}">
                    <div class="flex flex-col gap-1 items-center">
                        <div class="w-6 h-6 flex shrink-0">
                            <img src="https://img.icons8.com/?size=100&id=cX0dPS0YEepJ&format=png&color=000000" alt="icon">
                        </div>
                        <p class="text-xs leading-[18px] font-medium text-[#757C98]">Hitung</p>
                    </div>
                </a>
                <a href="">
                    <div class="flex flex-col gap-1 items-center">
                        <div class="w-6 h-6 flex shrink-0">
                            <img src="assets/images/icons/activity-nonactive.svg" alt="icon">
                        </div>
                        <p class="text-xs leading-[18px] font-medium text-[#757C98]">Activity</p>
                    </div>
                </a>
                <a href="">
                    <div class="flex flex-col gap-1 items-center">
                        <div class="w-6 h-6 flex shrink-0">
                            <img src="assets/images/icons/settings-nonactive.svg" alt="icon">
                        </div>
                        <p class="text-xs leading-[18px] font-medium text-[#757C98]">Settings</p>
                    </div>
                </a>
            </div>
        </div> --}}
        @livewire('components.menu-bar')
    </section>
@endsection
