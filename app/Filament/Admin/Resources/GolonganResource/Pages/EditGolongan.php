<?php

namespace App\Filament\Admin\Resources\GolonganResource\Pages;

use App\Filament\Admin\Resources\GolonganResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGolongan extends EditRecord
{
    protected static string $resource = GolonganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
