<?php

namespace App\Filament\Widgets;

use App\Models\PartData;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;

class PartTableWidget extends BaseWidget
{
    protected static ?string $heading = 'Part Data';

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation|null
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
