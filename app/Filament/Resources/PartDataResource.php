<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PartDataResource\Pages;
use App\Models\PartData;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\Carbon;
use Filament\Tables\Columns;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Cache;



class PartDataResource extends Resource
{
    protected static ?string $modelLabel = 'Part Data'; // Label tunggal
    protected static ?string $pluralModelLabel = 'Part Data'; // Label jamak
    protected static ?string $breadcrumb = 'Part Data'; // Label di breadcrumb
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

                // Forms\Components\TextInput::make('part_number')
                //     ->label('Part Number')
                //     ->required()
                //     ->maxLength(50),

                // Forms\Components\LiveSearchField::make('item_code')
                //     ->label('Item Code')
                //     ->placeholder('Search Item Code...')
                //     ->required(),

                Forms\Components\Select::make('part_number')
                    ->label('Part Number')
                    ->searchable()
                    ->getSearchResultsUsing(function (string $search) {
                        // Query ke SQL Server
                        return Cache::remember("oitm_search_{$search}", 300, function () use ($search) {
                            return \DB::connection('sqlsrv')
                                ->table('OITM')
                                ->where('ItemCode', 'like', "%{$search}%")
                                ->orWhere('ItemName', 'like', "%{$search}%")
                                ->limit(10)
                                ->pluck('ItemCode', 'ItemCode');
                        });
                    })
                    ->getOptionLabelUsing(function ($value) {
                        // Dapatkan label untuk value yang dipilih
                        return \DB::connection('sqlsrv')
                            ->table('OITM')
                            ->where('ItemCode', $value)
                            ->value('ItemCode');
                    })
                    ->required(),


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
                    ->createOptionForm([
                        Forms\Components\TextInput::make('jenis_problem')
                            ->required()
                            ->maxLength(255)
                            ->label('Jenis Problem Baru')
                    ])
                    ->createOptionAction(function (Forms\Components\Actions\Action $action) {
                        return $action
                            ->modalHeading('Tambah Jenis Problem Baru')
                            ->modalButton('Tambah Problem')
                            ->modalWidth('md');
                    })
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
                    ->searchable()
                    ->required(),

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



                Forms\Components\Select::make('pic_sortir_rework')
                    ->label('PIC Sortir/Rework')
                    ->options([
                        'MFG1' => 'MFG1',
                        'PPIC' => 'PPIC',
                        'IPQC' => 'IPQC',
                        'CNC' => 'CNC',
                    ])
                    ->searchable(),

                Forms\Components\TextInput::make('total_ok')
                    ->label('Total OK')
                    ->numeric()
                    ->reactive()
                    ->extraAttributes(['wire:blur' => '']) // Menambahkan event blur
                    ->afterStateUpdated(function ($set, $state, $get) {
                        $totalOk = (int) ($state ?? 0);
                        $totalNg = (int) ($get('total_ng') ?? 0);
                        $set('total_check', $totalOk + $totalNg);
                    }),

                Forms\Components\TextInput::make('total_ng')
                    ->label('Total NG')
                    ->numeric()
                    ->reactive()
                    ->extraAttributes(['wire:blur' => '']) // Menambahkan event blur
                    ->afterStateUpdated(function ($set, $state, $get) {
                        $totalOk = (int) ($get('total_ok') ?? 0);
                        $totalNg = (int) ($state ?? 0);
                        $set('total_check', $totalOk + $totalNg);
                    }),

                Forms\Components\TextInput::make('total_check')
                    ->label('Total Check')
                    ->numeric()
                    ->disabled() // Field ini tidak dapat diubah oleh pengguna
                    ->dehydrated(),

                Forms\Components\DatePicker::make('tanggal_ambil')
                    ->label('Tanggal Ambil')
                    ->required(),

                Forms\Components\DatePicker::make('target_selesai')
                    ->label('Target_Selesai')
                    ->required(),

                Forms\Components\TextInput::make('remark')
                    ->label('Remark')
                    ->maxLength(255),

                // Forms\Components\Select::make('status')
                //     ->label('Status')
                //     ->options([
                //         'Pending' => 'Pending',
                //         'Approved' => 'Approved',
                //         'Disapproved' => 'Disapproved',
                //     ])
                //     ->required(),
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
