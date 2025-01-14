<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RMData extends Model
{
    use HasFactory;

    protected $table = 'rm_data';

    protected $fillable = [
        'timestamp',
        'tanggal_sortir',
        'rm_number',
        'lot_number',
        'jenis_problem',
        'metode_sortir_rework',
        'line',
        'jam_mulai',
        'jam_selesai',
        'pic_sortir_rework',
        'total_check',
        'diameter_besar',
        'diameter_sedang',
        'diameter_kecil',
        'total_ok',
        'total_ng',
        'remark',
        'departement_pic_sortir',
        'status'
    ];

    protected $attributes = [
        'status' => 'Pending',
    ];
}
