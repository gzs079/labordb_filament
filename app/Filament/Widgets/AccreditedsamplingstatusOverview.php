<?php

namespace App\Filament\Widgets;

use App\Models\Accreditedsamplingstatus;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AccreditedsamplingstatusOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Accreditedsamplingstatus', Accreditedsamplingstatus::query()->count())->label(__('module_names.accreditedsamplingstatus.plural_label')),
        ];
    }
}
