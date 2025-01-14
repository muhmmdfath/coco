<?php

namespace App\Filament\Widgets;

use App\Models\PartData;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Part Data Statistics
        $partPending = PartData::where('status', 'Pending')->count();
        $partApproved = PartData::where('status', 'Approved')->count();
        $partDisapproved = PartData::where('status', 'Disapproved')->count();
        $totalPart = PartData::count();

        return [
            // Part Data Statistics
            Stat::make('Total Part Data', $totalPart)
                ->description('Semua data Part')
                ->descriptionIcon('heroicon-m-cube')
                ->color('gray'),

            Stat::make('Part Pending', $partPending)
                ->description('Menunggu persetujuan')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Part Approved', $partApproved)
                ->description('Telah disetujui')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Part Disapproved', $partDisapproved)
                ->description('Ditolak')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }

    protected function getLayout(): array
    {
        // Menggunakan grid dengan 4 kolom untuk setiap baris
        return [
            'default' => [
                'stats' => [
                    'class' => 'grid grid-cols-4 gap-4',  // 4 kolom dalam satu baris
                ],
            ],
        ];
    }
}
