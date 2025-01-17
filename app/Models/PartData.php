<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartData extends Model
{
    use HasFactory;

    protected $table = 'part_data';

    protected $fillable = [
        'timestamp',
        'tanggal_sortir',
        'part_number',
        'lot_number',
        'jenis_problem',
        'metode_sortir_rework',
        'line',
        'waktu_mulai',
        'waktu_selesai',
        'total_waktu',
        'pic_sortir_rework',
        'total_check',
        'total_ok',
        'total_ng',
        'tanggal_ambil',
        'target_selesai',
        'remark',
        'status'
    ];

    protected $attributes = [
        'status' => 'Pending',
    ];

    // public function getFormattedTotalTimeAttribute()
    // {
    //     $totalSeconds = (int) $this->total_jam;
    //     $days = floor($totalSeconds / 86400); // 1 hari = 86400 detik
    //     $hours = floor(($totalSeconds % 86400) / 3600); // Sisa detik dibagi 3600
    //     $minutes = floor(($totalSeconds % 3600) / 60); // Sisa detik dibagi 60
    //     $seconds = $totalSeconds % 60; // Sisa detik

    //     return sprintf('%d hari %d jam %d menit %d detik', $days, $hours, $minutes, $seconds);
    // }

}
