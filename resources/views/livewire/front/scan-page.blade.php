@extends('layouts.master')

@section('content')
    <section id="content"
        class="max-w-[640px] w-full min-h-screen mx-auto flex flex-col bg-[#F8F8F8] overflow-x-hidden pb-[122px] relative">
        <div class="mx-4 my-4">
            <!-- Halaman Utama -->
            <h2 class="text-lg font-bold">Daftar Pelanggan</h2>
            <div class="overflow-x-auto">
                <table class="w-full border border-collapse zebra">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>No. Handphone</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customers as $customer)
                            <tr>
                                <td>{{ $customer->id }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->address }}</td>
                                <td>{{ $customer->phone }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">No customers found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Tombol untuk Scanner -->
            <div id="Menu-bar" class="fixed bottom-[24px] w-full flex justify-center items-center z-30">
                <div
                    class="p-3 bg-blue-500 hover:bg-blue-600 text-white rounded-full shadow-lg transition-all transform hover:scale-105">
                    <button onclick="openModal()" class="w-[32px]" aria-label="Mulai Scanner">
                        <img src="{{ asset('assets/icons/qr-code.png') }}" alt="">
                    </button>
                </div>
            </div>

            <!-- Modal Scanner -->
            <div id="scannerModal"
                class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 z-50 flex items-end sm:items-center justify-center">
                <!-- Modal Content -->
                <div
                    class="relative w-full sm:w-[500px] bg-white rounded-t-lg sm:rounded-lg shadow-xl transition-transform transform">
                    <!-- Close Button -->
                    <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-600 hover:text-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <!-- Modal Body -->
                    <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="text-center">
                            <h3 class="text-lg font-bold text-gray-900">Scan QR Code</h3>
                            <div class="mt-4 flex justify-center">
                                <!-- Scanner Reader -->
                                <div id="reader"
                                    class="w-full max-w-[350px] h-[350px] border border-gray-300 rounded-md"></div>
                            </div>
                            <p id="scan-error-message" class="text-red-500 text-sm mt-2 hidden">Error Message</p>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="bg-gray-50 px-4 py-3 flex justify-between items-center">
                        <p id="loading-spinner" class="text-blue-500 font-medium hidden">Menginisialisasi kamera...</p>
                        <button onclick="closeModal()" type="button"
                            class="inline-flex justify-center rounded-md bg-red-500 text-white px-3 py-2 text-sm font-semibold hover:bg-red-600">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        let html5QrCode = null;

        function openModal() {
            const modal = document.getElementById('scannerModal')
            modal.classList.remove('hidden')
            startScanner()
        }

        function closeModal() {
            const modal = document.getElementById('scannerModal')
            modal.classList.add('hidden')
            stopScanner()
        }

        // Fungsi untuk memulai scanner
        async function startScanner() {
            // Hentikan scanner jika sudah berjalan
            if (html5QrCode) {
                await html5QrCode.stop();
            }

            // Inisialisasi scanner
            html5QrCode = new Html5Qrcode("reader");
            const config = {
                fps: 10,
                qrbox: {
                    width: 300,
                    height: 300
                },
                showTorchButtonIfSupported: true,
            };

            try {
                const devices = await Html5Qrcode.getCameras(); // Mendapatkan daftar kamera

                if (devices && devices.length > 0) {
                    // Pilih kamera belakang jika tersedia
                    const cameraId = devices.length > 1 ? devices[1].id : devices[0].id;

                    // Mulai scanner
                    await html5QrCode.start(cameraId, config,
                        (decodedText) => {
                            console.log("QR Code detected:", decodedText);

                            // Emit hasil scan ke Livewire
                            Livewire.emit('handleScanSuccess', decodedText);

                            // Hentikan scanner setelah berhasil membaca QR code
                            html5QrCode.stop();
                        },
                        (errorMessage) => {
                            console.log("QR Error:", errorMessage);
                        }
                    );
                } else {
                    console.error("No camera found!");
                    document.getElementById('scan-error-message').innerText = 'Tidak ada kamera yang ditemukan.';
                }
            } catch (err) {
                console.error('Error starting scanner:', err);
                let errorMessage = 'Terjadi kesalahan saat memulai scanner.';

                if (err.name === 'NotAllowedError') {
                    errorMessage = 'Izin kamera ditolak. Mohon izinkan akses kamera dan coba lagi.';
                } else if (err.name === 'NotFoundError') {
                    errorMessage = 'Kamera tidak ditemukan.';
                } else if (err.name === 'NotReadableError') {
                    errorMessage = 'Kamera sedang digunakan oleh aplikasi lain.';
                }

                document.getElementById('scan-error-message').innerText = errorMessage;
            }
        }

        // Fungsi untuk menghentikan scanner
        async function stopScanner() {
            if (html5QrCode) {
                await html5QrCode.stop(); // Hentikan scanner
                html5QrCode = null; // Reset scanner
                document.getElementById('scan-error-message').innerText = 'Scanner telah dihentikan.';
            }
        }
    </script>
@endpush
