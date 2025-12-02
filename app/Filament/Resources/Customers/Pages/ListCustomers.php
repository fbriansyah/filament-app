<?php

namespace App\Filament\Resources\Customers\Pages;

use App\Filament\Imports\CustomerImporter;
use App\Filament\Resources\Customers\CustomerResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;

class ListCustomers extends ListRecords
{
    protected static string $resource = CustomerResource::class;

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'trash' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->withoutGlobalScopes()->where('deleted_at', '!=', null))
                ->icon(Heroicon::Trash),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            ImportAction::make()
                ->importer(CustomerImporter::class),
        ];
    }
}
