<?php

namespace App\Filament\Resources\Customers\Schemas;

use App\Models\Customer;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CustomerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data')->schema([
                    TextEntry::make('id')
                        ->copyable()
                        ->label('ID'),
                    TextEntry::make('name'),
                    TextEntry::make('email')
                        ->copyable()
                        ->label('Email address'),
                    TextEntry::make('phone')
                        ->placeholder('-'),
                    TextEntry::make('address')
                        ->placeholder('-'),
                ])->columnSpan(2),
                Group::make()->schema([
                    Section::make('Timestamp')->schema([
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->placeholder('-'),
                    ]),
                    Section::make('Deleted')->schema([
                        TextEntry::make('deleted_at')
                            ->dateTime()
                        // ->visible(fn(Customer $record): bool => $record->trashed()),
                    ])->visible(fn(Customer $record): bool => $record->trashed()),
                ]),
            ])
            ->columns([
                'default' => 1,
                'md' => 2,
                'lg' => 3,
                'xl' => 3,
                '2xl' => 3,
            ]);
    }
}
