<?php

namespace App\Filament\Resources\RMDataResource\Pages;

use App\Filament\Resources\RMDataResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRMData extends CreateRecord
{
    protected static string $resource = RMDataResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
