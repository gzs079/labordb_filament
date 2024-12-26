<?php

namespace App\Filament\Resources\SamplingsiteResource\Pages;

use App\Filament\Resources\SamplingsiteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSamplingsite extends EditRecord
{
    protected static string $resource = SamplingsiteResource::class;

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
