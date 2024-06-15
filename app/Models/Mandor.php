<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Filament\Forms\Form;
use Filament\Resources\Forms\HasForm;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Mandor extends Model
{
    use HasFactory;

    protected $table = 'mandor';

    protected $fillable = [
        'user_id',
        'nik',
        'niksap',
        'status_mandor' => 'Aktif',
        'nomor_telp',
        'jenis_kelamin',
    ];

    // protected $primaryKey = 'mandor_id';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
