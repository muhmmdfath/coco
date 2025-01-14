<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\RMData;

class StatsRMOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // RM Data Statistics
        $rmPending = RMData::where('status', 'Pending')->count();
        $rmApproved = RMData::where('status', 'Approved')->count();
        $rmDisapproved = RMData::where('status', 'Disapproved')->count();
        $totalRM = RMData::count();
        return [
            //
            // RM Data Statistics
            Stat::make('Total RM Data', $totalRM)
                ->description('Semua data RM')
                ->descriptionIcon('heroicon-m-cube')
                ->color('gray'),

            Stat::make('RM Pending', $rmPending)
                ->description('Menunggu persetujuan')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('RM Approved', $rmApproved)
                ->description('Telah disetujui')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('RM Disapproved', $rmDisapproved)
                ->description('Ditolak')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}
