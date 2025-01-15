<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DisapprovedPartRmResource\Pages;
use Filament\Resources\Resource;

class DisapprovedPartRmResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-x-circle';
    protected static ?string $navigationGroup = 'Data Status';
    protected static ?string $label = 'Disapproved Data';

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDisapprovedPartRms::route('/'),
        ];
    }


}
