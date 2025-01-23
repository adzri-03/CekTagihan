<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Customer;
use Filament\Widgets\ChartWidget;

class CustomerChart extends ChartWidget
{
    protected static ?string $heading = 'Customer';

    protected static string $color = 'success';

    protected static ?int $sort = 1;

    protected function getData(): array
    {
        // Query untuk mendapatkan jumlah pelanggan per bulan
        $customersPerMonth = Customer::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        // Membuat array data per bulan
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $data[] = $customersPerMonth->get($i)?->count ?? 0;
        }

        return [
            'customerCount' => Customer::count(),
            'datasets' => [
                [
                    'label' => 'Customer',
                    'data' => $data, // Menggunakan data dinamis
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
