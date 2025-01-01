<?php

namespace App\Filament\Widgets;

use App\Models\Laboratory;
use App\Models\Sample;
use App\Models\Sampler;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SampleOverview extends BaseWidget
{
    protected static ?int $navigationSort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Sample', Sample::query()->count())->label(__('module_names.drinkingwatersamples.label')),
            Stat::make('Laboratory', Laboratory::query()->count())->label(__('module_names.laboratory.label')),
            Stat::make('Sampler', Sampler::query()->count())->label(__('module_names.sampler.label')),
        ];
    }
}
