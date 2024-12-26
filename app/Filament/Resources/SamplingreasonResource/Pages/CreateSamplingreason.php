<?php

namespace App\Filament\Resources\SamplingreasonResource\Pages;

use App\Filament\Resources\SamplingreasonResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSamplingreason extends CreateRecord
{
    protected static string $resource = SamplingreasonResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
