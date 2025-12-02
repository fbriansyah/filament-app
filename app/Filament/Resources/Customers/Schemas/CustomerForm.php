<?php

namespace App\Filament\Resources\Customers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detail')->schema([
                    self::getNameFormField(),
                    self::getEmailFormField(),
                ])
                    ->columnSpanFull()
                    ->columns(2),
                Section::make('Info')->schema([
                    self::getPhoneFormField(),
                    self::getAddressFormField(),
                ])
                    ->columnSpanFull()
                    ->columns(2),
            ]);
    }

    public static function getNameFormField(): TextInput
    {
        return TextInput::make('name')
            ->placeholder('customer full name')
            ->minLength(1)
            ->maxLength(100)
            ->required();
    }

    public static function getEmailFormField(): TextInput
    {
        return TextInput::make('email')
            ->placeholder('customer email')
            ->label('Email address')
            ->maxLength(100)
            ->email()
            ->required();
    }

    public static function getPhoneFormField(): TextInput
    {
        return TextInput::make('phone')
            ->placeholder('customer phone')
            ->maxLength(20)
            ->tel();
    }

    public static function getAddressFormField(): TextInput
    {
        return TextInput::make('address')
            ->minLength(1)
            ->maxLength(150)
            ->placeholder('customer address');
    }
}
