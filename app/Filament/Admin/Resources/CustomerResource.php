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
use App\Jobs\GeneratePdfJob;
use Illuminate\Support\Facades\Log;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected $listener = [
        'echo-private:App.Models.User.{id},database-notifications.sent' => '$refresh',
        'notification' => 'handleNotification'
    ];

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
                    ->action(fn($record) => self::generateQrCode($record))
                    ->modalHeading('QR Code berhasil dibuat!')
                    ->modalContent(fn($record) => view('components.qr-modal', ['qr_code' => self::generateQrCode($record)])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\BulkAction::make('generatePDF')
                        ->label('PDF')
                        ->icon('heroicon-o-qr-code')
                        ->action(function (Collection $records) {
                            $customerIds = $records->pluck('id')->toArray();

                            GeneratePdfJob::dispatch(
                                $customerIds,
                                auth()->id()
                            )->onQueue('pdf');
                            Log::info('generating pdf');

                            Notification::make()
                                ->title('PDF sedang diproses. Anda akan mendapat notifikasi ketika selesai.')
                                ->success()
                                ->send();
                        })
                        ->requiresConfirmation(),
                ]),
            ]);
    }

    public static function generateQrCode($record)
    {
        $data = [
            'id' => $record->id,
            'pam_code' => $record->pam_code,
            'name' => $record->name,
            'address' => $record->address,
            'phone' => $record->phone,
        ];

        $img = QrCode::format('png')
            ->size(500)
            ->generate(json_encode($data));
        $base64 = 'data:image/png;base64,' . base64_encode($img);

        Notification::make()
            ->title('QR Code sukses dibuat')
            ->success()
            ->send();

        return $base64;
    }

    public function handleNotification($notification)
    {
        $this->dispatch('notification', $notification);
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
