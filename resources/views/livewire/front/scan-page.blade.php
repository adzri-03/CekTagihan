<section id="content"
    class="max-w-[640px] w-full min-h-screen mx-auto flex flex-col bg-[#F8F8F8] overflow-x-hidden pb-[122px] relative">
    <div class="mx-4 my-4">
        <div class="top-menu flex justify-between items-center my-3">
            <a href="{{ route('front.index') }}" class="flex items-center space-x-2">
            <div class="w-[48px] h-[48px] flex shrink-0">
                <img src="assets/icons/back.svg" alt="icon">
            </div>
            <span class="text-lg font-semibold text-gray-700 hover:text-gray-900 transition-colors">Kembali</span>
            </a>
        </div>
        <!-- Main Content -->
        <h2 class="text-lg font-bold mb-4">Daftar Pelanggan</h2>

        <!-- Customer Table -->
        <div class="overflow-x-auto rounded-lg shadow-lg max-w-full">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-3 px-6 bg-indigo-50 text-left text-xs font-semibold uppercase tracking-wider border-b border-indigo-100">No.</th>
                        <th class="py-3 px-6 bg-indigo-50 text-left text-xs font-semibold uppercase tracking-wider border-b border-indigo-100">Kode PAM</th>
                        <th class="py-3 px-6 bg-indigo-50 text-left text-xs font-semibold uppercase tracking-wider border-b border-indigo-100">Nama</th>
                        <th class="py-3 px-6 bg-indigo-50 text-left text-xs font-semibold uppercase tracking-wider border-b border-indigo-100">Alamat</th>
                        <th class="py-3 px-6 bg-indigo-50 text-left text-xs font-semibold uppercase tracking-wider border-b border-indigo-100">No. Handphone</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($customers as $index => $customer)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="py-1 px-6 text-sm font-medium text-gray-900">{{ $index + 1 }}</td>
                            <td class="py-1 px-2 text-sm font-medium text-gray-900">{{ $customer->pam_code }}</td>
                            <td class="py-1 px-2 text-sm font-medium text-gray-900">{{ $customer->name }}</td>
                            <td class="py-1 px-2 text-sm font-medium text-gray-900">{{ $customer->address }}</td>
                            <td class="py-1 px-2 text-sm font-medium text-gray-900">{{ $customer->phone }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Semua pelanggan telah discan bulan ini</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $customers->links() }}
        </div>

        <!-- Scanner Button -->
        <div class="fixed bottom-[24px] w-full flex justify-center items-center z-30">
            <button onclick="QRScanner.openModal()"
                class="p-3 bg-blue-500 hover:bg-blue-600 text-white rounded-full shadow-lg transition-all transform hover:scale-105"
                aria-label="Mulai Scanner">
                <img src="{{ asset('assets/icons/qr-code.png') }}" alt="QR Scanner" class="w-[32px]">
            </button>
        </div>

        <!-- Scanner Modal -->
        <div id="scannerModal"
            class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 z-50 items-end sm:items-center justify-center">
            <div class="modal-content relative w-full sm:w-[500px] bg-white rounded-t-lg sm:rounded-lg shadow-xl">
                <!-- Close Button -->
                <button onclick="QRScanner.closeModal()"
                    class="absolute top-4 right-4 text-gray-600 hover:text-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Modal Content -->
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="text-center">
                        <h3 class="text-lg font-bold text-gray-900">Scan QR Code</h3>
                        <div class="mt-4 flex justify-center">
                            <div id="reader"
                                class="w-full max-w-[350px] h-[260px] border border-gray-300 rounded-md"></div>
                        </div>
                        <div id="scanner-loading"
                            class="absolute inset-0 bg-white/80 flex items-center justify-center hidden">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
                        </div>
                        <div id="scan-success-feedback"
                            class="absolute inset-0 bg-green-500/50 flex items-center justify-center hidden">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="bg-gray-50 px-4 py-3 flex justify-between items-center">
                    <button onclick="QRScanner.closeModal()"
                        class="inline-flex justify-center rounded-md bg-red-500 text-white px-3 py-2 text-sm font-semibold hover:bg-red-600">
                        Cancel
                    </button>
                    <button onclick="QRScanner.retryScanner()"
                        class="inline-flex justify-center rounded-md bg-blue-500 text-white px-3 py-2 text-sm font-semibold hover:bg-blue-600">
                        Coba Lagi
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    const QRScanner = (() => {
        // State
        let scanner = null;
        let isProcessing = false;
        let isScannerActive = false;

        // DOM Elements
        const elements = {
            modal: document.getElementById('scannerModal'),
            reader: document.getElementById('reader'),
            loading: document.getElementById('scanner-loading'),
            success: document.getElementById('scan-success-feedback'),
        };

        // UI Methods
        const showLoading = () => elements.loading.classList.remove('hidden');
        const hideLoading = () => elements.loading.classList.add('hidden');
        const showSuccess = () => elements.success.classList.remove('hidden');
        const hideSuccess = () => elements.success.classList.add('hidden');

        // **Initialize Scanner**
        const initScanner = async () => {
            if (isScannerActive) return; // Hindari memulai scanner lebih dari sekali
            isScannerActive = true;

            try {
                showLoading();
                await destroyScanner();

                scanner = new Html5QrcodeScanner('reader', {
                    fps: 15, // Optimalkan FPS untuk performa
                    qrbox: { width: 300, height: 300 }, // Ukuran scanning box
                    supportedScanFormats: [Html5QrcodeSupportedFormats.QR_CODE],
                });

                await scanner.render(handleScanSuccess, handleScanError);
                console.log('✅ Scanner berhasil dimulai.');
            } catch (error) {
                console.error('❌ Gagal memulai scanner:', error.message);
                alert('Terjadi kesalahan saat memulai scanner.');
            } finally {
                hideLoading();
            }
        };

        // **Destroy Scanner**
        const destroyScanner = async () => {
            if (scanner) {
                try {
                    await scanner.clear();
                    scanner = null;
                    isScannerActive = false;
                    console.log('📴 Scanner dimatikan.');
                } catch (error) {
                    console.error('⚠️ Gagal menghentikan scanner:', error.message);
                }
            }
        };

        // **Handle QR Code Success**
        const handleScanSuccess = (decodedText) => {
            if (isProcessing) return;
            isProcessing = true;

            console.log('✅ QR Code Terbaca:', decodedText);
            showSuccess();
            window.Livewire.dispatch('scan-success', { scanned: decodedText });

            setTimeout(() => {
                hideSuccess();
                isProcessing = false;
            }, 1500);
        };

        // **Handle QR Code Error**
        const handleScanError = (errorMessage) => {
            console.warn('⚠️ Error membaca QR:', errorMessage);
        };

        // **Retry Scanner**
        const retryScanner = async () => {
            console.log('🔄 Memulai ulang scanner...');
            await destroyScanner();
            await initScanner();
        };

        // **Modal Controls**
        const openModal = () => {
            elements.modal.classList.remove('hidden');
            elements.modal.classList.add('flex');
            initScanner();
        };

        const closeModal = () => {
            elements.modal.classList.add('hidden');
            elements.modal.classList.remove('flex');
            destroyScanner();
        };

        // **Event Listeners**
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeModal();
        });

        elements.modal.addEventListener('click', (e) => {
            if (e.target === elements.modal) closeModal();
        });

        return { openModal, closeModal, retryScanner };
    })();
</script>

