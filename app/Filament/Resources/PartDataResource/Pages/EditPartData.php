<?php

namespace App\Filament\Resources\PartDataResource\Pages;

use App\Filament\Resources\PartDataResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPartData extends EditRecord
{
    protected static string $resource = PartDataResource::class;

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
