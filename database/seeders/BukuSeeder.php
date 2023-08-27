<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bukus')->insert([
            [
                'isbn' => '1299290030',
                'penerbit' => 'Media Nusantara',
                'tahun_terbit' => 2019,
                'pengarang' => 'Budi Sutasoma',
                'deskripsi_fisik' => 'Baik',
                'judul' => 'Tanah Air di tanah Oligarki',
                'edisi' => '2019',
                'bahasa' => 'Indonesia',
            ],
        ]);
    }
}
