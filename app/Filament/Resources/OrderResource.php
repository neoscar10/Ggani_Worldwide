<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Filament\Resources\OrderResource\RelationManagers\AddressRelationManager;
use App\Models\Order;
use App\Models\Product;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;

use Illuminate\Support\Str;
use Filament\Forms\Set;
use Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Get;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn as ColumnsTextColumn;
use Number;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?int $navigationSort = 5;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Order Information')->schema([
                        Select::make('user_id')
                        ->label('Customer')
                        ->relationship('user', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),

                        Select::make('payment_method')
                        ->label('Payment Method')
                        ->options([
                            'stripe' => 'Stripe',
                            'paystack' => 'Paystack',
                            'cod' => 'Cash on Delivery'
                        ])
                        ->required(),

                        Select::make('payment_status')
                        ->options([
                            'pending' => 'Pending',
                            'paid' => 'Paid',
                            'failed' => 'Failed'
                        ])
                        ->default('pending')
                        ->required(),
                        
                        Radio::make('status')
                        ->label('Status')
                        ->inline()
                        ->required()
                        ->options([
                            'new' => 'New',
                            'processing' => 'Processing',
                            'shipped' => 'Shipped',
                            'delivered' => 'Delivered',
                            'cancelled' => 'Cancelled'
                        ])
                        ->default('new'),

                        Select::make('currency')
                        ->options([
                            'ngn' => 'NGN',
                            'usd' => 'USD',
                            'gbp' => 'GBP',
                            'inr' => 'INR',
                        ])
                        ->default('ngn')
                        ->required(),

                        Select::make('shipping_method')
                        ->options([
                            'none' => 'None, to be updated' 
                        ])
                        ->disabled()
                        ->default('none'),

                        Textarea::make('notes')
                        ->columnSpanFull()  
                    ])->columns(2),

                    Repeater::make('items')
                    ->relationship('items')
                    ->schema([
                        Select::make('product_id')
                            ->relationship('product', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->reactive()
                            ->options(fn (Get $get) => 
                                Product::whereNotIn('id', collect($get('../../items') ?? [])
                                    ->pluck('product_id')
                                    ->filter() // Ensures no null values
                                    ->toArray()
                                )->pluck('name', 'id')
                            )
                            ->afterStateUpdated(function ($state, Set $set) {
                                $product = Product::find($state);
                                if ($product) {
                                    $set('total_amount', $product->price);
                                    $set('unit_amount', $product->price);
                                } else {
                                    $set('total_amount', 0);
                                    $set('unit_amount', 0);
                                }
                            }),

                        TextInput::make('quantity')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn($state, Set $set, Get $get)=> $set('total_amount', $state*$get('unit_amount'))),

                            TextInput::make('unit_amount')
                            ->numeric()
                            ->disabled()
                            ->dehydrated()
                            ->required(),

                            TextInput::make('total_amount')
                            ->numeric()
                            ->required()
                            ->disabled()
                            ->dehydrated(),
                    ])
                    ->columns(2),

                    Placeholder::make('grand_total_place_holder')
                    ->label('Grand Total')
                    ->content(function(Get $get, Set $set){
                        $total = 0;
                        if (!$repeaters = $get('items')){
                            return $total;
                        }
                        foreach ($repeaters as $key => $repeater) {
                            $total += $get("items.{$key}.total_amount");
                        }
                        $set("grand_total", $total);
                        return Number::currency($total, "NGN");
                    }),
                    Hidden::make('grand_total')
                    ->default(0)
                    ->dehydrated()
                    ->reactive()

                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            ColumnsTextColumn::make('user.name')
            ->label('Customer')
            ->sortable()
            ->searchable(),

            ColumnsTextColumn::make('grand_total')
            ->numeric()
            ->sortable()
            ->money('NGN'),
            
            ColumnsTextColumn::make('payment_method')
            ->sortable()
            ->searchable(),

            ColumnsTextColumn::make('payment_status')
            ->sortable()
            ->searchable(),

            // ColumnsTextColumn::make('currency')
            // ->sortable()
            // ->searchable(),

            // ColumnsTextColumn::make('shipping_method')
            // ->sortable()
            // ->searchable(),

            SelectColumn::make('status')
            ->options([
                'new' => 'New',
                'processing' => 'Processing',
                'shipped' => 'Shipped',
                'delivered' => 'Delivered',
                'cancelled' => 'Cancelled',
            ])
            ->searchable()
            ->sortable(),

            ColumnsTextColumn::make('created_at')
            ->dateTime()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true),

            ColumnsTextColumn::make('updated_at')
            ->dateTime()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            AddressRelationManager::class,
        ];
    }
    //method to show number of order Items
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function getNavigationBadgeColor(): string|array|null
    {
       return static::getModel()::count() > 10? 'danger' : 'success';
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }    
}
