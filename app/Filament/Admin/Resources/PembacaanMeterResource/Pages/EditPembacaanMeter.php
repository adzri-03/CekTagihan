<?php

namespace App\Filament\Admin\Resources\PembacaanMeterResource\Pages;

use App\Filament\Admin\Resources\PembacaanMeterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPembacaanMeter extends EditRecord
{
    protected static string $resource = PembacaanMeterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
