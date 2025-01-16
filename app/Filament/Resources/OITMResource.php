<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OITMResource\Pages;
use App\Models\OITM;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms;

class OITMResource extends Resource
{
    protected static ?string $model = OITM::class;

    protected static ?string $navigationLabel = 'Item Master';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ItemCode')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('ItemName')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->paginated(10);
    }




    // public static function table(Tables\Table $table): Tables\Table
    // {
    //     dd(OITM::all()->take(10)); // Hanya untuk debug
    // }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOITMS::route('/'),
        ];
    }
}
