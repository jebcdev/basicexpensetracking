<?php

namespace App\Filament\Resources\CashMovements\Schemas;

use Filament\Schemas\Schema;
use App\Enums\CashMovementType;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use App\Enums\CashMovementRecurrentPeriod;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Schemas\Components\Utilities\Get;
use App\Filament\Resources\Categories\Schemas\CategoryForm;
use Filament\Actions\Action;

class CashMovementForm
{
    public static function configure(Schema $schema): Schema
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $userId = $user->id;
        $isAdmin = $user->isAdmin();
        return $schema
            ->components([
                Hidden::make('user_id')
                    ->default($userId),

                Grid::make()
                    ->columns(2)
                    ->columnSpanFull()

                    ->schema([

                        Section::make()
                            ->heading(__('Category and Type'))
                            ->icon(Heroicon::OutlinedTag)
                            ->schema([
                                Select::make('category_id')
                                    ->label(__('Category'))
                                    ->relationship('category', 'name')
                                    ->preload()->searchable()
                                    ->when(
                                        $isAdmin,
                                        fn($select) => $select
                                            ->createOptionForm(
                                                self::categoryCreateOptionForm(),
                                            )->createOptionAction(function (Action $action) {
                                                return $action
                                                    ->modalHeading(__('Create Category'))
                                                    ->modalSubmitActionLabel(__('Create Category'))
                                                ;
                                            })
                                    ),

                                ToggleButtons::make('type')

                                    ->options(
                                        array_combine(
                                            CashMovementType::values(),
                                            array_map(fn($value) => __($value), CashMovementType::values())
                                        )
                                    )
                                    ->required()
                                    ->grouped()
                                    ->label(__('Movement Type')),

                            ]),

                        Section::make()
                            ->heading(__('Financial Details'))
                            ->icon(Heroicon::OutlinedCurrencyDollar)
                            ->schema([

                                TextInput::make('amount')
                                    ->label(__('Amount'))
                                    ->required()
                                    ->numeric(),

                                TextInput::make('title')
                                    ->label(__('Title'))
                                    ->required(),
                            ]),

                    ])->columnSpanFull(),
                Grid::make()
                    ->columns(2)
                    ->columnSpanFull()

                    ->schema([
                        Section::make()
                            ->heading(__('Additional Information'))
                            ->icon(Heroicon::OutlinedDocumentText)
                            ->schema([


                                Textarea::make('description')
                                    ->label(__('Description')),

                                DatePicker::make('date')
                                    ->label(__('Date'))
                                    ->required(),

                            ]),

                        Section::make()
                            ->heading(__('Recurrence Settings'))
                            ->icon(Heroicon::OutlinedClock)
                            ->schema([


                                Toggle::make('is_recurrent')
                                    ->label(__('Is Recurrent'))
                                    ->live()
                                    ->required(),


                                Select::make('recurrent_period')
                                    ->preload()->searchable()
                                    ->options(
                                        array_combine(
                                            CashMovementRecurrentPeriod::values(),
                                            array_map(fn($value) => __($value), CashMovementRecurrentPeriod::values())
                                        )
                                    )
                                    ->nullable()
                                    ->visible(fn(Get $get) => $get('is_recurrent'))
                                    ->label(__('Recurrent Period')),
                            ])->columns(1),

                    ])->columnSpanFull(),
            ]);
    }

    public static function categoryCreateOptionForm(): array
    {
        return
            [

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

            ];
    }
}
