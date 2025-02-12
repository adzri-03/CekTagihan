<?php

namespace App\Livewire\Front;

use App\Models\Customer;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class ScanPage extends Component
{
    use WithPagination;

    protected $listeners = ['scan-success' => 'processScan'];

    public function processScan($scanned)
    {
        try {
            Log::info($scanned);
            $data = $this->validateQrData($scanned);
            $customer = $this->findValidCustomer($data['pam_code']);

            if ($customer) {
                return redirect()->route('front.hitung', $customer);
            }

            session()->flash('error', 'Pelanggan tidak valid!');
        } catch (\Exception $e) {
            Log::error('Scan error: ' . $e->getMessage());
            $this->dispatch('scan-error', message: $e->getMessage());
        }
    }

    protected function validateQrData($qrData)
    {
        $data = json_decode($qrData, true, 512, JSON_THROW_ON_ERROR);Log::info($data);
        if (!isset($data['pam_code'])) {
            throw new \Exception('Format QR tidak valid!');
        }

        return $data;
    }

    protected function findValidCustomer(int $pam_code): ?Customer
    {
        return Customer::where('pam_code', $pam_code)->first();
    }

    public function render()
    {
        $currentMonth = now()->format('Y-m');

        $customers = Customer::query()
            ->whereDoesntHave('pembacaanMeters', function ($query) use ($currentMonth) {
                $query->where('created_at', 'like', "{$currentMonth}%");
            })
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.front.scan-page', [
            'customers' => $customers,
        ]);
    }
}
