<?php

namespace App\Filament\Resources\HumvimoduleResource\Pages;

use App\Filament\Resources\HumvimoduleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHumvimodules extends ListRecords
{
    protected static string $resource = HumvimoduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
