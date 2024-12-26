<?php

namespace App\Filament\Resources\SamplingtypeResource\Pages;

use App\Filament\Resources\SamplingtypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSamplingtypes extends ListRecords
{
    protected static string $resource = SamplingtypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
