<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'username' => 'admin',
                'password' => Hash::make('123123'),
                'phone' => '081212121212',
                'gender' => 'Laki-laki',
                'alamat' => 'Surabaya',
                'phone' => '081212121212',
                'kode_pos' => '62818',
                'type_anggota' => null,
                'jenis_user' => 0,
                'tanggal_lahir' => Carbon::now(),
                'tanggal_input' => Carbon::now(),
            ],
            [
                'username' => 'guru',
                'password' => Hash::make('123123'),
                'phone' => '081212121212',
                'gender' => 'Perempuan',
                'alamat' => 'Surabaya',
                'phone' => '081212121212',
                'kode_pos' => '62818',
                'type_anggota' => 0,
                'jenis_user' => 1,
                'tanggal_lahir' => Carbon::now(),
                'tanggal_input' => Carbon::now(),
            ],
            [
                'username' => 'murid',
                'password' => Hash::make('123123'),
                'phone' => '081212121212',
                'gender' => 'Perempuan',
                'alamat' => 'Surabaya',
                'phone' => '081212121212',
                'kode_pos' => '62818',
                'type_anggota' => 1,
                'jenis_user' => 1,
                'tanggal_lahir' => Carbon::now(),
                'tanggal_input' => Carbon::now(),
            ],
        ]);
    }
}
