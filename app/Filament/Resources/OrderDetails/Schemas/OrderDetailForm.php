<?php

namespace App\Filament\Resources\OrderDetails\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class OrderDetailForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('order_id')
                    ->relationship('order', 'code')
                    ->required(),
                Select::make('service_id')
                    ->relationship('service', 'name')
                    ->required(),
                Select::make('assign_to')
                    ->relationship('assignTo', 'name')
                    ->required(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('Rp')
                    ->separator("."),
                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'inprogress' => 'Inprogress',
                        'done' => 'Done',
                        'cancelled' => 'Cancelled',
                    ])
                    ->default('pending')
                    ->required(),
                DateTimePicker::make('scheduled_at')
                    ->required(),
                Textarea::make('note')
                    ->columnSpanFull(),
            ]);
    }
}
