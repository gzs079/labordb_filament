<?php

namespace App\Filament\Resources\SamplerResource\Pages;

use App\Filament\Resources\SamplerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSampler extends EditRecord
{
    protected static string $resource = SamplerResource::class;

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
