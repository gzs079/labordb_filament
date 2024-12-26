<?php

namespace App\Filament\Widgets;

use App\Models\Sampler;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SamplerOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Sampler', Sampler::query()->count())->label(__('module_names.sampler.plural_label')),
        ];
    }
}
