<?php

namespace App\Filament\Resources\SamplingtypeResource\Pages;

use App\Filament\Resources\SamplingtypeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSamplingtype extends CreateRecord
{
    protected static string $resource = SamplingtypeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
