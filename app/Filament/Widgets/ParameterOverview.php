<?php

namespace App\Filament\Widgets;

use App\Models\Parameter;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ParameterOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Parameter', Parameter::query()->count())->label(__('module_names.parameter.plural_label')),
        ];
    }
}
