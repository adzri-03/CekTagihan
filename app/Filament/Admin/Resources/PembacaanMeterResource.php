<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PembacaanMeterResource\Pages;
use App\Filament\Admin\Resources\PembacaanMeterResource\RelationManagers;
use App\Models\PembacaanMeter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PembacaanMeterResource extends Resource
{
    protected static ?string $model = PembacaanMeter::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('customer_id')->required(),
                Forms\Components\TextInput::make('meter_awal')->required(),
                Forms\Components\TextInput::make('meter_akhir')->required(),
                Forms\Components\TextInput::make('pemakaian')->required(),
                Forms\Components\TextInput::make('total')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pelanggan_id'),
                Tables\Columns\TextColumn::make('meter_awal'),
                Tables\Columns\TextColumn::make('meter_akhir'),
                Tables\Columns\TextColumn::make('pemakaian'),
                Tables\Columns\TextColumn::make('total'),
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
