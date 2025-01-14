<?php

namespace App\Filament\Resources\RMDataResource\Pages;

use App\Filament\Resources\RMDataResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRMData extends ListRecords
{
    protected static string $resource = RMDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
