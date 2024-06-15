<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Kegiatan extends Model
{
    use HasFactory, Notifiable;

    protected $connection = 'sqlsrv';
    protected $table = 'kegiatan';

    protected $fillable = [
        'karyawan_id',
        'nik',
        'supir_id',
        'mobil_id',
        'agenda',
        'tujuan',
        'tanggal_kegiatan',
        'jumlah_km_akhir',
        'jumlah_km_awal',
        'status_kegiatan',
    ];

    protected $casts = [
        'tujuan' => 'array',
    ];

    public function setTujuanAttribute($value)
    {
        $this->attributes['tujuan'] = json_encode(array_map('trim', explode(',', $value)));
    }

    public function getTujuanAttribute($value)
    {
        return json_decode($value, true);
    }

    public function karyawan(): HasOne
    {
        return $this->hasOne(Karyawan::class);
    }

    public function Karyawanpelaksana()
    {
        return $this->belongsTo(KaryawanPelaksana::class, 'NIK', 'nik');
    }

    public function karyawanpimpin()
    {
        return $this->belongsTo(KaryawanPimpinan::class, 'NIK', 'nik');
    }

    public function supir()
    {
        return $this->belongsTo(Supir::class, 'supir_id', 'id');
    }

    public function mobil()
    {
        return $this->belongsTo(Mobil::class, 'mobil_id', 'id');
    }

    // public function user()
    // {
    //     return $this->hasOne(User::class, 'user_id', 'id');
    // }
}
