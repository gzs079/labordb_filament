<?php

namespace App\Filament\Resources\SamplingtypeResource\Pages;

use App\Filament\Resources\SamplingtypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSamplingtype extends EditRecord
{
    protected static string $resource = SamplingtypeResource::class;

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
