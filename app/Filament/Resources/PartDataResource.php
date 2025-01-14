<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PartDataResource\Pages;
use App\Filament\Resources\PartDataResource\RelationManagers;
use App\Models\PartData;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Carbon;
use Filament\Tables\Columns;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;

class PartDataResource extends Resource
{
    protected static ?string $model = PartData::class;
    public static function getNavigationGroup(): ?string
    {
        return 'Input Data';
    }
    protected static ?string $navigationLabel = 'Part Data Input';
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('tanggal_sortir')
                    ->label('Tanggal Sortir')
                    ->required(),

                Forms\Components\TextInput::make('part_number')
                    ->label('Part Number')
                    ->required()
                    ->maxLength(50),

                Forms\Components\TextInput::make('lot_number')
                    ->label('LOT Number')
                    ->required()
                    ->maxLength(50),

                Forms\Components\Select::make('jenis_problem')
                    ->label('Jenis Problem')
                    ->options([
                        'Diameter Body' => 'Diameter Body',
                        'Dia Body' => 'Dia Body',
                        'Rusty' => 'Rusty',
                        'Bending' => 'Bending',
                        'Scratch, Bending, Dented' => 'Scratch, Bending, Dented',
                        'Diameter over di ujung kedua sisi' => 'Diameter over di ujung kedua sisi',
                        'Bending, Dented' => 'Bending, Dented',
                        'Rusty, Scratch, Bending, Dented' => 'Rusty, Scratch, Bending, Dented',
                        'Lainnya' => 'Lainnya',
                    ])
                    ->searchable()
                    ->placeholder('Pilih jenis problem')
                    ->required(),

                Forms\Components\Select::make('metode_sortir_rework')
                    ->label('Metode Check/Sortir/Rework')
                    ->options([
                        'Micrometer' => 'Micrometer',
                        'Visual' => 'Visual',
                        'Rework Chamfer' => 'Rework Chamfer',
                    ])
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('line')
                    ->label('Line Produksi')
                    ->options([
                        'MFG1' => 'MFG1',
                        'WH' => 'WH',
                        'MFG1, WH' => 'MFG1, WH',
                    ])
                    ->searchable(),

                Forms\Components\TimePicker::make('jam_mulai')
                    ->label('Jam Mulai')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $get) {
                        if ($get('jam_selesai')) {
                            $jamMulai = \Carbon\Carbon::parse($get('jam_mulai'));
                            $jamSelesai = \Carbon\Carbon::parse($get('jam_selesai'));
                            $set('total_jam', $jamMulai->diffInSeconds($jamSelesai));
                        }
                    }),

                Forms\Components\TimePicker::make('jam_selesai')
                    ->label('Jam Selesai')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $get) {
                        if ($get('jam_mulai')) {
                            $jamMulai = \Carbon\Carbon::parse($get('jam_mulai'));
                            $jamSelesai = \Carbon\Carbon::parse($get('jam_selesai'));
                            $set('total_jam', $jamMulai->diffInSeconds($jamSelesai));
                        }
                    }),

                Forms\Components\TextInput::make('total_jam')
                    ->label('Total Jam (Detik)')
                    ->numeric()
                    ->disabled()
                    ->dehydrated()
                    ->suffix('detik'),

                Forms\Components\TextInput::make('pic_sortir_rework')
                    ->label('PIC Sortir/Rework')
                    ->maxLength(100),

                Forms\Components\TextInput::make('total_ok')
                    ->label('Total OK')
                    ->numeric()
                    ->reactive()
                    ->afterStateUpdated(function ($set, $state, $get) {
                        $set('total_check', $state + $get('total_ng'));
                    }),

                Forms\Components\TextInput::make('total_ng')
                    ->label('Total NG')
                    ->numeric()
                    ->reactive()
                    ->afterStateUpdated(function ($set, $state, $get) {
                        $set('total_check', $get('total_ok') + $state);
                    }),

                Forms\Components\TextInput::make('total_check')
                    ->label('Total Check')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(),

                Forms\Components\TextInput::make('remark')
                    ->label('Remark')
                    ->maxLength(255),

                Forms\Components\Select::make('departement_pic_sortir')
                    ->label('Departemen PIC Sortir')
                    ->options([
                        'MFG1' => 'MFG1',
                        'PPIC' => 'PPIC',
                        'IPQC' => 'IPQC',
                        'CNC' => 'CNC',
                    ])
                    ->searchable(),

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
                Columns\TextColumn::make('tanggal_sortir')->sortable(),
                Columns\TextColumn::make('part_number')->sortable(),
                Columns\TextColumn::make('lot_number')->sortable(),
                Columns\TextColumn::make('jenis_problem')->sortable(),
                Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Pending' => 'gray',
                        'Approved' => 'success',
                        'Disapproved' => 'danger',
                    })->sortable(),
                Columns\TextColumn::make('updated_at')->label('Last Updated')->dateTime(),
            ])
            // ->filters([])
            ->filters([
                // Filter Berdasarkan Tanggal
                Filter::make('tanggal_sortir')
                    ->form([
                        DatePicker::make('tanggal_mulai')
                            ->label('Tanggal Mulai'),
                        DatePicker::make('tanggal_selesai')
                            ->label('Tanggal Selesai'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when(
                                $data['tanggal_mulai'],
                                fn(Builder $query, $tanggalMulai) => $query->whereDate('tanggal_sortir', '>=', $tanggalMulai)
                            )
                            ->when(
                                $data['tanggal_selesai'],
                                fn(Builder $query, $tanggalSelesai) => $query->whereDate('tanggal_sortir', '<=', $tanggalSelesai)
                            );
                    }),

                // Filter Berdasarkan Bulan
                Filter::make('bulan')
                    ->form([
                        Select::make('bulan')
                            ->label('Bulan')
                            ->options([
                                '1' => 'Januari',
                                '2' => 'Februari',
                                '3' => 'Maret',
                                '4' => 'April',
                                '5' => 'Mei',
                                '6' => 'Juni',
                                '7' => 'Juli',
                                '8' => 'Agustus',
                                '9' => 'September',
                                '10' => 'Oktober',
                                '11' => 'November',
                                '12' => 'Desember',
                            ])
                            ->placeholder('Pilih Bulan'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->when(
                            $data['bulan'],
                            fn(Builder $query, $bulan) => $query->whereMonth('tanggal_sortir', '=', $bulan)
                        );
                    }),
            ])
            ->searchable()
            ->actions([
                Tables\Actions\EditAction::make()
                    ->color('warning')
                    ->icon('heroicon-o-pencil-square'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }


    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPartData::route('/'),
            'create' => Pages\CreatePartData::route('/create'),
            'edit' => Pages\EditPartData::route('/{record}/edit'),
        ];
    }
}
