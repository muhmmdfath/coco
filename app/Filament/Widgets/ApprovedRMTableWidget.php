<?php

namespace App\Filament\Widgets;

use App\Models\RMData;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;

class ApprovedRMTableWidget extends BaseWidget
{
    protected static ?string $heading = 'Approved RM Data';

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return RMData::query()->where('status', 'Approved');
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
            Tables\Actions\Action::make('disapprove')
                ->label('Disapprove')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->button()
                ->requiresConfirmation()
                ->action(fn(RMData $record) => $record->update(['status' => 'Disapproved'])),
        ];
    }

    protected function getTableBulkActions(): array
    {
        return [
            Tables\Actions\Action::make('disapprove')
                ->label('Disapprove')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->action(fn($records) => $records->each->update(['status' => 'Disapproved']))
        ];
    }
}
