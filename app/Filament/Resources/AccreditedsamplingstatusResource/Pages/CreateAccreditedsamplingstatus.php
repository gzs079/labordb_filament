<?php

namespace App\Filament\Resources\AccreditedsamplingstatusResource\Pages;

use App\Filament\Resources\AccreditedsamplingstatusResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAccreditedsamplingstatus extends CreateRecord
{
    protected static string $resource = AccreditedsamplingstatusResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
