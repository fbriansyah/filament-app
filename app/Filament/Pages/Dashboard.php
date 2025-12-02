<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Actions\FilterAction;
use Filament\Pages\Dashboard\Concerns\HasFiltersAction;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
class Dashboard extends BaseDashboard
{
    // use HasFiltersForm;
    use HasFiltersAction;

    // public function filtersForm(Schema $schema): Schema
    // {
    //     return $schema
    //         ->components([
    //             Group::make()
    //                 ->columnSpan(3)
    //                 ->schema([]),
    //             Section::make("Filters")
    //                 ->schema([
    //                     DatePicker::make('startDate'),
    //                     DatePicker::make('endDate'),
    //                 ])
    //                 ->columns(1)
    //                 ->columnSpan(1),
    //         ]);
    // }

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
