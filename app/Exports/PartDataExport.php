<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PartDataExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithMapping
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Mengambil koleksi data untuk diexport.
     */
    public function collection()
    {
        return collect($this->data);
    }

    /**
     * Mengatur header tabel.
     */
    public function headings(): array
    {
        return [
            'Tanggal Sortir',
            'Part Number',
            'Lot Number',
            'Jenis Problem',
            'Metode Sortir/Rework',
            'Line',
            'waktu Mulai',
            'waktu Selesai',
            'Total Jam',
            'PIC Sortir/Rework',
            'Total Check',
            'Total OK',
            'Total NG',
            'Tanggal Ambil',
            'Target Selesai',
            'Remark',
            'Status'
        ];
    }

    /**
     * Map the data to match headers.
     */
    public function map($row): array
    {
        return [
            $row['tanggal_sortir'] ?? '',
            $row['part_number'] ?? '',
            $row['lot_number'] ?? '',
            $row['jenis_problem'] ?? '',
            $row['metode_sortir_rework'] ?? '',
            $row['line'] ?? '',
            $row['waktu_mulai'] ?? '',
            $row['waktu_selesai'] ?? '',
            $row['total_waktu'] ?? '',
            $row['pic_sortir_rework'] ?? '',
            $row['total_check'] ?? '',
            $row['total_ok'] ?? '',
            $row['total_ng'] ?? '',
            $row['tanggal_ambil'] ?? '',
            $row['target_selesai'] ?? '',
            $row['remark'] ?? '',
            $row['status'] ?? ''
        ];
    }

    /**
     * Mengatur style pada worksheet.
     */
    public function styles(Worksheet $sheet)
    {
        // Membuat header bold
        $sheet->getStyle('A1:Q1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);

        // Mengatur alignment untuk semua kolom
        $sheet->getStyle('A1:Q' . $sheet->getHighestRow())->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);
    }
}
