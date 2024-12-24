<?php

namespace App\Filament\Resources\HumviresponsibleResource\Pages;

use App\Filament\Resources\HumviresponsibleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHumviresponsibles extends ListRecords
{
    protected static string $resource = HumviresponsibleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
