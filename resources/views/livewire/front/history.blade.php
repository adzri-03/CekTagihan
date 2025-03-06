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

        <header class="relative h-[376px] flex flex-col justify-start overflow-hidden -mb-[106px] z-10">
            <!-- Greeting Section -->
            <div class="absolute left-0 right-0 flex flex-col items-center text-white pb-4 z-10 mt-16">
                <h1 class="text-3xl font-bold mb-2 text-shadow">
                    <span> History </span>
                </h1>

            </div>

            <!-- Header Icons -->
            
    
        </header>

         <!-- Main Content -->
  
        <div id="Feature" class="px-6 relative z-10" x-data="{ openModal: false, invoiceData: null }">
            <div class="top-menu flex justify-between items-center my-0 ml-7">
                <a href="{{ route('front.index') }}" class="flex items-center space-x-2">
                <div class="w-[48px] h-[48px] flex shrink-0">
                    <img src="assets/icons/back.svg" alt="icon">
                </div>
                <span class="text-lg font-semibold text-gray-500 hover:text-gray-900 transition-colors">Kembali</span>
                </a>
            </div>

            <div class="bg-white/90 backdrop-blur-sm p-6 rounded-2xl shadow-xl">
                <h2 class="text-lg font-bold mb-4">Riwayat Pembacaan Meter</h2>

                @if ($history->count() > 0)
                    <div class="overflow-x-auto max-w-full">
                        <table class="min-w-max border border-gray-300 rounded-lg shadow-sm">
                            <thead class="bg-gray-100"
                                <tr>
                                    <th class="border px-4 py-2 text-left text-xm whitespace-nowrap">Tanggal</th>
                                    <th class="border px-4 py-2 text-left text-xm  whitespace-nowrap">Meter Awal</th>
                                    <th class="border px-4 py-2 text-left text-xm  whitespace-nowrap">Meter Akhir</th>
                                    <th class="border px-4 py-2 text-left text-xm  whitespace-nowrap">Pemakaian</th>
                                    <th class="border px-4 py-2 text-left text-xm  whitespace-nowrap">Total Biaya</th>
                                    <th class="border px-4 py-2 text-center text-xm  whitespace-nowrap">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($history as $item)
                                    <tr class="bg-white hover:bg-gray-50">
                                        <td class="border px-4 py-2 text-xm">{{ $item->created_at->format('d M Y') }}</td>
                                        <td class="border px-4 py-2 text-xm">{{ $item->meter_awal }}</td>
                                        <td class="border px-4 py-2 text-xm">{{ $item->meter_akhir }}</td>
                                        <td class="border px-4 py-2 text-xm">{{ $item->pemakaian }} m³</td>
                                        <td class="border px-4 py-2 text-xm">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                                        <td class="border px-4 py-2 text-center text-xm">
                                            <button @click="openModal = true; invoiceData = {{ json_encode($item) }}"
                                                class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold py-2 px-3 rounded-lg shadow">
                                                Lihat Nota
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 text-center">Belum ada riwayat pembacaan meter.</p>
                @endif
            </div>

            <!-- MODAL -->
            <div x-show="openModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-transition>
                <div class="bg-white rounded-lg shadow-lg w-96 p-6 relative">
                    <button @click="openModal = false" class="absolute top-3 right-3 text-gray-500 hover:text-red-500">
                        ✖
                    </button>
                    <h2 class="text-xl font-bold mb-4 text-center">Invoice Pembacaan Meter</h2>
                    
                    <div class="bg-gray-100 p-4 rounded-lg shadow-inner">
                        <p><strong>Tanggal:</strong> <span x-text="invoiceData.created_at"></span></p>
                        <p><strong>Meter Awal:</strong> <span x-text="invoiceData.meter_awal"></span></p>
                        <p><strong>Meter Akhir:</strong> <span x-text="invoiceData.meter_akhir"></span></p>
                        <p><strong>Pemakaian:</strong> <span x-text="invoiceData.pemakaian"></span> m³</p>
                        <p><strong>Total Biaya:</strong> Rp <span x-text="new Intl.NumberFormat('id-ID').format(invoiceData.total)"></span></p>
                    </div>
                    
                    <div class="mt-4 flex justify-between">
                        <button @click="openModal = false"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">Tutup</button>
                        <a :href="'/download-invoice/' + invoiceData.id" target="_blank"
                            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">Download PDF</a>
                    </div>
                </div>
            </div>
        
        @livewire('components.menu-bar')
    </section>
</div>
