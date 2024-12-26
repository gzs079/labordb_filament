<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SamplingsiteResource\Pages;
use App\Filament\Resources\SamplingsiteResource\RelationManagers;
use App\Models\Samplingsite;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SamplingsiteResource extends Resource
{
    protected static ?string $model = Samplingsite::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): string
    {
        return __('module_names.navigation_groups.administration');
    }

    public static function getModelLabel(): string
    {
        return __('module_names.samplingsite.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('module_names.samplingsite.plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('site')->label(__('fields.site'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(25),
                        Forms\Components\TextInput::make('name_laboratory')->label(__('fields.name_laboratory'))
                            ->required()
                            ->maxLength(75),
                        Forms\Components\TextInput::make('name_full')->label(__('fields.name_full'))
                            ->required()
                            ->maxLength(75),
                        Forms\Components\TextInput::make('name_short')->label(__('fields.name_short'))
                            ->required()
                            ->maxLength(75),
                        Forms\Components\TextInput::make('name_humvi_old')->label(__('fields.name_humvi_old'))
                            ->maxLength(75),
                    ])->columns(1),

                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('aquifer')->label(__('fields.aquifer'))
                            ->required()
                            ->maxLength(75),
                        Forms\Components\TextInput::make('settlement')->label(__('fields.settlement'))
                            ->required()
                            ->maxLength(75),
                        Forms\Components\TextInput::make('type')->label(__('fields.type'))
                            ->required()
                            ->maxLength(75),
                    ])->columns(3),

                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('GPS_N_Y')->label(__('fields.GPS_N_Y'))
                            ->numeric(),
                        Forms\Components\TextInput::make('GPS_E_X')->label(__('fields.GPS_E_X'))
                            ->numeric(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('site')->label(__('fields.site'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('name_laboratory')->label(__('fields.name_laboratory'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('name_full')->label(__('fields.name_full'))
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('name_full')->label(__('fields.name_full'))
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('name_short')->label(__('fields.name_short'))
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('name_humvi_old')->label(__('fields.name_humvi_old'))
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('aquifer')->label(__('fields.aquifer'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('settlement')->label(__('fields.settlement'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('type')->label(__('fields.type'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('GPS_N_Y')->label(__('fields.GPS_N_Y'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('GPS_E_X')->label(__('fields.GPS_E_X'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label(__('fields.created_at'))
                    ->dateTime('Y-m-d H:i')
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->label(__('fields.updated_at'))
                    ->dateTime('Y-m-d H:i')
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->iconButton(),
                Tables\Actions\EditAction::make()
                    ->iconButton(),
                Tables\Actions\DeleteAction::make()
                    ->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSamplingsites::route('/'),
//            'create' => Pages\CreateSamplingsite::route('/create'),
//            'edit' => Pages\EditSamplingsite::route('/{record}/edit'),
        ];
    }
}
