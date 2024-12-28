<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResultResource\Pages;
use App\Filament\Resources\ResultResource\RelationManagers;
use App\Models\Result;
use Closure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rules\Unique;

use function PHPUnit\Framework\callback;

class ResultResource extends Resource
{
    protected static ?string $model = Result::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): string
    {
        return __('module_names.navigation_groups.watersamples');
    }

    public static function getModelLabel(): string
    {
        return __('module_names.result.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('module_names.result.plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('sample_id')->label(__('fields.sample_id'))
                            ->required()
                            ->relationship('Sample', 'id')
                            ->searchable()
                            ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->id} - {$record->sample_lab_id} (Mintavétel: {$record->date_sampling->format('Y-m-d')})")
                            ->preload()
                            ->columnSpan(8)
                            ->createOptionForm(fn(Form $form) => SampleResource::form($form))
                            ->editOptionForm(fn(Form $form) => SampleResource::form($form)),
                    ]),

                    Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('parameter_id')->label(__('fields.parameter_id'))
                            ->required()
                            ->unique(modifyRuleUsing: function (Unique $rule, callable $get) {
                                return $rule
                                    ->where('sample_id', $get('sample_id'))
                                    ->where('parameter_id', $get('parameter_id'));
                            }, ignoreRecord: true)
                            ->relationship('Parameter', 'par_code')
                            ->searchable()
                            ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->par_code} - {$record->description_labor}")
                            ->preload()
                            ->createOptionForm(fn(Form $form) => ParameterResource::form($form))
                            ->editOptionForm(fn(Form $form) => ParameterResource::form($form)),
                        Forms\Components\Select::make('unit_id')->label(__('fields.unit_id'))
                            ->required()
                            ->relationship('Unit', 'unit_code')
                            ->searchable()
                            ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->unit_code} - {$record->description_labor}")
                            ->preload()
                            ->createOptionForm(fn(Form $form) => UnitResource::form($form))
                            ->editOptionForm(fn(Form $form) => UnitResource::form($form)),
                    ])->columns(2),

                    Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('value')->label(__('fields.value'))
                            ->required()
                            ->reactive()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($set, $state) {
                                $set('loq', calculate_loq($state));
                                $set('maxrange', calculate_maxrange($state));
                                $set('valueassigned', calculate_valueassigned($state));
                            })
                            ->columnSpan(12)
                            ->maxLength(25),
                        Forms\Components\TextInput::make('loq')->label(__('fields.loq'))
                            ->numeric()
                            ->disabled()
                            ->dehydrated()
                            ->columnSpan(4),
                        Forms\Components\TextInput::make('maxrange')->label(__('fields.maxrange'))
                            ->numeric()
                            ->disabled()
                            ->dehydrated()
                            ->columnSpan(4),
                        Forms\Components\TextInput::make('valueassigned')->label(__('fields.valueassigned'))
                            ->numeric()
                            ->disabled()
                            ->dehydrated()
                            ->columnSpan(4)
                        ])->columns(12),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('sample.sample_lab_id')->label(__('fields.sample_id'))
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
            'index' => Pages\ListResults::route('/'),
//            'create' => Pages\CreateResult::route('/create'),
//            'view' => Pages\ViewResult::route('/{record}'),
//            'edit' => Pages\EditResult::route('/{record}/edit'),
        ];
    }
}
