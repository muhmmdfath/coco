<?php

namespace App\Filament\Resources\OITMResource\Pages;

use App\Filament\Resources\OITMResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOITMS extends ListRecords
{
    protected static string $resource = OITMResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
