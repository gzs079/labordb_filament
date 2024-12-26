<?php

namespace App\Filament\Widgets;

use App\Models\Samplingsite;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SamplingsiteOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Samplingsite', Samplingsite::query()->count())->label(__('module_names.samplingsite.plural_label')),
        ];
    }
}
