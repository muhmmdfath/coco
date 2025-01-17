<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RMDataResource\Pages;
use App\Filament\Resources\RMDataResource\RelationManagers;
use App\Models\RMData;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns;

class RMDataResource extends Resource
{
    protected static ?string $model = RMData::class;
    protected static ?string $modelLabel = 'RM Data'; // Label tunggal
    protected static ?string $pluralModelLabel = 'RM Data'; // Label jamak
    // protected static ?string $breadcrumb = 'RM Data'; // Label di breadcrumb

    protected static ?string $navigationLabel = 'RM Data Input';
    public static function getNavigationGroup(): ?string
    {
        return 'Input Data';
    }
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('tanggal_sortir')
                    ->label('Tanggal Sortir')
                    ->required(),

                Forms\Components\TextInput::make('rm_number')
                    ->label('RM Number')
                    ->required()
                    ->maxLength(50),

                Forms\Components\TextInput::make('lot_number')
                    ->label('LOT Number')
                    ->required()
                    ->maxLength(50),

                Forms\Components\Fieldset::make('jenis_problem')
                    ->schema([
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
                            ->reactive(),

                        Forms\Components\TextInput::make('jenis_problem_custom')
                            ->label('Jenis Problem')
                            ->placeholder('Masukkan jenis problem')
                            ->reactive()
                            ->visible(fn($get) => $get('jenis_problem') === 'Lainnya'),
                    ])
                    ->columns(),

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

                Forms\Components\DateTimePicker::make('waktu_mulai')
                    ->label('Waktu Mulai')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $get) {
                        if ($get('jam_selesai')) {
                            $jamMulai = \Carbon\Carbon::parse($get('waktu_mulai'));
                            $jamSelesai = \Carbon\Carbon::parse($get('waktu_selesai'));
                            $set('total_waktu', $jamMulai->diffInSeconds($jamSelesai));
                        }
                    }),

                Forms\Components\DateTimePicker::make('waktu_selesai')
                    ->label('Waktu Selesai')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $get) {
                        if ($get('waktu_mulai')) {
                            $jamMulai = \Carbon\Carbon::parse($get('waktu_mulai'));
                            $jamSelesai = \Carbon\Carbon::parse($get('waktu_selesai'));
                            $set('total_waktu', $jamMulai->diffInSeconds($jamSelesai));
                        }
                    }),

                Forms\Components\TextInput::make('total_waktu')
                    ->label('Total Waktu (Detik)')
                    ->numeric()
                    ->disabled()
                    ->dehydrated()
                    ->suffix('detik'),

                Forms\Components\TextInput::make('pic_sortir_rework')
                    ->label('PIC Sortir/Rework')
                    ->maxLength(100),

                Forms\Components\TextInput::make('diameter_besar')
                    ->label('Diameter Besar')
                    ->numeric(),

                Forms\Components\TextInput::make('diameter_sedang')
                    ->label('Diameter Sedang')
                    ->numeric(),

                Forms\Components\TextInput::make('diameter_kecil')
                    ->label('Diameter Kecil')
                    ->numeric(),

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
                    ->reactive()
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Columns\TextColumn::make('tanggal_sortir')->sortable(),
                Columns\TextColumn::make('rm_number')->sortable(),
                Columns\TextColumn::make('lot_number')->sortable(),
                Columns\TextColumn::make('jenis_problem')->sortable(),
                // Columns\TextColumn::make('status')->sortable(),
                Columns\TextColumn::make('total_waktu')
                    ->label('Total Waktu')
                    ->formatStateUsing(function ($record) {
                        $jamMulai = \Carbon\Carbon::parse($record->waktu_mulai);
                        $jamSelesai = \Carbon\Carbon::parse($record->waktu_selesai);

                        if ($record->waktu_mulai && $record->waktu_selesai) {
                            $totalSeconds = $jamMulai->diffInSeconds($jamSelesai);

                            // Konversi ke format hari, jam, menit, detik
                            $days = floor($totalSeconds / (24 * 3600));
                            $hours = floor(($totalSeconds % (24 * 3600)) / 3600);
                            $minutes = floor(($totalSeconds % 3600) / 60);
                            $seconds = $totalSeconds % 60;

                            return "{$days}h {$hours}j {$minutes}m {$seconds}d";
                        }

                        return '-';
                    }),
                Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Pending' => 'gray',
                        'Approved' => 'success',
                        'Dissaproved' => 'danger',
                    })->sortable(),
                Columns\TextColumn::make('updated_at')->label('Last Updated')->dateTime(),
            ])
            ->filters([
                // Add filters if necessary
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\EditAction::make()
                    ->color(color: 'warning')
                    ->icon('heroicon-o-pencil-square'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRMData::route('/'),
            'create' => Pages\CreateRMData::route('/create'),
            'edit' => Pages\EditRMData::route('/{record}/edit'),
        ];
    }

}
