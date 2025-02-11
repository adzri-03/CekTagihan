<?php

namespace App\Jobs;

use App\Models\Customer;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Events\DatabaseNotificationsSent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GeneratePdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // Define class constants
    private const MEMORY_LIMIT = '512M';
    private const MAX_EXECUTION_TIME = 300;
    private const CHUNK_SIZE = 100;
    private const QR_SIZE = 150;

    public function __construct(
        protected array $customerIds,
        protected ?int $userId = null
    ) {}

    public function handle(): void
    {
        ini_set('memory_limit', self::MEMORY_LIMIT);
        ini_set('max_execution_time', self::MAX_EXECUTION_TIME);

        try {
            $data = $this->generateCustomerData();
            $filename = $this->generatePdf($data);

            if ($this->userId) {
                $this->notifyUser($filename);
            }
        } catch (\Exception $e) {
            $this->failed($e);
        }
    }

    protected function generateCustomerData(): \Illuminate\Support\Collection
    {
        $data = collect();

        Customer::whereIn('id', $this->customerIds)
            ->chunk(self::CHUNK_SIZE, function ($customers) use ($data) {
                foreach ($customers as $customer) {
                    $data->push($this->prepareCustomerData($customer));
                }
            });

        return $data;
    }

    protected function prepareCustomerData(Customer $customer): array
    {
        $qrCode = QrCode::format('png')
            ->size(self::QR_SIZE)
            ->generate(json_encode($customer->only([
                'pam_code'
            ])));

        return [
            'pam_code' => $customer->pam_code,
            'name' => $customer->name,
            'address' => $customer->address,
            'phone' => $customer->phone,
            'qr_code' => base64_encode($qrCode),
        ];
    }

    protected function generatePdf(\Illuminate\Support\Collection $data): string
    {
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L',
            'margin_left' => 5,
            'margin_right' => 5,
            'margin_top' => 10,
            'margin_bottom' => 10,
            'tempDir' => storage_path('framework/mpdf'),
            'default_font' => 'dejavusans',
            'compress' => true,
            'showImageErrors' => true,
        ]);

        foreach ($data->chunk(4) as $chunk) {
            $mpdf->WriteHTML(
                view('qr-pdf', ['data' => $chunk])->render()
            );
        }

        $filename = 'qr-codes-' . time() . '.pdf';
        $path = storage_path('app/public/' . $filename);
        $mpdf->Output($path, 'F');

        return $filename;
    }

    protected function notifyUser(string $filename): void
    {
        $user = User::find($this->userId);

        $notification = Notification::make()
            ->title('PDF siap diunduh')
            ->icon('heroicon-o-document-arrow-down')
            ->body('Klik untuk mengunduh')
            ->actions([
                Action::make('download')
                    ->button()
                    ->url(Storage::disk('public')->url($filename))
                    ->openUrlInNewTab()
            ])
            ->persistent()
            ->success()
            ->send();

        $notification->sendToDatabase($user);

        $notification->broadcast($user);

        event(new DatabaseNotificationsSent($user));
    }

    public function failed(\Throwable $exception): void
    {
        if ($this->userId) {
            $user = User::find($this->userId);

            Notification::make()
                ->title('Gagal generate PDF')
                ->danger()
                ->body($exception->getMessage())
                ->sendToDatabase($user);
        }

        Log::error("PDF Job Failed: " . $exception->getMessage());
    }
}
