<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Perbaikan extends Model
{
    use HasFactory;

    // UUID Settings
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kendaraan_id',
        'nama_bengkel',
        'kategori',
        'detail_perbaikan',
        'jumlah',
        'harga_per_pcs',
        'foto_kerusakan',
        'foto_nota',
        'tanggal_perbaikan',
        'tanggal_selesai',
        'status',
    ];

    // UUID Generator saat create
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    // Relasi ke Kendaraan
    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }
}
