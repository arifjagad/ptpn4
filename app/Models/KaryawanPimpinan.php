<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaryawanPimpinan extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv_second';
    protected $table = 'PERSUTAMA';
    // protected $primaryKey = 'NAMA';
    // public $incrementing = false;
    // protected $keyType = 'string';
    
    protected $fillable = [
        'NIK',
        'NIKSAP',
        'NAMA',
        'JABATAN',
        'KELAMIN',
        'BIDANG',
        'hp',
        'MBT'
    ];
}
