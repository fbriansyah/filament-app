<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Models\Order;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Details')
                    ->inlineLabel()
                    ->components([
                        TextEntry::make('code')
                            ->weight(FontWeight::Bold)
                            ->label('Order Code'),
                        TextEntry::make('order_details_sum_price')
                            ->sum('orderDetails', 'price')
                            ->label('Price')
                            ->money("IDR", locale: "id"),
                        TextEntry::make('discount')
                            ->money("IDR", locale: "id"),
                        TextEntry::make('scheduled_at')
                            ->dateTime(),
                        TextEntry::make('status')
                            ->badge()
                    ])
                ,
                Section::make('Customer Infos')
                    ->inlineLabel()
                    ->components([
                        TextEntry::make('customer.name')
                            ->label('Name'),
                        TextEntry::make('customer.phone')
                            ->label('Phone'),
                        TextEntry::make('customer.email')
                            ->label('Email'),
                        TextEntry::make('address')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('note')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
