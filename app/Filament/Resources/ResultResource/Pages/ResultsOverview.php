<?php

namespace App\Filament\Resources\ResultResource\Pages;

use App\Filament\Resources\ResultResource;
use App\Models\Aquifer;
use App\Models\Humvimodule;
use App\Models\Laboratory;
use App\Models\Parameter;
use App\Models\Result;
use App\Models\Samplingreason;
use App\Models\Samplingsite;
use App\Models\Settlement;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;

use Filament\Resources\Pages\Page;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class ResultsOverview extends Page implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    protected static string $resource = ResultResource::class;

    protected static string $view = 'filament.resources.result-resource.pages.results-overview';

    protected static ?string $navigationGroup = 'Watersamples';

    public static function getNavigationGroup(): string
    {
        return __('module_names.navigation_groups.watersamples');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Result::query())
            ->columns([
                TextColumn::make('sample.sample_lab_id')->label(__('fields.sample_id'))
                    ->searchable()->sortable(),
                TextColumn::make('sample.date_sampling')->label(__('fields.date_sampling'))
                    ->dateTime('Y-m-d')
                    ->searchable()->sortable(),
                TextColumn::make('sample.humvimodule.modul')->label(__('fields.humvimodule_id'))
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('sample.samplingreason.reason')->label(__('fields.samplingreason_id'))
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('sample.laboratory.name')->label(__('fields.laboratory_id'))
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('sample.samplingsite.name_laboratory')->label(__('fields.samplingsite_id'))
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('sample.samplingsite.aquifer.aquifer')->label(__('fields.aquifer'))
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('sample.samplingsite.settlement.settlement')->label(__('fields.settlement'))
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('sample.samplingsite.samplingsitetype.samplingsitetype')->label(__('fields.type'))
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('parameter.description_labor')->label(__('fields.parameter_id'))
                    ->searchable()->sortable(),
                TextColumn::make('unit.description_labor')->label(__('fields.unit_id'))
                    ->searchable()->sortable(),
                TextColumn::make('value')->label(__('fields.value'))
                    ->searchable()->sortable(),
                TextColumn::make('loq')->label(__('fields.loq'))
                    ->default('-')
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('maxrange')->label(__('fields.maxrange_short'))
                    ->default('-')
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('valueassigned')->label(__('fields.valueassigned'))
                    ->default('-')
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                //PARAMÉTER SZŰRŐ
                SelectFilter::make('parameter_id')
                    ->form([
                        Select::make('parameter_id')
                            ->label(__('fields.parameter_id'))
                            ->options(function () {
                                return Parameter::all()->pluck('description_labor','id')->toArray();
                            })
                            ->default(Parameter::where('description_humvi','pH')->firstOrFail()->id)
                            ->preload(),
                        ])
                    ->query(fn (Builder $query, array $data): Builder => $query->where('parameter_id', $data)),
                //MINTAVÉTEL DÁTUMA SZŰRŐ
                SelectFilter::make('sample.date_sampling')
                    ->form([
                        DatePicker::make('sampled_from')->label(__('fields.date_sampling_from')),
                        DatePicker::make('sampled_until')->label(__('fields.date_sampling_until')),
                        ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['sampled_from'],
                                fn (Builder $query, $date): Builder => $query->whereHas(
                                    'sample',
                                    fn(Builder $query) => $query->whereDate('date_sampling', '>=', $date)),
                            )
                            ->when(
                                $data['sampled_until'],
                                fn (Builder $query, $date): Builder => $query->whereHas(
                                    'sample',
                                    fn(Builder $query) => $query->whereDate('date_sampling', '<=', $date)),
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
                                'sample',
                                fn (Builder $query) => $query->whereHas(
                                    'samplingsite',
                                    fn (Builder $query) => $query->whereHas(
                                        'aquifer',
                                        fn (Builder $query) => $query->whereIn('id', $data['aquifer'])
                                    )
                                )
                            );
                        }
                    }),
                //TELEPÜLÉS SZŰRŐ
                SelectFilter::make('settlement')
                    ->form([
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
                                'sample',
                                fn (Builder $query) => $query->whereHas(
                                    'samplingsite',
                                    fn (Builder $query) => $query->whereHas(
                                        'settlement',
                                        fn (Builder $query) => $query->whereIn('id', $data['settlement'])
                                    )
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
                ->query(function (Builder $query, array $data) {
                        if (!empty($data['samplingsite']))
                        {
                            $query->whereHas(
                                'sample',
                                fn (Builder $query) => $query->whereIn('samplingsite_id', $data['samplingsite'])
                            );
                        }
                }),
                //MODUL SZŰRŐ
                SelectFilter::make('modul')
                ->form([
                    Select::make('modul')
                        ->label(__('fields.humvimodule_id'))
                        ->options(function () {
                            return Humvimodule::all()->pluck('modul', 'id')->unique()->sortBy(function ($item) {
                                return $item;
                            });
                        })
                        ->multiple()
                        ->getOptionLabelUsing(fn (Samplingsite $record) => $record->modul)
                        ->preload(),
                ])
                ->query(function (Builder $query, array $data) {
                    if (!empty($data['modul']))
                    {
                        $query->whereHas(
                            'sample',
                            fn (Builder $query) => $query->whereIn('humvimodule_id', $data['modul'])
                        );
                    }
                }),
                //MINTAVÉTEL OKA SZŰRŐ
                SelectFilter::make('samplingreason')
                ->form([
                    Select::make('samplingreason')
                        ->label(__('fields.samplingreason_id'))
                        ->options(function () {
                            return Samplingreason::all()->pluck('reason', 'id')->unique()->sortBy(function ($item) {
                                return $item;
                            });
                        })
                        ->multiple()
                        ->getOptionLabelUsing(fn (Samplingreason $record) => $record->reason),
                ])
                ->query(function (Builder $query, array $data) {
                    if (!empty($data['samplingreason']))
                    {
                        $query->whereHas(
                            'sample',
                            fn (Builder $query) => $query->whereIn('samplingreason_id', $data['samplingreason'])
                        );
                    }
                }),
                //VIZSGÁLÓLABOR SZŰRŐ
                //SZŰRÉS CSAK NÉV ALAPJÁN, MERT A TÁBLÁBAN EGY NÉV TÖBB AKKREDITÁLT STÁTUSSZAL IS SZEREPELHET
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


                ->query(function (Builder $query, array $data) {
                    if (!empty($data['laboratory']))
                    {
                        $query->whereHas(
                            'sample',
                            fn (Builder $query) => $query->whereHas(
                                'laboratory',
                                fn (Builder $query) => $query->whereIn('name', $data['laboratory'])
                            )
                        );
                    }
                }),
            ] , layout: FiltersLayout::AboveContentCollapsible)
//PROBLÉMA: hiddenFilterIndicators(false) esetén vagy ha nincs megadva, akkor csak
                ->hiddenFilterIndicators()



            ->actions([
                // ...
            ])
            ->bulkActions([
                // ...
            ]);
    }



}
