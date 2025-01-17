<?php

namespace App\Filament\Widgets;

use App\Models\PartData;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PartDataExport;

class DisapprovedPartTableWidget extends BaseWidget
{
    protected static ?string $heading = 'Disapproved Part Data';

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return PartData::query()->where('status', 'Disapproved');
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
            Tables\Actions\Action::make('approve')
                ->label('Approve')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->button()
                ->requiresConfirmation()
                ->action(fn(PartData $record) => $record->update(['status' => 'Approved'])),

            Tables\Actions\Action::make('pending')
                ->label('Set Pending')
                ->icon('heroicon-o-clock')
                ->color('warning')
                ->button()
                ->requiresConfirmation()
                ->action(fn(PartData $record) => $record->update(['status' => 'Pending'])),
        ];
    }

    protected function getTableBulkActions(): array
    {
        return [
            Tables\Actions\Action::make('approve')
                ->label('Approve')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->action(fn($records) => $records->each->update(['status' => 'Approved'])),

            Tables\Actions\Action::make('pending')
                ->label('Set Pending')
                ->icon('heroicon-o-clock')
                ->color('warning')
                ->requiresConfirmation()
                ->action(fn($records) => $records->each->update(['status' => 'Pending'])),

            Tables\Actions\BulkAction::make('Export to PDF')
                ->label('Export to PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('primary')
                ->action(function ($records) {
                    $data = $records->toArray();
                    $timestamp = now()->format('Y-m-d_H-i-s'); // Format timestamp
        
                    $pdf = Pdf::loadView('exports.part_data_export_pdf', [
                        'data' => $data,
                        'exportDate' => now()->format('Y-m-d H:i:s'),
                        'title' => 'Disapproved Part Data',
                    ])->setPaper([0, 0, 1920, 1080], 'landscape');

                    return response()->streamDownload(
                        fn() => print ($pdf->output()),
                        "disapproved_part_data_{$timestamp}.pdf" // Nama file dengan timestamp
                    );
                }),


            Tables\Actions\BulkAction::make('Export to Excel')
                ->label('Export to Excel')
                ->icon('heroicon-o-document-text')
                ->color('success')
                ->action(function ($records) {
                    $data = $records->toArray();
                    $timestamp = now()->format('d-m-Y_i-s'); // Format timestamp
        
                    return Excel::download(
                        new PartDataExport($data),
                        "disapproved_part_data_{$timestamp}.xlsx" // Nama file dengan timestamp
                    );
                }),

        ];
    }
}
