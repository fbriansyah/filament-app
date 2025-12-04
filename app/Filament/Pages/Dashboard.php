<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Actions\FilterAction;
use Filament\Pages\Dashboard\Concerns\HasFiltersAction;

class Dashboard extends BaseDashboard
{
    use HasFiltersAction;


    protected function getHeaderActions(): array
    {
        return [
            FilterAction::make('Filters')
                ->schema([
                    DatePicker::make('startDate')->default(now()->subDay()),
                    DatePicker::make('endDate')->default(now()),
                ])
        ];
    }

    public function getColumns(): int|array
    {
        return 2;
    }
}
