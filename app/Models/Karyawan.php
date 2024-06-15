<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Karyawan extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $table = 'karyawan';

    protected $fillable = [
        'user_id',
        'nik',
        'niksap',
        'jabatan',
        'nomor_telp',
        'jenis_kelamin'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
