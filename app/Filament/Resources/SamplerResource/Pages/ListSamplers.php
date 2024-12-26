<?php

namespace App\Filament\Resources\SamplerResource\Pages;

use App\Filament\Resources\SamplerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSamplers extends ListRecords
{
    protected static string $resource = SamplerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
