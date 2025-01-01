<?php

namespace App\Filament\Resources\SampleResource\Pages;

use App\Filament\Resources\SampleResource;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListSamples extends ListRecords
{

    use ExposesTableToWidgets;

    protected static string $resource = SampleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getFooterWidgets(): array
    {
        return [
            \app\Filament\Resources\SampleResource\Widgets\SampleModulChart::class,
            \app\Filament\Resources\SampleResource\Widgets\SampleSamplingreasonChart::class,
            \app\Filament\Resources\SampleResource\Widgets\SampleAquiferChart::class,
        ];
    }

    public function getColumns(): int | string | array
    {
        return [
            'lg' => 4,
            'md' => 4,
            'sm' => 12,
        ];
    }

}
