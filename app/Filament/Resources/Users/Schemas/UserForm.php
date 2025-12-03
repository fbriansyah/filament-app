<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\Status;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make("User")
                    ->components([
                        self::getNameFormField(),
                        self::getEmailFormField(),
                        self::getPasswordFormField(),
                        self::getStatusFormField(),
                        self::getMetadataFormField(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }

    public static function getNameFormField(): TextInput
    {
        return TextInput::make('name')
            ->label('Full Name')
            ->maxLength(100)
            ->required();
    }

    public static function getEmailFormField(): TextInput
    {
        return TextInput::make('email')
            ->label('Email address')
            ->email()
            ->maxLength(150)
            ->unique()
            ->required();
    }

    public static function getPasswordFormField(): TextInput
    {
        return TextInput::make('password')
            ->password()
            ->visibleOn('create')
            ->required();
    }

    public static function getStatusFormField(): Select
    {
        return Select::make('status')
            ->options([
                Status::Active->value => Status::Active->name,
                Status::Inactive->value => Status::Inactive->name,
                Status::Blocked->value => Status::Blocked->name,
            ])
            ->default(Status::Active->value)
            ->required();
    }

    public static function getMetadataFormField(): TextInput
    {
        return TextInput::make('metadata');
    }
}
