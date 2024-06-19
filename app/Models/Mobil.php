<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

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

    protected $attributes = [
        'status_pemakaian' => 'Tersedia', 
    ];

    public function mandor()
    {
        return $this->belongsTo(Mandor::class);
    }

    // public function scopeByMandorId($query, $mandorId)
    // {
    //     return $query->where('mandor_id', $mandorId);
    // }
}
