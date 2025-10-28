<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Models\Category;
use Filament\Infolists\Components\ColorEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make(__('Category Name'))
                    ->icon('heroicon-o-tag')
                    ->description(__('Category Information'))
                    ->schema([
                        TextEntry::make('name')
                            ->label(__('Name')),
                    ])->columns(1)->columnSpanFull(),

                Section::make(__('Description'))
                    ->icon('heroicon-o-document-text')
                    ->description(__('View the basic details of the category'))
                    ->schema([
                        TextEntry::make('description')
                            ->label(__('Description'))
                            ->markdown()
                            ->placeholder('-'),
                    ])->columns(1)->columnSpanFull(),


                Section::make(__('Appearance and Status'))
                    ->icon('heroicon-o-cog')
                    ->description(__('Check the color and active status of the category'))
                    ->schema([
                        ColorEntry::make('color')
                            ->label(__('Color')),

                        IconEntry::make('is_active')
                            ->label(__('Active'))
                            ->boolean(),
                    ])->columns(2)->columnSpanFull(),

                Section::make(__('Timestamps'))
                    ->icon('heroicon-o-clock')
                    ->description(__('Ve las fechas de creación, actualización y eliminación'))
                    ->schema([

                        TextEntry::make('created_at')
                            ->label(__('Created At'))
                            ->dateTime()
                            ->placeholder('-'),

                        TextEntry::make('updated_at')
                            ->label(__('Updated At'))
                            ->dateTime()
                            ->placeholder('-'),

                        TextEntry::make('deleted_at')
                            ->label(__('Deleted At'))
                            ->dateTime()
                            ->visible(fn(Category $record): bool => $record->trashed()),
                    ])->columns(2)->columnSpanFull(),

            ]);
    }
}
