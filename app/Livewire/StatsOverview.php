<?php

namespace App\Livewire;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected ?string $pollingInterval = '10s';
    protected ?string $heading = 'Analytics';

    protected ?string $description = 'An overview of some analytics.';

    protected function getStats(): array
    {
        return [
            Stat::make('Unique views', '192.1k')
                ->description('32k increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('Bounce rate', '21%')
                ->description('7% decrease')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->chart([17, 4, 10, 3, 5, 2, 7])
                ->color('danger'),
            Stat::make('Average time on page', '3:12')
                ->description('3% increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([17, 14, 10, 13, 15, 22, 30])
                ->color('success'),
        ];
    }
}
