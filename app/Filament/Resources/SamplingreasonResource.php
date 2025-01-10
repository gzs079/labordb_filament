<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SamplingreasonResource\Pages;
use App\Filament\Resources\SamplingreasonResource\RelationManagers;
use App\Models\Samplingreason;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SamplingreasonResource extends Resource
{
    protected static ?string $model = Samplingreason::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Administration';
    
    public static function getNavigationGroup(): string
        {
        return __('module_names.navigation_groups.administration');
        }

    public static function getModelLabel(): string
    {
        return __('module_names.samplingreason.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('module_names.samplingreason.plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Section::make()
            ->schema([
              Forms\Components\TextInput::make('reason')->label(__('fields.reason'))
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
            Tables\Columns\TextColumn::make('reason')->label(__('fields.reason'))
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
                    ->iconButton()
                    ->before(function (Tables\Actions\DeleteAction $action, Samplingreason $record) {
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
            'index' => Pages\ListSamplingreasons::route('/'),
//            'create' => Pages\CreateSamplingreason::route('/create'),
//            'edit' => Pages\EditSamplingreason::route('/{record}/edit'),
        ];
    }
}
