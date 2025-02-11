<?php

use App\Http\Controllers\API\CountMeterController;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\CustomerController;
use App\Livewire\Front\Hitung;
use App\Livewire\Front\ScanPage;
use App\Livewire\Front\Index;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use App\Models\Customer;


Route::redirect('/', '/login');

Route::redirect('dashboard', '/admin')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/customers/generate-pdf', [CustomerController::class, 'generatePDF'])->name('customers.generate-pdf');

Route::get('/index', Index::class)->name('front.index');
Route::get('/hitung/{customer}', Hitung::class)->name('front.hitung');
Route::get('/scan', ScanPage::class)->name('front.scan');
Route::get('/invoice/{pembacaanMeter}', [CountMeterController::class, 'invoice'])
    ->name('api.invoice');
Route::post('/hitung', [CountMeterController::class, 'store'])->name('hitung');


Route::get('/download-pdf/{filename}', function ($filename) {
    return Storage::disk('public')->download($filename);
})->name('filament.download-pdf');

Route::post('/process-scan', function (Request $request) {
    try {
        $scanned = json_decode($request->input('scanned_code'), true);
        $customer = Customer::where('pam_code', $scanned['pam_code'])->firstOrFail();

        if ($customer) {
            return response()->json([
                'success' => true,
                'redirect_url' => route('front.hitung', ['customer' => $customer->id]),
            ]);
        }
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Pelanggan tidak ditemukan',
        ], 400);
    }
})->name('front.process-scan');

require __DIR__ . '/auth.php';
