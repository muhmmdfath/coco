<?php

namespace App\Filament\Widgets;

use App\Models\RmData;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;

class RmTableWidget extends BaseWidget
{
    protected static ?string $heading = 'RM Data';

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation|null
    {
        return RmData::query()->where('status', 'Pending');
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('rm_number')->label('RM Number'),
            Tables\Columns\TextColumn::make('lot_number')->label('Lot Number'),
            Tables\Columns\BadgeColumn::make('status')
                ->colors([
                    'gray' => 'Pending',
                    'success' => 'Approved',
                    'danger' => 'Disapproved',
                ]),
        ];
    }

    protected function getTableBulkActions(): array
    {
        return [
            Tables\Actions\BulkAction::make('Approve')
                ->action(fn($records) => $records->each->update(['status' => 'Approved']))
                ->color('success'),
            Tables\Actions\BulkAction::make('Disapprove')
                ->action(fn($records) => $records->each->update(['status' => 'Disapproved']))
                ->color('danger'),
        ];
    }
}
