<?php

namespace App\Filament\Admin\Resources\RiwayatPelangganResource\Pages;

use App\Filament\Admin\Resources\RiwayatPelangganResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRiwayatPelanggan extends EditRecord
{
    protected static string $resource = RiwayatPelangganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
