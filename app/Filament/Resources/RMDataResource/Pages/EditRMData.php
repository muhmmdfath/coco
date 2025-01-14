<?php

namespace App\Filament\Resources\RMDataResource\Pages;

use App\Filament\Resources\RMDataResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRMData extends EditRecord
{
    protected static string $resource = RMDataResource::class;

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
