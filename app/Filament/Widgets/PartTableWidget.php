<?php

namespace App\Filament\Widgets;

use App\Models\PartData;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;

class PartTableWidget extends BaseWidget
{
    protected static ?string $heading = 'Pending Part Data';

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return PartData::query()->where('status', 'Pending');
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

            Tables\Actions\Action::make('disapprove')
                ->label('Disapprove')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->button()
                ->action(fn(PartData $record) => $record->update(['status' => 'Disapproved'])),
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

            Tables\Actions\BulkAction::make('disapprove')
                ->label('Disapprove')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->action(fn($records) => $records->each->update(['status' => 'Disapproved'])),
        ];
    }
}
