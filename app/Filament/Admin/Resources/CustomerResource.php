<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Customer;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\CustomerResource\Pages;
use App\Filament\Admin\Resources\CustomerResource\RelationManagers;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('pam_code')->required(),
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('address')->required(),
                Forms\Components\TextInput::make('phone')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pam_code'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('address'),
                Tables\Columns\TextColumn::make('phone'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('generate_qr_code')
                    ->label('Generate')
                    ->icon('heroicon-o-qr-code')
                    ->color('success')
                    ->action(function ($record) {
                        $data = [
                            'id' => $record->id,
                            'pam_code' => $record->pam_code,
                            'name' => $record->name,
                            'address' => $record->address,
                            'phone' => $record->phone,
                        ];

                        $path = public_path("qrcodes/{$record->id}.png");
                        QrCode::format('png')
                            ->size(500)
                            ->generate(json_encode($data), $path);

                        Notification::make()
                            ->title('QR Code sukses dibuat')
                            ->success()
                            ->send();
                    }),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
                Tables\Actions\BulkAction::make('generate_qr_codes')
                    ->label('Generate')
                    ->icon('heroicon-o-qr-code')
                    ->action(function (Collection $records) {
                        set_time_limit(300);
                        $counter = 0;
                        $html = `<html><head><title>Print QR Codes</title></head><body style="text-align: center;">`;
                        foreach ($records as $customer) {
                            if ($counter > 50) {
                                break;
                            }
                            $data = [
                                'id' => $customer->id,
                                'pam_code' => $customer->pam_code,
                                'name' => $customer->name,
                                'address' => $customer->address,
                                'phone' => $customer->phone,
                            ];

                            $path = public_path("qrcodes/{$customer->pam_code}.png");
                            QrCode::format('png')
                                ->size(500)
                                ->generate(json_encode($data), $path);

                            $url = asset("qrcodes/{$customer->pam_code}.png");
                            $html .= "<div style='margin: 20px;'>
                                        <img src='{$url}' alt='QR Code'>
                                        <p>{$customer->name}</p>
                                    </div>";

                            $counter++;
                        }

                        $html .= '</body></html>';

                        echo $html;

                        Notification::make()
                            ->title('QR Code sukses dibuat')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\BulkAction::make('generatePDF')
                    ->label('PDF')
                    ->action(function (Collection $records) {
                        $ids = $records->pluck('id')->toArray();

                        return redirect()->route('customers.generate-pdf', ['ids' => $ids]);
                    })
                    ->requiresConfirmation(),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'view' => Pages\ViewCustomer::route('/{record}'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
