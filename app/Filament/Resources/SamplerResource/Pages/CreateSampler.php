<?php

namespace App\Filament\Resources\SamplerResource\Pages;

use App\Filament\Resources\SamplerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSampler extends CreateRecord
{
    protected static string $resource = SamplerResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
