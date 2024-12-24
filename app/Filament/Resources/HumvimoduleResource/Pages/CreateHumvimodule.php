<?php

namespace App\Filament\Resources\HumvimoduleResource\Pages;

use App\Filament\Resources\HumvimoduleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateHumvimodule extends CreateRecord
{
    protected static string $resource = HumvimoduleResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
