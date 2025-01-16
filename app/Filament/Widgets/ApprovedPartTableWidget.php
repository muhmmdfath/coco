<?php

namespace App\Filament\Widgets;

use App\Models\PartData;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PartDataExport;

class ApprovedPartTableWidget extends BaseWidget
{
    protected static ?string $heading = 'Approved Part Data';

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return PartData::query()->where('status', 'Approved');
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('part_number')->label('Part Number'),
            Tables\Columns\TextColumn::make('lot_number')->label('Lot Number'),
            Tables\Columns\BadgeColumn::make('status')
                ->colors([
                    'gray' => 'Pending',
                    'success' => 'Approved',
                    'danger' => 'Disapproved',
                ]),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\Action::make('Disapprove')
                ->label('Disapprove')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->button()
                ->requiresConfirmation()
                ->action(fn(PartData $record) => $record->update(['status' => 'Disapproved'])),
        ];
    }

    protected function getTableBulkActions(): array
    {
        return [
            Tables\Actions\BulkAction::make('Disapprove')
                ->label('Disapprove')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->action(fn($records) => $records->each(fn($record) => $record->update(['status' => 'Disapproved']))),

            Tables\Actions\BulkAction::make('Export to PDF')
                ->label('Export to PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('primary')
                ->action(function ($records) {
                    $data = $records->toArray();

                    $pdf = Pdf::loadView('exports.approved_part_data_pdf', [
                        'data' => $data,
                        'exportDate' => now()->format('Y-m-d H:i:s'),
                    ])->setPaper([0, 0, 1920, 1080], 'landscape');

                    return response()->streamDownload(
                        fn() => print ($pdf->output()),
                        'approved_part_data.pdf'
                    );
                }),

            Tables\Actions\BulkAction::make('Export to Excel')
                ->label('Export to Excel')
                ->icon('heroicon-o-document-text')
                ->color('success')
                ->action(function ($records) {
                    $data = $records->toArray();

                    return Excel::download(new PartDataExport($data), 'approved_part_data.xlsx');
                }),
        ];
    }
}
