<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Customer;
use App\Models\Golongan;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalCustomers = Customer::count();

        $totalGolongan = Golongan::count();

        $averageHargaGolongan = Golongan::avg('harga');

        return [
            Stat::make('Customer', number_format($totalCustomers))
                ->color('success'),
            Stat::make('Golongan', number_format($totalGolongan)),
            Stat::make('Rata-rata Harga Golongan', 'Rp ' . number_format($averageHargaGolongan, 2))
            ->color('success'),
        ];
    }
}
