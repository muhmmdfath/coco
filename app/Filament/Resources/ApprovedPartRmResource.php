<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApprovedPartRmResource\Pages;
use Filament\Resources\Resource;

class ApprovedPartRmResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-check-circle';
    protected static ?string $navigationGroup = 'Data Status';
    protected static ?string $label = 'Approved Data';

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApprovedPartRms::route('/'),
        ];
    }


}
