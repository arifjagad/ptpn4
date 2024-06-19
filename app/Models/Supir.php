<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Supir extends Model
{
    use HasFactory;

    public $incrementing = true;
    protected $table = 'supir';

    protected $fillable = [
        'mandor_id',
        'nama_supir',
        'nomor_telp',
        'jenis_kelamin',
        'status_supir',
        'status_perjalanan',
    ];

    protected $attributes = [
        'status_perjalanan' => 'Tersedia', 
    ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'mandor_id', 'id')->whereHas('roles', function ($query) {
    //         $query->where('role_id', 3);
    //     });
    // }

    public function mandor(): BelongsTo
    {
        return $this->belongsTo(Mandor::class);
    }
}
