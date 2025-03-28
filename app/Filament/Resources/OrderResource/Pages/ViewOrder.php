<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Action::make('Download Receipt')
                ->url(fn () => route('orders.receipt', $this->record->id))
                ->openUrlInNewTab()
                ->color('primary')
                ->icon('heroicon-o-arrow-down-tray'),
        
        ];
    }
}



