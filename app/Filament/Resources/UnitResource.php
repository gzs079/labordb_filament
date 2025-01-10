<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UnitResource\Pages;
use App\Filament\Resources\UnitResource\RelationManagers;
use App\Models\Unit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UnitResource extends Resource
{
    protected static ?string $model = Unit::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Administration';

    public static function getNavigationGroup(): string
    {
        return __('module_names.navigation_groups.administration');
    }

    public static function getModelLabel(): string
    {
       return __('module_names.unit.label');
    }

    public static function getPluralModelLabel(): string
    {
       return __('module_names.unit.plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('unit_code')->label(__('fields.unit_code'))
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(25),
                Forms\Components\TextInput::make('description_humvi')->label(__('fields.description_humvi'))
                    ->required()
                    ->maxLength(75),
                Forms\Components\TextInput::make('description_labor')->label(__('fields.description_labor'))
                    ->required()
                    ->maxLength(75),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('unit_code')->label(__('fields.unit_code'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('description_humvi')->label(__('fields.description_humvi'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('description_labor')->label(__('fields.description_labor'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label(__('fields.created_at'))
                    ->dateTime('Y-m-d H:i')
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('updated_at')->label(__('fields.updated_at'))
                    ->dateTime('Y-m-d H:i')
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
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
                    ->iconButton()
                    ->before(function (Tables\Actions\DeleteAction $action, Unit $record) {
                        if ($record->results()->exists()) {
                            Notification::make()
                                ->danger()
                                ->title(__('other.unsuccessful_delete_title'))
                                ->body(__('other.unsuccessful_delete_body_results'))
                                ->persistent()
                                ->send();
                            $action->cancel();
                        }
                    })
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                    ->before(function (Tables\Actions\DeleteBulkAction $action, Collection $records) {
                        foreach ($records as $record) {
                            if ($record->results()->exists()) {
                                Notification::make()
                                    ->danger()
                                    ->title(__('other.unsuccessful_delete_title'))
                                    ->body(__('other.unsuccessful_delete_body_results'))
                                    ->persistent()
                                    ->send();
                                $action->cancel();
                            }
                        }
                    }),
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
            'index' => Pages\ListUnits::route('/'),
//            'create' => Pages\CreateUnit::route('/create'),
//            'edit' => Pages\EditUnit::route('/{record}/edit'),
        ];
    }
}
