<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make(__('Category Name'))
                    ->icon('heroicon-o-tag')
                    ->description(__('Enter the name of the category'))
                    ->schema([

                        TextInput::make('name')
                            ->label(__('Name'))
                            ->required(),
                    ])->columns(1)->columnSpanFull(),

                Section::make(__('Description'))
                    ->icon('heroicon-o-document-text')
                    ->description(__('Provide a detailed description for the category'))
                    ->schema([
                        MarkdownEditor::make('description')
                            ->label(__('Description'))
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('categories/descriptions')
                            ->fileAttachmentsAcceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg',])
                            ->fileAttachmentsMaxSize(5120) // 5 MB
                    ])->columns(1)->columnSpanFull(),

                Section::make(__('Category Settings'))
                    ->icon('heroicon-o-cog')
                    ->description(__('Configure the color and active status'))
                    ->schema([
                        ColorPicker::make('color')
                            ->label(__('Color'))
                            ->required(),

                        Toggle::make('is_active')
                            ->label(__('Active'))
                            ->required(),

                    ])->columns(2)->columnSpanFull(),

            ]);
    }
}
