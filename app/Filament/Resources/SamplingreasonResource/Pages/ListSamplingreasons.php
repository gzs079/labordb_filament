<?php

namespace App\Filament\Resources\SamplingreasonResource\Pages;

use App\Filament\Resources\SamplingreasonResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSamplingreasons extends ListRecords
{
    protected static string $resource = SamplingreasonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
