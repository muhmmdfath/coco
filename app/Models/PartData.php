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
        'jam_mulai',
        'jam_selesai',
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
}
