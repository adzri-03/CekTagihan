<div class="max-w-lg mx-auto p-6">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Form Pengisian Meter</h2>

        {{-- Customer Info Card --}}
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Nama Pelanggan</p>
                    <p class="font-semibold">{{ $customer->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Kode PAM</p>
                    <p class="font-semibold">{{ $customer->pam_code }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-sm text-gray-600">Alamat</p>
                    <p class="font-semibold">{{ $customer->address }}</p>
                </div>
            </div>
        </div>

        {{-- Alert Messages --}}
        @if ($errorMessage)
            <div class="mb-4 p-4 bg-red-50 text-red-800 rounded-lg flex items-start">
                <svg class="w-5 h-5 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ $errorMessage }}</span>
            </div>
        @endif

        @if ($successMessage)
            <div class="mb-4 p-4 bg-green-50 text-green-800 rounded-lg flex items-start">
                <svg class="w-5 h-5 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>{{ $successMessage }}</span>
            </div>
        @endif

        <form wire:submit.prevent="submit" class="space-y-4">
            {{-- Meter Awal --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Meter Awal
                </label>
                <input type="number" value="{{ $customer->latestPembacaanMeters?->meter_akhir ?? 0 }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50" disabled>
            </div>

            {{-- Meter Akhir --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Meter Akhir
                </label>
                <input type="number" wire:model.live.debounce.500ms="meterAkhir" wire:change="calculateEstimates"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    min="0" max="100000" required>
                @error('meterAkhir')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            {{-- Estimasi Penggunaan --}}
            <div class="bg-blue-50 p-4 rounded-lg">
                <h3 class="font-semibold text-blue-800 mb-2">Estimasi Penggunaan</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-600">Pemakaian</p>
                        <p class="font-semibold">{{ number_format($penggunaan) }} m³</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Biaya</p>
                        <p class="font-semibold">Rp {{ number_format($estimasiBiaya, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            {{-- Submit Button --}}
            <button type="submit" wire:loading.attr="disabled"
                class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center">
                <span wire:loading wire:target="submit" class="mr-2">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </span>
                <span wire:loading.remove wire:target="submit">Simpan Pembacaan</span>
                <span wire:loading wire:target="submit">Menyimpan...</span>
            </button>
        </form>
    </div>

    {{-- Modal Invoice --}}
    @if ($showInvoice)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
            <div class="bg-white rounded-lg w-[95%] max-w-[300px]">
                <div class="flex items-center justify-between p-3 border-b">
                    <h2 class="text-lg font-semibold">Invoice Pembayaran</h2>
                    <button wire:click="closeInvoice" class="text-gray-500 hover:text-gray-700">
                        ✕
                    </button>
                </div>

                <div class="p-3">
                    <iframe
                        src="{{ $invoiceUrl }}"
                        class="w-full h-64"
                        style="transform: scale(0.8); transform-origin: 0 0; width: 125%; height: 300px"
                    ></iframe>
                </div>

                <div class="flex justify-between p-3 bg-gray-50">
                    <button wire:click="closeInvoice" class="text-sm px-3 py-1.5 bg-gray-100 rounded">
                        Tutup
                    </button>
                    <a href="{{ $invoiceUrl }}" target="_blank"
                       class="text-sm px-3 py-1.5 bg-blue-600 text-white rounded">
                        Download
                    </a>
                </div>
            </div>
        </div>
    @endif
    @if ($errorMessage)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                <h2 class="text-lg font-bold mb-4 text-red-600">Terjadi Kesalahan</h2>
                <p class="text-sm text-gray-700">{{ $errorMessage }}</p>
                <div class="flex justify-end mt-4">
                    <button wire:click="$set('errorMessage', null)" class="px-4 py-2 bg-red-500 text-white rounded">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
