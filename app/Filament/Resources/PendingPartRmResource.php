<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendingPartRmResource\Pages;
use Filament\Resources\Resource;
use App\Models\PartData;
use App\Models\RmData;

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

    public static function getNavigationBadge(): ?string
    {
        $partCount = PartData::where('status', 'Pending')->count();
        $rmCount = RmData::where('status', 'Pending')->count();

        return $partCount + $rmCount;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'gray';
    }

}
