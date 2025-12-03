<?php

namespace App\Filament\Resources\Users\Tables;

use App\Enums\Status;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                self::getIDColumn(),
                self::getNameColumn(),
                self::getEmailColumn(),
                self::getStatusColumn(),
                self::getRoleColumn(),
                TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getIDColumn(): TextColumn
    {
        return TextColumn::make('id')
            ->label('ID')
            ->copyable()
            ->toggleable(isToggledHiddenByDefault: true);
    }

    public static function getNameColumn(): TextColumn
    {
        return TextColumn::make('name')
            ->copyable()
            ->sortable()
            ->searchable();
    }

    public static function getEmailColumn(): TextColumn
    {
        return TextColumn::make('email')
            ->label('Email address')
            ->copyable()
            ->sortable()
            ->searchable();
    }

    public static function getStatusColumn(): TextColumn
    {
        return TextColumn::make('status')
            ->badge()
            ->color(fn($state): string => match ($state) {
                Status::Active->value => 'success',
                Status::Inactive->value => 'warning',
                Status::Blocked->value => 'danger',
            });
    }

    public static function getRoleColumn(): TextColumn
    {
        return TextColumn::make('roles.name')
            ->label('Roles')
            ->searchable();
    }
}
