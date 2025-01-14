<?php

namespace App\Filament\Widgets;

use App\Models\PartData;
use App\Models\RMData;
use Filament\Widgets\ChartWidget;

class StatusChart extends ChartWidget
{
    protected static ?string $heading = 'Status Overview';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $labels = ['Pending', 'Approved', 'Disapproved'];

        $partData = [
            PartData::where('status', 'Pending')->count(),
            PartData::where('status', 'Approved')->count(),
            PartData::where('status', 'Disapproved')->count(),
        ];

        $rmData = [
            RMData::where('status', 'Pending')->count(),
            RMData::where('status', 'Approved')->count(),
            RMData::where('status', 'Disapproved')->count(),
        ];

        return [
            'datasets' => [
                [
                    'label' => 'Part Data',
                    'data' => $partData,
                    'backgroundColor' => ['#FFA500', '#00FF00', '#FF0000'],
                ],
                [
                    'label' => 'RM Data',
                    'data' => $rmData,
                    'backgroundColor' => ['#FFD700', '#32CD32', '#DC143C'],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
