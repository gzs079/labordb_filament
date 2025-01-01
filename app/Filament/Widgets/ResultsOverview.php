<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Parameter;
use App\Models\Result;
use App\Models\Unit;

class ResultsOverview extends BaseWidget
{
    protected static ?int $navigationSort = 2;

    protected function getStats(): array
    {
        return [
            Stat::make('Result', Result::query()->count())->label(__('module_names.result.label')),
            Stat::make('Parameter', Parameter::query()->count())->label(__('module_names.parameter.label')),
            Stat::make('Unit', Unit::query()->count())->label(__('module_names.unit.label')),
        ];
    }
}
