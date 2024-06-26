<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaryawanPimpinan extends Model
{
    use HasFactory;

    protected $table = 'PERSUTAMA';
    
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
