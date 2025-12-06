<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    self::stepOrderInfo(),
                    self::stepAddressAndNotes(),
                ])->columnSpanFull(),
            ]);
    }

    public static function stepOrderInfo(): Step
    {
        return Step::make('Order Info')
            ->schema([
                TextInput::make('code')
                    ->required(),
                TextInput::make('discount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                Select::make('customer_id')
                    ->relationship('customer', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                DateTimePicker::make('scheduled_at')
                    ->required(),
                Select::make('status')
                    ->options([
                        'scheduled' => 'Scheduled',
                        'inprogress' => 'Inprogress',
                        'rescheduled' => 'Rescheduled',
                        'cancelled' => 'Cancelled',
                        'done' => 'Done',
                    ])
                    ->default('scheduled')
                    ->required(),
            ]);
    }

    public static function stepAddressAndNotes(): Step
    {
        return Step::make('Address & Notes')
            ->schema([
                Textarea::make('address')
                    ->columnSpanFull(),
                Textarea::make('note')
                    ->columnSpanFull(),
            ]);
    }
}
