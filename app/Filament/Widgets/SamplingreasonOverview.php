<?php

namespace App\Filament\Widgets;

use App\Models\Samplingreason;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SamplingreasonOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Samplingreason', Samplingreason::query()->count())->label(__('module_names.samplingreason.plural_label')),
        ];
    }
}
