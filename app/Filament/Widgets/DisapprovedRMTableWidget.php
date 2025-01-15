<?php

namespace App\Filament\Widgets;

use App\Models\RMData;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;

class DisapprovedRMTableWidget extends BaseWidget
{
    protected static ?string $heading = 'Disapproved Part Data';

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return RMData::query()->where('status', 'Disapproved');
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
                ->action(fn(RMData $record) => $record->update(['status' => 'Approved'])),

            Tables\Actions\Action::make('pending')
                ->label('Set Pending')
                ->icon('heroicon-o-clock')
                ->color('warning')
                ->button()
                ->requiresConfirmation()
                ->action(fn(RMData $record) => $record->update(['status' => 'Pending'])),
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
        ];
    }
}
