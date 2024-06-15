<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    use HasFactory;

    protected $table = 'mobil';

    protected $fillable = [
        'mandor_id',
        'nama_mobil',
        'nopol',
        'status_pemakaian',
        'tanggal_terakhir_beroperasi',
        'jumlah_km_awal',
    ];

    // Jika Anda ingin menggunakan 'id' yang dihasilkan oleh Laravel sebagai primary key, Anda dapat menghilangkan properti $primaryKey

    // Jika Anda menggunakan 'mobil_id' sebagai primary key, tambahkan kode berikut:
    // protected $primaryKey = 'mobil_id';

    // Definisikan casting untuk kolom 'spesifikasi'

    public function mandor()
    {
        return $this->belongsTo(Mandor::class, 'mandor_id');
    }

    public function scopeByMandorId($query, $mandorId)
    {
        return $query->where('mandor_id', $mandorId);
    }
}
