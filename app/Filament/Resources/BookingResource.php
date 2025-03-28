<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationGroup = 'Consultation Management';
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $label = 'Booking';
    protected static ?string $pluralLabel = 'Bookings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('first_name')->required()->maxLength(255),
                TextInput::make('last_name')->required()->maxLength(255),
                TextInput::make('phone')->required()->tel(),
                TextInput::make('email')->email()->required(),
                Select::make('slot_id')->relationship('slot', 'slot_datetime')->required(),
                Select::make('payment_method')
                    ->options([
                        'stripe' => 'Stripe',
                        'paypal' => 'PayPal',
                        'offline' => 'Pay at Appointment',
                    ])
                    ->required(),
                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'cancelled' => 'Cancelled',
                        
                    ])
                    ->required(),
                Textarea::make('notes')->nullable(),
            ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('first_name')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('last_name')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('phone')
                ->searchable(),
            Tables\Columns\TextColumn::make('email')
                ->searchable(),
            Tables\Columns\TextColumn::make('slot.slot_datetime')
                ->label('Appointment Date')
                ->sortable()
                ->dateTime('l, F j, Y g:i A'),
            Tables\Columns\TextColumn::make('payment_method')
                ->label('Payment Method')
                ->formatStateUsing(fn ($state) => match ($state) {
                    'stripe' => 'Stripe Payment',
                    'paypal' => 'PayPal Payment',
                    'cash' => 'Pay at Appointment',
                    default => 'Unknown',
                })
                ->color(fn ($state) => match ($state) {
                    'stripe' => 'success',
                    'paypal' => 'info',
                    'cash' => 'warning',
                    default => 'gray',
                }),
            Tables\Columns\TextColumn::make('status')
                ->label('Status')
                ->formatStateUsing(fn ($state) => ucfirst($state))
                ->color(fn ($state) => match ($state) {
                    'pending' => 'danger',
                    'paid' => 'success',
                    default => 'gray',
                }),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Booked On')
                ->dateTime('F j, Y g:i A')
                ->sortable(),
        ])
        ->defaultSort('created_at', 'desc') // Sort by latest bookings first
        ->filters([
            Tables\Filters\SelectFilter::make('status')
                ->options([
                    'pending' => 'Pending',
                    'paid' => 'Paid',
                ]),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
}

    


    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
