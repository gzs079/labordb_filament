<?php

namespace App\Filament\Widgets;

use App\Models\Humvimodule;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class HumvimoduleOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Humvimodule', Humvimodule::query()->count())->label(__('module_names.humvimodule.plural_label')),
        ];
    }
}
