<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make("Role")
                    ->components([
                        self::getNameFormField(),
                        self::getSlugFormField(),
                        self::getDescriptionFormField(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }

    public static function getNameFormField(): TextInput
    {
        return TextInput::make('name')
            ->required();
    }

    public static function getSlugFormField(): TextInput
    {
        return TextInput::make('slug')
            ->required();
    }

    public static function getDescriptionFormField(): Textarea
    {
        return Textarea::make('description')->cols(3);
    }
}
