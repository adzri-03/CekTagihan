<div>
    <section id="content" class="max-w-[640px] w-full min-h-screen mx-auto flex flex-col bg-gradient-to-b from-gray-50 to-white overflow-x-hidden pb-[122px] relative">
        <!-- SVG Background remains the same -->
        <div class="absolute w-full h-full inset-0 z-0 opacity-90">
            <svg viewBox="0 0 440 133" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="headerGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#2C499B;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#1a337d;stop-opacity:1" />
                    </linearGradient>
                    <linearGradient id="accentGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" style="stop-color:#B0D137;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#9ab82f;stop-opacity:1" />
                    </linearGradient>
                </defs>
                <path
                    d="M-39.1334 0H503.818V35.7855C398.168 25.0381 371.174 32.2669 274.298 55.5292C160.171 92.5945 69.8167 93.463 -39.1334 87.6127V0Z"
                    fill="url(#headerGradient)" />
                <path
                    d="M289.106 132.653C183.6 137.589 149.049 88.2297 149.049 88.2297C272.707 99.0094 35.66 111.562 149.049 88.2297C160.772 77.7409 155.415 75.5749 282.936 81.4428C330.549 82.3797 519.488 68.4857 562.433 82.6769C480.879 126.21 394.611 127.717 289.106 132.653Z"
                    fill="url(#accentGradient)" />
                <path
                    d="M31.2035 108.591L109.561 93.1658C127.043 91.3148 162.376 87.6129 163.857 87.6129C165.337 87.6129 169.821 76.507 171.877 70.9541C171.877 70.9541 113.745 82.8979 67.606 82.6769C21.4665 82.456 -2.55793 79.1526 -44.0693 70.9541V98.7187L31.2035 108.591Z"
                    fill="url(#accentGradient)" class="opacity-80" />
                <path
                    d="M314.402 130.802C208.904 141.794 -227.933 100.569 -227.933 100.569L-227.933 64.6763C-104.274 75.456 -38.0143 118.808 75.3745 95.4759C208.955 58.299 311.513 34.8535 439.034 40.7214C486.647 41.6583 511.467 47.5079 554.412 61.6991C472.858 105.232 419.901 119.810 314.402 130.802Z"
                    fill="#3CBEEE" class="opacity-80" />
            </svg>
        </div>

        <header class="relative h-[320px] sm:h-[376px] flex flex-col justify-start overflow-hidden -mb-[106px] z-10">
            <!-- Greeting Section -->
            <div class="absolute left-0 right-0 flex flex-col items-center text-white pb-4 z-10 mt-12 sm:mt-16">
                <h1 class="text-2xl sm:text-3xl font-bold mb-2 text-shadow">
                    <span class="greeting">{{ $greeting }}, </span>
                    {{ $userName }}
                </h1>
                <p class="text-base sm:text-lg font-medium opacity-90 text-shadow">{{ $currentDate }}</p>
            </div>

            <!-- Header Icons -->
            <div class="absolute top-4 sm:top-10 right-4 sm:right-6 flex gap-3 sm:gap-4 z-10">
                <!-- User Profile Dropdown -->
                <div class="relative" x-data="{ isOpen: false }">
                    <button @click="isOpen = !isOpen" @click.away="isOpen = false"
                            class="w-10 h-10 sm:w-12 sm:h-12 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-200 hover:scale-105"
                            aria-label="Profil User">
                        <img src="https://img.icons8.com/ios-filled/50/null/user.png" alt="User Icon" class="w-5 h-5 sm:w-6 sm:h-6 opacity-70">
                    </button>

                    <div x-show="isOpen"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-40 sm:w-48 bg-white rounded-xl shadow-lg py-2 z-50">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                        <hr class="my-2">
                        <button wire:click="logout" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                            Logout
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <div id="Feature" class="px-4 sm:px-6 relative z-10">
            <div class="bg-white/90 backdrop-blur-sm p-4 sm:p-6 rounded-2xl shadow-xl">
                <!-- Quick Actions -->
                <div class="mb-5 sm:mb-6">
                    <h2 class="text-bas sm:text-lg font-semibold text-gray-800 mb-3 sm:mb-4">Menu Cepat</h2>
                    <div class="grid grid-cols-3 gap-2 sm:gap-8">
                        <a href="{{ route('front.scan') }}"
                           class="group relative flex flex-col items-center gap-2 sm:gap-3 p-2 sm:p-4 rounded-xl transition-all duration-200 hover:bg-gray-50"
                           wire:navigate>
                            <div class="w-[35px] h-[35px] sm:w-[45px] sm:h-[45px] flex shrink-0 group-hover:scale-110 transition-transform duration-200">
                                <img src="{{ asset('assets/icons/scan.png') }}"
                                     class="object-cover filter group-hover:brightness-110" alt="icon">
                            </div>
                            <p class="font-medium text-xs sm:text-sm text-[#505780] leading-tight sm:leading-[21px] group-hover:text-[#2C499B] transition-colors duration-200 text-center">
                                Hitung
                            </p>
                        </a>
                        <a href="{{ route('front.history') }}"
                           class="group relative flex flex-col items-center gap-2 sm:gap-3 p-2 sm:p-4 rounded-xl transition-all duration-200 hover:bg-gray-50"
                           wire:navigate>
                            <div class="w-[35px] h-[35px] sm:w-[45px] sm:h-[45px] flex shrink-0 group-hover:scale-110 transition-transform duration-200">
                                <img src="{{ asset('assets/icons/history.png') }}"
                                     class="object-cover filter group-hover:brightness-110" alt="icon">
                            </div>
                            <p class="font-medium text-xs sm:text-sm text-[#505780] leading-tight sm:leading-[21px] group-hover:text-[#2C499B] transition-colors duration-200 text-center">
                                Riwayat
                            </p>
                        </a>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="mt-6 sm:mt-8">
                    <h2 class="text-base sm:text-lg font-semibold text-gray-800 mb-3 sm:mb-4">Aktivitas Terakhir</h2>
                    <div class="space-y-3 sm:space-y-4">
                        @forelse($riwayat as $index => $riwayat)
                            <div wire:key="riwayat-{{ $riwayat['id'] }}"
                                 class="flex items-center p-2 sm:p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-150">
                                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3 sm:mr-4 flex-shrink-0">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                        </path>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs sm:text-sm font-medium text-gray-800 truncate">{{ $riwayat['jenis_tindakan'] }}</p>
                                    <p class="text-2xs sm:text-xs text-gray-500">{{ \Carbon\Carbon::parse($riwayat['created_at'])->diffForHumans() }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-xs sm:text-sm text-gray-500 text-center py-3 sm:py-4">
                                Belum ada aktivitas
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        @livewire('components.menu-bar')
    </section>
</div>
