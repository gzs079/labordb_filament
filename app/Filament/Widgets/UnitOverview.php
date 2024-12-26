<?php

namespace App\Filament\Widgets;

use App\Models\Unit;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UnitOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Unit', Unit::query()->count())->label(__('module_names.unit.plural_label')),
        ];
    }
}
