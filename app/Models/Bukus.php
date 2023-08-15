<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bukus extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bukus';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $fillable = [
        'isbn',
        'penerbit',
        'tahun_terbit',
        'pengarang',
        'tempat_terbit',
        'gmd',
        'tempat_terbit',
        'deskripsi_fisik',
        'judul_seri',
        'nomor_panggil',
        'bahasa',
        'no_klas',
        'keterangan',
        'created_at',
        'updated_at',
    ];

    public function detail_peminjaman()
    {
        return $this->belongsTo(DetailPeminjaman::class);
    }
}
