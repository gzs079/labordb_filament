<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HumviresponsibleResource\Pages;
use App\Filament\Resources\HumviresponsibleResource\RelationManagers;
use App\Models\Humviresponsible;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HumviresponsibleResource extends Resource
{
    protected static ?string $model = Humviresponsible::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Administration';
    
    public static function getNavigationGroup(): string
    {
    return __('module_names.navigation_groups.administration');
    }

    public static function getModelLabel(): string
    {
    return __('module_names.humviresponsible.label');
    }

    public static function getPluralModelLabel(): string
    {
    return __('module_names.humviresponsible.plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                ->schema([
                    Forms\Components\TextInput::make('responsible')->label(__('fields.responsible'))
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(10),
                    Forms\Components\TextInput::make('name')->label(__('fields.name'))
                        ->required()
                        ->maxLength(50),
                    Forms\Components\TextInput::make('address')->label(__('fields.address'))
                        ->required()
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
                Tables\Columns\TextColumn::make('responsible')->label(__('fields.responsible'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('name')->label(__('fields.name'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('address')->label(__('fields.address'))
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
                    ->iconButton()
                    ->before(function (Tables\Actions\DeleteAction $action, Humviresponsible $record) {
                        if ($record->samples()->exists()) {
                            Notification::make()
                                ->danger()
                                ->title(__('other.unsuccessful_delete_title'))
                                ->body(__('other.unsuccessful_delete_body_samples'))
                                ->persistent()
                                ->send();
                            $action->cancel();
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function (Tables\Actions\DeleteBulkAction $action, Collection $records) {
                            foreach ($records as $record) {
                                if ($record->samples()->exists()) {
                                    Notification::make()
                                        ->danger()
                                        ->title(__('other.unsuccessful_delete_title'))
                                        ->body(__('other.unsuccessful_delete_body_samples'))
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
            'index' => Pages\ListHumviresponsibles::route('/'),
//            'create' => Pages\CreateHumviresponsible::route('/create'),
//            'edit' => Pages\EditHumviresponsible::route('/{record}/edit'),
        ];
    }
}
