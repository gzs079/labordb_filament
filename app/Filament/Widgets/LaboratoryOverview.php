<?php

namespace App\Filament\Widgets;

use App\Models\Laboratory;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LaboratoryOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Laboratory', Laboratory::query()->count())->label(__('module_names.laboratory.plural_label')),
        ];
    }
}
