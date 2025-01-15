<?php

namespace App\Filament\Resources\ApprovedPartRmResource\Pages;

use App\Filament\Resources\ApprovedPartRmResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditApprovedPartRm extends EditRecord
{
    protected static string $resource = ApprovedPartRmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
