<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SamplingtypeResource\Pages;
use App\Filament\Resources\SamplingtypeResource\RelationManagers;
use App\Models\Samplingtype;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SamplingtypeResource extends Resource
{
    protected static ?string $model = Samplingtype::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): string
        {
        return __('module_names.navigation_groups.administration');
        }

    public static function getModelLabel(): string
    {
        return __('module_names.samplingtype.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('module_names.samplingtype.plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                ->schema([
                  Forms\Components\TextInput::make('type')->label(__('fields.type'))
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(10),
                  Forms\Components\TextInput::make('description')->label(__('fields.description'))
                    ->maxLength(50),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('type')->label(__('fields.type'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('description')->label(__('fields.description'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label(__('fields.created_at'))
                    ->dateTime('Y-m-d H:i')
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('updated_at')->label(__('fields.updated_at'))
                    ->dateTime('Y-m-d H:i')
                    ->searchable()->sortable(),
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
            'index' => Pages\ListSamplingtypes::route('/'),
            //'create' => Pages\CreateSamplingtype::route('/create'),
        ];
    }
}
