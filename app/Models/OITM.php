<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OITM extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $table = 'OITM';
    protected $primaryKey = 'ItemCode';
    public $timestamps = false;
    public $incrementing = false; // Jika tidak ada auto-increment

    // Menentukan tipe data kolom yang akan diperlakukan sebagai string
    protected $casts = [
        'ItemCode' => 'string', // Memastikan ItemCode diperlakukan sebagai string
        'ItemName' => 'string', // Memastikan ItemName diperlakukan sebagai string
    ];
}
