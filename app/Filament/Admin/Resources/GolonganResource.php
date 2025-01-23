<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\GolonganResource\Pages;
use App\Filament\Admin\Resources\GolonganResource\RelationManagers;
use App\Models\Golongan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GolonganResource extends Resource
{
    protected static ?string $model = Golongan::class;
    protected static ?string $recordTitleAttribute = 'Golongan';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('harga')->required(),
                Forms\Components\TextInput::make('golongan')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('harga'),
                Tables\Columns\TextColumn::make('golongan'),

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
            'index' => Pages\ListGolongans::route('/'),
            'create' => Pages\CreateGolongan::route('/create'),
            'edit' => Pages\EditGolongan::route('/{record}/edit'),
        ];
    }
}
