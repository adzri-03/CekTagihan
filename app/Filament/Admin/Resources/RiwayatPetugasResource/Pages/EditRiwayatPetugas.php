<?php

namespace App\Filament\Admin\Resources\RiwayatPetugasResource\Pages;

use App\Filament\Admin\Resources\RiwayatPetugasResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRiwayatPetugas extends EditRecord
{
    protected static string $resource = RiwayatPetugasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
