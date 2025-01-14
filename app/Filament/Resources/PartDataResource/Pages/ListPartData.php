<?php

namespace App\Filament\Resources\PartDataResource\Pages;

use App\Filament\Resources\PartDataResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPartData extends ListRecords
{
    protected static string $resource = PartDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
