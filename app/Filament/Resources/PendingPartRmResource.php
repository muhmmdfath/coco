<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendingPartRmResource\Pages;
use App\Filament\Resources\PendingPartRmResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\PartData;
use App\Models\RmData;

class PendingPartRmResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationGroup = 'Data Status';

    protected static ?string $label = 'Pending Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')->label('Code')->required(),
                Forms\Components\TextInput::make('lot_number')->label('Lot Number')->required(),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'Pending' => 'Pending',
                        'Approved' => 'Approved',
                        'Disapproved' => 'Disapproved',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')->label('Code')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('lot_number')->label('Lot Number')->sortable()->searchable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'gray' => 'Pending',
                        'success' => 'Approved',
                        'danger' => 'Disapproved',
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options(['Pending' => 'Pending']),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('Approve')
                    ->action(function ($records) {
                        $records->each(function ($record) {
                            $record->update(['status' => 'Approved']);
                        });
                    })
                    ->color('success')
                    ->icon('heroicon-o-check'),
                Tables\Actions\BulkAction::make('Disapprove')
                    ->action(function ($records) {
                        $records->each(function ($record) {
                            $record->update(['status' => 'Disapproved']);
                        });
                    })
                    ->color('danger')
                    ->icon('heroicon-o-x-circle'),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $partQuery = PartData::query()
            ->selectRaw('id as id, part_number as code, lot_number, status')
            ->where('status', 'Pending');

        $rmQuery = RmData::query()
            ->selectRaw('NULL as id, rm_number as code, lot_number, status')
            ->where('status', 'Pending');

        return PartData::query()->fromSub(
            $partQuery->unionAll($rmQuery),
            'combined_data'
        )->orderBy('id', 'asc');
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPendingPartRms::route('/'),
        ];
    }
}
