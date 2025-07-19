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
        'tanggal_perbaikan',
        'nama_bengkel',
        'kategori',
        'sub_kategori',
        'detail_kerusakan',
        'komponen',
        'jumlah',
        'satuan',
        'harga_per_pcs',
        'total_harga',
        'foto_kerusakan',
        'foto_nota',
        'tanggal_selesai',
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
