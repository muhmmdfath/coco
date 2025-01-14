<?php

namespace App\Filament\Resources\PendingPartRmResource\Pages;

use App\Filament\Resources\PendingPartRmResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPendingPartRms extends ListRecords
{
    protected static string $resource = PendingPartRmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
