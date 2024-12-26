<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SamplerResource\Pages;
use App\Filament\Resources\SamplerResource\RelationManagers;
use App\Models\Sampler;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SamplerResource extends Resource
{
    protected static ?string $model = Sampler::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): string
    {
        return __('module_names.navigation_groups.administration');
    }

    public static function getModelLabel(): string
    {
        return __('module_names.sampler.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('module_names.sampler.plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('sampler')->label(__('fields.sampler'))
                    ->required()
                    ->maxLength(10),
                Forms\Components\TextInput::make('accreditation_number')->label(__('fields.accreditation_number'))
                    ->required()
                    ->maxLength(20),
                Forms\Components\TextInput::make('name')->label(__('fields.name'))
                    ->required()
                    ->maxLength(150),
                Forms\Components\TextInput::make('address')->label(__('fields.address'))
                    ->required()
                    ->maxLength(150),
                Forms\Components\DatePicker::make('valid_starts')->label(__('fields.valid_starts'))
                    ->required()
                    ->format('Y-m-d'),
                Forms\Components\DatePicker::make('valid_ends')->label(__('fields.valid_ends'))
                    ->required()
                    ->format('Y-m-d'),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('sampler')->label(__('fields.sampler'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('accreditation_number')->label(__('fields.accreditation_number'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('name')->label(__('fields.name'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('address')->label(__('fields.address'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('valid_starts')->label(__('fields.valid_starts'))
                    ->dateTime('Y-m-d')
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('valid_ends')->label(__('fields.valid_ends'))
                    ->dateTime('Y-m-d')
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
            'index' => Pages\ListSamplers::route('/'),
//            'create' => Pages\CreateSampler::route('/create'),
//            'edit' => Pages\EditSampler::route('/{record}/edit'),
        ];
    }
}
