<?php

namespace App\Filament\Resources\DisapprovedPartRmResource\Pages;

use App\Filament\Resources\DisapprovedPartRmResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDisapprovedPartRm extends EditRecord
{
    protected static string $resource = DisapprovedPartRmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
