<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\PembacaanMeter;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\PembacaanMeterResource\Pages;
use App\Filament\Admin\Resources\PembacaanMeterResource\RelationManagers;

class PembacaanMeterResource extends Resource
{
    protected static ?string $model = PembacaanMeter::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            BelongsToSelect::make('customer_id')
                ->relationship('customer', 'name')
                ->label('Customer')
                ->required(),
            TextInput::make('meter_awal')
                ->label('Meter Awal')
                ->numeric()
                ->required()
                ->reactive(),
            TextInput::make('meter_akhir')
                ->label('Meter Akhir')
                ->numeric()
                ->required()
                ->reactive()
                ->afterStateUpdated(function (callable $set, callable $get) {
                    $meterAwal = $get('meter_awal') ?? 0;
                    $meterAkhir = $get('meter_akhir') ?? 0;
                
                    // Hitung pemakaian
                    $pemakaian = max(0, $meterAkhir - $meterAwal);
                    $set('pemakaian', $pemakaian);
                
                    // Hitung total
                    $tarifPerUnit = 1000; // Tarif per unit
                    $set('total', $pemakaian * $tarifPerUnit);
                }),
            TextInput::make('pemakaian')
                ->label('Pemakaian')
                ->numeric()
                ->disabled(),
            TextInput::make('total')
                ->label('Total')
                ->numeric()
                ->disabled(),
            // DatePicker::make('tanggal_baca')
            //     ->label('Tanggal Baca')
            //     ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID'),
                TextColumn::make('customer.pam_code')->label('Kode PAM'),
                TextColumn::make('customer.name')->label('Nama Customer'),
                // TextColumn::make('tanggal_baca')->label('Tanggal Baca')->date(),
                TextColumn::make('meter_awal')->label('Meter Awal'),
                TextColumn::make('meter_akhir')->label('Meter Akhir'),
                TextColumn::make('pemakaian')->label('Pemakaian')->sortable(),
                TextColumn::make('total')->label('Total')->sortable()->money('idr'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPembacaanMeters::route('/'),
            'create' => Pages\CreatePembacaanMeter::route('/create'),
            'edit' => Pages\EditPembacaanMeter::route('/{record}/edit'),
        ];
    }
}
