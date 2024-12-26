<?php

namespace App\Filament\Resources\SamplingsiteResource\Pages;

use App\Filament\Resources\SamplingsiteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSamplingsites extends ListRecords
{
    protected static string $resource = SamplingsiteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
