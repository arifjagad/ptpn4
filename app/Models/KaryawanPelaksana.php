<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaryawanPelaksana extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv_second';
    protected $table = 'FPERSUTAMA';
    
    protected $fillable = [
        'NIK',
        'NIKSAP',
        'NAMA',
        'JABATAN',
        'KELAMIN',
        'BIDANG',
        'noPhone',
        'MBT'
    ];
}
