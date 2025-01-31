<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SampleResource\Pages;
use App\Filament\Resources\SampleResource\RelationManagers;
use App\Models\Aquifer;
use App\Models\Humvimodule;
use App\Models\Laboratory;
use App\Models\Sample;
use App\Models\Samplingreason;
use App\Models\Samplingsite;
use App\Models\Settlement;
use App\Enums\SampleStatuses;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Session;

class SampleResource extends Resource
{
    protected static ?string $model = Sample::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Watersamples';

    public static function getNavigationGroup(): string
    {
        return __('module_names.navigation_groups.watersamples');
    }

    public static function getModelLabel(): string
    {
        return __('module_names.drinkingwatersamples.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('module_names.drinkingwatersamples.plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('sample_lab_id')->label(__('fields.sample_lab_id'))
                            ->required()
                            ->columnSpan(3)
                            ->maxLength(25),
                        Forms\Components\Checkbox::make('humvi_export')->label(__('fields.humvi_export'))
                            ->columnSpan(1)
                            ->inline(false),
                        Forms\Components\Select::make('samplingsite_id')->label(__('fields.samplingsite_id'))
                            ->required()
                            ->relationship('Samplingsite', 'site')
                            ->searchable()
                            ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->site} - {$record->name_laboratory}")
                            ->preload()
                            ->columnSpan(8)
                            ->createOptionForm(fn(Form $form) => SamplingsiteResource::form($form))
                            ->editOptionForm(fn(Form $form) => SamplingsiteResource::form($form)),
                        Forms\Components\TextInput::make('sampling_site_details')->label(__('fields.sampling_site_details'))
                            ->columnSpan(8)
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('date_sampling')->label(__('fields.date_sampling'))
                            ->required()
                            ->columnSpan(4)
                            ->format('Y-m-d'),
                        ])->columns(12),

                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('humvimodule_id')->label(__('fields.humvimodule_id'))
                            ->required()
                            ->relationship('Humvimodule', 'modul')
                            ->searchable()
                            ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->modul} - {$record->description}")
                            ->preload()
                            ->createOptionForm(fn(Form $form) => HumvimoduleResource::form($form))
                            ->editOptionForm(fn(Form $form) => HumvimoduleResource::form($form)),
                        Forms\Components\Select::make('humviresponsible_id')->label(__('fields.humviresponsible_id'))
                            ->required()
                            ->relationship('Humviresponsible', 'responsible')
                            ->searchable()
                            ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->responsible} - {$record->name}")
                            ->preload()
                            ->createOptionForm(fn(Form $form) => HumviresponsibleResource::form($form))
                            ->editOptionForm(fn(Form $form) => HumviresponsibleResource::form($form)),
                        Forms\Components\Select::make('samplingtype_id')->label(__('fields.samplingtype_id'))
                            ->required()
                            ->relationship('Samplingtype', 'type')
                            ->searchable()
                            ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->type} - {$record->description}")
                            ->preload()
                            ->createOptionForm(fn(Form $form) => SamplingtypeResource::form($form))
                            ->editOptionForm(fn(Form $form) => SamplingtypeResource::form($form)),
                        ])->columns(3),

                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('laboratory_id')->label(__('fields.laboratory_id'))
                            ->required()
                            ->relationship('Laboratory', 'laboratory')
                            ->searchable()
                            ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->name} - {$record->accreditation_number} (Érvényes: {$record->valid_starts->format('Y-m-d')} - {$record->valid_ends->format('Y-m-d')})")
                            ->preload()
                            ->columnSpan('full')
                            ->createOptionForm(fn(Form $form) => LaboratoryResource::form($form))
                            ->editOptionForm(fn(Form $form) => LaboratoryResource::form($form)),
                        Forms\Components\DatePicker::make('date_samplereceipt')->label(__('fields.date_samplereceipt'))
                            ->format('Y-m-d'),
                        Forms\Components\DatePicker::make('date_analyses_start')->label(__('fields.date_analyses_start'))
                            ->format('Y-m-d'),
                        Forms\Components\DatePicker::make('date_analyses_end')->label(__('fields.date_analyses_end'))
                            ->format('Y-m-d'),
                    ])->columns(3),

                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('accreditedsamplingstatus_id')->label(__('fields.accreditedsamplingstatus_id'))
                            ->relationship('accreditedsamplingstatus', 'status')
                            ->searchable()
                            ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->status} - {$record->description}")
                            ->preload()
                            ->createOptionForm(fn(Form $form) => AccreditedsamplingstatusResource::form($form))
                            ->editOptionForm(fn(Form $form) => AccreditedsamplingstatusResource::form($form)),
                        Forms\Components\Select::make('sampler_id')->label(__('fields.sampler_id'))
                            ->relationship('Sampler', 'sampler')
                            ->searchable()
                            ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->name} - {$record->accreditation_number} (Érvényes: {$record->valid_starts->format('Y-m-d')} - {$record->valid_ends->format('Y-m-d')})")
                            ->preload()
                            ->columnSpan(2)
                            ->createOptionForm(fn(Form $form) => SamplerResource::form($form))
                            ->editOptionForm(fn(Form $form) => SamplerResource::form($form)),
                        Forms\Components\Select::make('samplingreason_id')->label(__('fields.samplingreason_id'))
                            ->required()
                            ->relationship('samplingreason', 'reason')
                            ->searchable()
                            ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->reason} - {$record->description}")
                            ->preload()
                            ->createOptionForm(fn(Form $form) => SamplingreasonResource::form($form))
                            ->editOptionForm(fn(Form $form) => SamplingreasonResource::form($form)),
                        Forms\Components\TextInput::make('sampling_reason_details')->label(__('fields.sampling_reason_details'))
                            ->columnSpan(2)
                            ->maxLength(255),
                    ])->columns(3),
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable()->sortable(),
                Tables\Columns\CheckboxColumn::make('humvi_export')->label(__('fields.humvi_export'))
                    ->searchable()->sortable()->disabled(),
                Tables\Columns\TextColumn::make('sample_status')->label(__('fields.sample_status'))
                    ->searchable()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('sample_lab_id')->label(__('fields.sample_lab_id'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('humvimodule.modul')->label(__('fields.humvimodule_id'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('humviresponsible.name')->label(__('fields.humviresponsible_id'))
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('samplingtype.type')->label(__('fields.samplingtype_id'))
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('date_sampling')->label(__('fields.date_sampling'))
                    ->dateTime('Y-m-d')
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('laboratory.name')->label(__('fields.laboratory_id'))
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('date_samplereceipt')->label(__('fields.date_samplereceipt'))
                    ->dateTime('Y-m-d')
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('date_analyses_start')->label(__('fields.date_analyses_start'))
                    ->dateTime('Y-m-d')
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('date_analyses_end')->label(__('fields.date_analyses_end'))
                    ->dateTime('Y-m-d')
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('samplingreason.reason')->label(__('fields.samplingreason_id'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('sampling_reason_details')->label(__('fields.sampling_reason_details'))
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('samplingsite.name_laboratory')->label(__('fields.samplingsite_id'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('samplingsite.aquifer.aquifer')->label(__('fields.aquifer'))
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('samplingsite.settlement.settlement')->label(__('fields.settlement'))
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('samplingsite.samplingsitetype.samplingsitetype')->label(__('fields.type'))
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('sampling_site_details')->label(__('fields.sampling_site_details'))
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('accreditedsamplingstatus.status')->label(__('fields.accreditedsamplingstatus_id'))
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('sampler.name')->label(__('fields.sampler_id'))
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
//PROBLÉMA: szűrők elrendezése nem jó, javítani kellene
//PROBLÉMA szűrő ikon feletti kis szám nem szűrők számát mutatja

                //HUMVI EXPORT SZŰRŐ
                SelectFilter::make('humvi_export')
                    ->label(__('fields.humvi_export_long'))
                    ->options([
                        1 => __('other.active'),
                        0 => __('other.inactive'),
                    ])
                    ->placeholder(__('other.all')),
                //MINTA STÁTUSZA SZŰRŐ
                SelectFilter::make('sample_status')
                    ->label(__('fields.sample_status'))
                    ->options(SampleStatuses::class),
                //MINTAVÉTEL DÁTUMA SZŰRŐ
                SelectFilter::make('date_sampling')
                ->form([
                    DatePicker::make('sampled_from')->label(__('fields.date_sampling_from')),
                    DatePicker::make('sampled_until')->label(__('fields.date_sampling_until')),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['sampled_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('date_sampling', '>=', $date),
                        )
                        ->when(
                            $data['sampled_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('date_sampling', '<=', $date),
                        );
                }),
                //IVÓVÍZBÁZIS SZŰRŐ
                SelectFilter::make('aquifer')
                ->form([
                    Select::make('aquifer')
                        ->label(__('fields.aquifer'))
                        ->options(function () {
                            return Aquifer::all()->pluck('aquifer', 'id')->toArray();
                        })
                        ->multiple()
                        ->preload(),
                ])
                ->query(function (Builder $query, array $data) {
                    if (!empty($data['aquifer']))
                    {
                        $query->whereHas(
                            'samplingsite',
                            fn (Builder $query) => $query->whereHas(
                                'aquifer',
                                fn (Builder $query) => $query->whereIn('id', $data['aquifer'])
                            )
                        );
                    }
                }),
                //TELEPÜLÉS SZŰRŐ
                SelectFilter::make('settlement')
                ->form([
//  PROBLÉMA:   település LISTA SZŰKÍTÉSÉRE PRÓBÁLKOZÁSOK NEM MŰKÖDTEK.
//              ADATBÁZIS MÓDOSÍTÁS UTÁN MÁR ADATOK IS HIÁNYOZNAK... gyakorlatban átgondolást igényel, nem biztos hogy működne
//              (legalább egy település -> több vízbázis)
                    Select::make('settlement')
                        ->label(__('fields.settlement'))
                        ->options(function () {
                            return Settlement::all()->pluck('settlement', 'id')->toArray();
                        })
                        ->multiple()
                        ->preload(),
                ])
                ->query(function (Builder $query, array $data) {
                    if (!empty($data['settlement']))
                    {
                        $query->whereHas(
                            'samplingsite',
                            fn (Builder $query) => $query->whereHas(
                                'settlement',
                                fn (Builder $query) => $query->whereIn('id', $data['settlement'])
                            )
                        );
                    }
                }),
                //MINTAVÉTEL HELYE SZŰRŐ
                SelectFilter::make('samplingsite')
                ->form([
                    Select::make('samplingsite')
                        ->label(__('fields.samplingsite_id'))
                        ->options(function () {
                            return Samplingsite::all()->pluck('name_laboratory', 'id')->unique()->sortBy(function ($item) {
                                return $item;
                            });
                        })
                        ->multiple()
                        ->getOptionLabelUsing(fn (Samplingsite $record) => $record->name_laboratory)
                        ->preload(),
                    ])
                ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                        $data['samplingsite'] ?? null,
                        fn (Builder $query, $values): Builder => $query->whereHas('samplingsite', function (Builder $query) use ($values) {
                            $query->whereIn('id', $values);
                        })
                    );
                }),
                //MODUL SZŰRŐ
//PROBLÉMA: modul és mintavétel oka szűrők nem ID alapján működnek. ResultsOverview.php-hoz hasonlóan lehetne egységesíten
//(Vizsgálólabor szűrő nem! Egy névvel több akkreditált státusz is lehet!)
                SelectFilter::make('modul')
                ->form([
                    Select::make('modul')
                        ->label(__('fields.humvimodule_id'))
                        ->options(function () {
                            return Humvimodule::all()->pluck('modul', 'modul')->unique()->sortBy(function ($item) {
                                return $item;
                            });
                        })
                        ->multiple()
                        ->getOptionLabelUsing(fn (Samplingsite $record) => $record->modul)
                        ->preload(),
                ])
                ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                        $data['modul'] ?? null,
                        fn (Builder $query, $values): Builder => $query->whereHas('humvimodule', function (Builder $query) use ($values) {
                            $query->whereIn('modul', $values);
                        })
                    );
                }),
                //MINTAVÉTEL OKA SZŰRŐ
                SelectFilter::make('samplingreason')
                ->form([
                    Select::make('samplingreason')
                        ->label(__('fields.samplingreason_id'))
                        ->options(function () {
                            return Samplingreason::all()->pluck('reason', 'reason')->unique()->sortBy(function ($item) {
                                return $item;
                            });
                        })
                        ->multiple()
                        ->getOptionLabelUsing(fn (Samplingreason $record) => $record->reason),
                ])
                ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                        $data['samplingreason'] ?? null,
                        fn (Builder $query, $values): Builder => $query->whereHas('samplingreason', function (Builder $query) use ($values) {
                            $query->whereIn('reason', $values);
                        })
                    );
                }),
                //VIZSGÁLÓLABOR SZŰRŐ
                SelectFilter::make('laboratory')
                ->form([
                    Select::make('laboratory')
                        ->label(__('fields.laboratory_id'))
                        ->options(function () {
                            return Laboratory::all()->pluck('name', 'name')->unique()->sortBy(function ($item) {
                                return $item;
                            });
                        })
                        ->multiple()
                        ->getOptionLabelUsing(fn (Laboratory $record) => $record->laboratory),
                ])
                ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                        $data['laboratory'] ?? null,
                        fn (Builder $query, $values): Builder => $query->whereHas('laboratory', function (Builder $query) use ($values) {
                            $query->whereIn('name', $values);
                        })
                    );
                }),
            ] , layout: FiltersLayout::AboveContentCollapsible)
//PROBLÉMA: hiddenFilterIndicators(false) esetén vagy ha nincs megadva, akkor csak
                ->hiddenFilterIndicators()
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
                    Tables\Actions\BulkAction::make('validate_sample')
                        ->label(__('other.validate_sample'))
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function (Collection $records) {
                            foreach ($records as $record) {
                                $record->update(['sample_status' => SampleStatuses::Validated]);
                            }
                        })
                        ->deselectRecordsAfterCompletion(),
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ResultsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSamples::route('/'),
//            'create' => Pages\CreateSample::route('/create'),
            'view' => Pages\ViewSample::route('/{record}'),
            'edit' => Pages\EditSample::route('/{record}/edit'),
        ];
    }

    protected function shouldPersistTableFiltersInSession(): bool
    {
        return true;
    }

}
