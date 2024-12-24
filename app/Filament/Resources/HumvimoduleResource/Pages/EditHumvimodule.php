<?php

namespace App\Filament\Resources\HumvimoduleResource\Pages;

use App\Filament\Resources\HumvimoduleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHumvimodule extends EditRecord
{
    protected static string $resource = HumvimoduleResource::class;

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
