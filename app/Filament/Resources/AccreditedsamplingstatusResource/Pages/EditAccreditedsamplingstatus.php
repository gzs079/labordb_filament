<?php

namespace App\Filament\Resources\AccreditedsamplingstatusResource\Pages;

use App\Filament\Resources\AccreditedsamplingstatusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAccreditedsamplingstatus extends EditRecord
{
    protected static string $resource = AccreditedsamplingstatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
