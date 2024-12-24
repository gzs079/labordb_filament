<?php

namespace App\Filament\Resources\HumviresponsibleResource\Pages;

use App\Filament\Resources\HumviresponsibleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHumviresponsible extends EditRecord
{
    protected static string $resource = HumviresponsibleResource::class;

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
