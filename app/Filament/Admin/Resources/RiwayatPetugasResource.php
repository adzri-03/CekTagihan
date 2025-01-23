<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\RiwayatPetugasResource\Pages;
use App\Filament\Admin\Resources\RiwayatPetugasResource\RelationManagers;
use App\Models\RiwayatPetugas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RiwayatPetugasResource extends Resource
{
    protected static ?string $model = RiwayatPetugas::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')->required(),
                Forms\Components\TextInput::make('deskripsi')->required(),
                Forms\Components\TextInput::make('jenis_tindakan')->required(),
                Forms\Components\TextInput::make('related_id')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id'),
                Tables\Columns\TextColumn::make('deskripsi'),
                Tables\Columns\TextColumn::make('jenis_tindakan'),
                Tables\Columns\TextColumn::make('related_id'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListRiwayatPetugas::route('/'),
            'create' => Pages\CreateRiwayatPetugas::route('/create'),
            'edit' => Pages\EditRiwayatPetugas::route('/{record}/edit'),
        ];
    }
}
