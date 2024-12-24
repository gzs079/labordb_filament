<?php

namespace App\Filament\Resources\HumviresponsibleResource\Pages;

use App\Filament\Resources\HumviresponsibleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateHumviresponsible extends CreateRecord
{
    protected static string $resource = HumviresponsibleResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
