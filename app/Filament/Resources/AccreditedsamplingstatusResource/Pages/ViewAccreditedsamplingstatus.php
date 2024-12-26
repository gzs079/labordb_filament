<?php

namespace App\Filament\Resources\AccreditedsamplingstatusResource\Pages;

use App\Filament\Resources\AccreditedsamplingstatusResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAccreditedsamplingstatus extends ViewRecord
{
    protected static string $resource = AccreditedsamplingstatusResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
