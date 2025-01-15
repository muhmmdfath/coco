<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApprovedPartRmResource\Pages;
use Filament\Resources\Resource;
use App\Models\PartData;
use App\Models\RMData;


class ApprovedPartRmResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-check-circle';
    protected static ?string $navigationGroup = 'Data Status';
    protected static ?string $label = 'Approved Data';
    public static function getNavigationBadge(): ?string
    {
        $partCount = PartData::where('status', 'Approved')->count();
        $rmCount = RmData::where('status', 'Approved')->count();

        return $partCount + $rmCount;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }

    // protected static array $navigationIconOptions = [
    //     'color' => 'success',
    // ];

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApprovedPartRms::route('/'),
        ];
    }
}
