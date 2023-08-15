<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peminjaman extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'peminjaman';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $fillable = [
        'tgl_pinjam',
        'tgl_kembali',
        'keterangan',
        'denda',
        'created_at',
        'updated_at',
    ];

    public function detail_peminjaman()
    {
        return $this->belongsTo(DetailPeminjaman::class);
    }
}
