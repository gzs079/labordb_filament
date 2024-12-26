<?php

namespace App\Filament\Resources\SamplingreasonResource\Pages;

use App\Filament\Resources\SamplingreasonResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSamplingreason extends EditRecord
{
    protected static string $resource = SamplingreasonResource::class;

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
