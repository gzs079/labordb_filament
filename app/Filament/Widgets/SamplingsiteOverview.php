<?php

namespace App\Filament\Widgets;

use App\Models\Aquifer;
use App\Models\Samplingsite;
use App\Models\Settlement;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SamplingsiteOverview extends BaseWidget
{
    protected static ?int $navigationSort = 3;

    protected function getStats(): array
    {
        return [
            Stat::make('Samplingsite', Samplingsite::query()->count())->label(__('module_names.samplingsite.label')),
            Stat::make('Aquifer', Aquifer::query()->count())->label(__('module_names.aquifer.label')),
            Stat::make('Settlement', Settlement::query()->count())->label(__('module_names.settlement.label')),
        ];
    }
}
