<?php

namespace App\Filament\Resources\AccreditedsamplingstatusResource\Pages;

use App\Filament\Resources\AccreditedsamplingstatusResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAccreditedsamplingstatuses extends ListRecords
{
    protected static string $resource = AccreditedsamplingstatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
