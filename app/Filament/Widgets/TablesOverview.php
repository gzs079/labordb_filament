<?php

namespace App\Filament\Widgets;

use App\Models\Accreditedsamplingstatus;
use App\Models\Humvimodule;
use App\Models\Humviresponsible;
use App\Models\Samplingreason;
use App\Models\Samplingtype;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TablesOverview extends BaseWidget
{

    protected static ?int $navigationSort = 4;

    protected function getStats(): array
    {
        return [
            Stat::make('Humvimodule', Humvimodule::query()->count())->label(__('module_names.humvimodule.plural_label')),
            Stat::make('Humviresponsible', Humviresponsible::query()->count())->label(__('module_names.humviresponsible.plural_label')),
            Stat::make('Samplingreason', Samplingreason::query()->count())->label(__('module_names.samplingreason.plural_label')),
            Stat::make('Accreditedsamplingstatus', Accreditedsamplingstatus::query()->count())->label(__('module_names.accreditedsamplingstatus.plural_label')),
            Stat::make('Samplingtype', Samplingtype::query()->count())->label(__('module_names.samplingtype.plural_label')),
        ];
    }
}