<?php

namespace App\Filament\Resources\PartDataResource\Pages;

use App\Filament\Resources\PartDataResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePartData extends CreateRecord
{
    protected static string $resource = PartDataResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
