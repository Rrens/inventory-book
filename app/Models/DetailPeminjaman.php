<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailPeminjaman extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'detail_peminjaman';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $fillable = [
        'id_peminjaman',
        'id_user',
        'id_buku',
        'created_at',
        'updated_at',
    ];

    public function Peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id', 'id_peminjaman');
    }

    public function User()
    {
        return $this->hasMany(User::class, 'id', 'id_user');
    }

    public function Buku()
    {
        return $this->hasMany(Bukus::class, 'id', 'id_buku');
    }
}
