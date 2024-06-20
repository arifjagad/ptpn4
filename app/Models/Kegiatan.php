<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Kegiatan extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'kegiatan';

    protected $fillable = [
        'karyawan_id',
        'nik',
        'supir_id',
        'mobil_id',
        'agenda',
        'tujuan',
        'tanggal_kegiatan',
        'jumlah_km_awal',
        'jumlah_km_akhir',
        'status_kegiatan',
    ];

    // protected $casts = [
    //     'tujuan' => 'array',
    // ];

    // public function setTujuanAttribute($value)
    // {
    //     $this->attributes['tujuan'] = json_encode(array_map('trim', explode(',', $value)));
    // }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
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

}
