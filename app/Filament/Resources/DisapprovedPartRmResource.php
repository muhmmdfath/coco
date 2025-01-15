<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DisapprovedPartRmResource\Pages;
use Filament\Resources\Resource;
use App\Models\PartData;
use App\Models\RmData;

class DisapprovedPartRmResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-x-circle';
    protected static ?string $navigationGroup = 'Data Status';
    protected static ?string $label = 'Disapproved Data';

    public static function getNavigationBadge(): ?string
    {
        $partCount = PartData::where('status', 'Disapproved')->count();
        $rmCount = RmData::where('status', 'Disapproved')->count();

        return $partCount + $rmCount;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDisapprovedPartRms::route('/'),
        ];
    }


}
