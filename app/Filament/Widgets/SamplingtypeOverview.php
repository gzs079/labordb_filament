<?php

namespace App\Filament\Widgets;

use App\Models\Samplingtype;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SamplingtypeOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Samplingtype', Samplingtype::query()->count())->label(__('module_names.samplingtype.plural_label')),
        ];
    }
}
