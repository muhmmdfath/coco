<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendingPartRmResource\Pages;
use Filament\Resources\Resource;

class PendingPartRmResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationGroup = 'Data Status';
    protected static ?string $label = 'Pending Data';

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPendingPartRms::route('/'),
        ];
    }



}
