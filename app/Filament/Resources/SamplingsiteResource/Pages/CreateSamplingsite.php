<?php

namespace App\Filament\Resources\SamplingsiteResource\Pages;

use App\Filament\Resources\SamplingsiteResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSamplingsite extends CreateRecord
{
    protected static string $resource = SamplingsiteResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
