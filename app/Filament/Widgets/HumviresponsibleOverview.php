<?php

namespace App\Filament\Widgets;

use App\Models\Humviresponsible;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class HumviresponsibleOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Humviresponsible', Humviresponsible::query()->count())->label(__('module_names.humviresponsible.plural_label')),
        ];
    }
}
