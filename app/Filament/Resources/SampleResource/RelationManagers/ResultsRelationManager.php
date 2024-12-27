<?php

namespace App\Filament\Resources\SampleResource\RelationManagers;

use App\Filament\Resources\ResultResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ResultsRelationManager extends RelationManager
{
    protected static string $relationship = 'results';

    public static function getTitle(\Illuminate\Database\Eloquent\Model $ownerRecord, string $pageClass): string
    {
        return __('module_names.result.plural_label');
    }

    public static function getModelLabel(): string
    {
        return __('module_names.result.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('module_names.result.plural_label');
    }

    public function form(Form $form): Form
    {
        return ResultResource::form($form);
    }

    public function table(Table $table): Table
    {
        return ResultResource::table($table);
/*        return $table
            ->recordTitleAttribute('result_id')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('parameter.description_labor')->label(__('fields.parameter_id'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('unit.description_labor')->label(__('fields.unit_id'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('value')->label(__('fields.value'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('loq')->label(__('fields.loq'))
                    ->default('-')
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('maxrange')->label(__('fields.maxrange_short'))
                    ->default('-')
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('valueassigned')->label(__('fields.valueassigned'))
                    ->default('-')
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
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
*/
            }
}
