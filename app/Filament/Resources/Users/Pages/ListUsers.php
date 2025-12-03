<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\Status;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    public function getTabs(): array
    {
        return [
            'all' => Tab::make()
                ->icon(Heroicon::OutlinedUsers),
            'active' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', Status::Active->value))
                ->icon(Heroicon::OutlinedCheckCircle),
            'inactive' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', Status::Inactive->value))
                ->icon(Heroicon::OutlinedXCircle),
            'blocked' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', Status::Blocked->value))
                ->icon(Heroicon::OutlinedLockClosed),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
