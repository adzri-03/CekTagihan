@extends('layouts.master')
@section('content')
    <section id="content"
        class="max-w-[640px] w-full min-h-screen mx-auto flex flex-col bg-[#F8F8F8] overflow-x-hidden pb-[122px] relative">
        @forelse ($customers as $customer)
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No. Handphone</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $customer->id }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->address }}</td>
                        <td>{{ $customer->phone }}</td>
                    </tr>
                </tbody>
            </table>
        @empty
            <p>No customers found.</p>
        @endforelse

        <div class="mb-4 relative">
            <h2 class="text-lg font-bold">Scan QR Code</h2>
            <div id="reader" class="mt-4 relative"></div>
            <p id="scan-error-message" class="text-red-500 text-sm"></p>
            <button onclick="startScanner()" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Mulai Scanner
            </button>
            @error('customerId')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <!-- Bagian Form -->
        @if ($isFormVisible)
            <form wire:submit.prevent="submitForm">
                @csrf
                <h2 class="text-lg font-bold">Hitung Pemakaian</h2>

                <div class="mt-4">
                    <label for="meterAwal" class="block">Meter Awal</label>
                    <input type="text" id="meterAwal" wire:model="meterAwal" class="w-full border rounded px-2 py-1"
                        readonly>
                </div>

                <div class="mt-4">
                    <label for="meterAkhir" class="block">Meter Akhir</label>
                    <input type="number" id="meterAkhir" wire:model="meterAkhir" class="w-full border rounded px-2 py-1"
                        required>
                    @error('meterAkhir')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tampilkan hasil perhitungan jika ada -->
                @if ($pemakaian)
                    <div class="mt-4">
                        <label class="block">Pemakaian</label>
                        <p class="font-bold">{{ $pemakaian }} m³</p>
                    </div>
                @endif

                @if ($total)
                    <div class="mt-4">
                        <label class="block">Total Biaya</label>
                        <p class="font-bold">Rp {{ number_format($total, 0, ',', '.') }}</p>
                    </div>
                @endif

                <button type="submit" class="mt-4 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                    Submit
                </button>
            </form>
        @endif

        <!-- Response Message -->
        @if ($responseMessage)
            <div
                class="mt-4 p-4 {{ str_contains($responseMessage, 'berhasil') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} border rounded">
                {{ $responseMessage }}
            </div>
        @endif
    </section>
@endsection

@push('scripts')
    <script>
        let html5QrCode = null;

        async function startScanner() {
            try {
                // Hentikan scanner sebelumnya jika ada
                if (html5QrCode) {
                    await html5QrCode.stop();
                    html5QrCode = null;
                }

                // Initialize QR scanner
                html5QrCode = new Html5Qrcode("reader");

                const config = {
                    fps: 10,
                    qrbox: {
                        width: 250,
                        height: 250
                    },
                    aspectRatio: 1.0,
                    showTorchButtonIfSupported: true
                };

                // Coba dapatkan kamera belakang terlebih dahulu
                const devices = await Html5Qrcode.getCameras();
                console.log("Available cameras:", devices);

                if (devices && devices.length) {
                    // Pilih kamera belakang jika ada
                    const cameraId = devices.length > 1 ? devices[1].id : devices[0].id;

                    try {
                        await html5QrCode.start({
                                facingMode: "environment"
                            }, // Mencoba menggunakan kamera belakang
                            config,
                            (decodedText) => {
                                console.log("QR Code detected:", decodedText);
                                html5QrCode.stop();
                                document.getElementById('scan-error-message').innerText = '';
                                window.livewire.emit('scanSuccess', decodedText);
                            },
                            (errorMessage) => {
                                // Handle error silently
                                console.log("QR Error:", errorMessage);
                            }
                        );

                        document.getElementById('scan-error-message').innerText = 'Scanner aktif, arahkan ke QR Code';
                        console.log("Scanner started successfully");
                    } catch (err) {
                        console.error("Failed to start scanner:", err);
                        // Jika gagal dengan kamera belakang, coba kamera depan
                        await html5QrCode.start({
                                facingMode: "user"
                            },
                            config,
                            (decodedText) => {
                                console.log("QR Code detected:", decodedText);
                                html5QrCode.stop();
                                document.getElementById('scan-error-message').innerText = '';
                                window.livewire.emit('scanSuccess', decodedText);
                            },
                            (errorMessage) => {
                                console.log("QR Error:", errorMessage);
                            }
                        );
                    }
                } else {
                    document.getElementById('scan-error-message').innerText = 'Tidak ada kamera yang ditemukan';
                }
            } catch (err) {
                console.error('Error:', err);
                let errorMessage = 'Terjadi kesalahan saat mengakses kamera';

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

        async function stopScanner() {
            if (html5QrCode) {
                // Hentikan scanner
                await html5QrCode.stop();
                html5QrCode = null;

                // Bersihkan area scanner
                document.getElementById('scan-error-message').innerText = 'Scanner telah dihentikan';
                console.log('Scanner stopped successfully');
            }
        }
    </script>
@endpush
