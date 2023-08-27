<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboadController extends Controller
{
    public function index()
    {
        $active = 'dashboard';

        $data = DB::table('detail_peminjaman as dp')
            ->select(DB::raw('count(p.tgl_pinjam) as total_pinjam'), 'p.tgl_pinjam')
            ->join('peminjaman as p', 'p.id', '=', 'dp.id_peminjaman')
            ->groupBy('p.id')
            ->orderBy('p.tgl_pinjam', 'DESC')
            ->get();

        $peminjaman_grafik = array();
        $bulan_grafik = array();

        foreach ($data as $item) {
            // dd($item);
            array_push($peminjaman_grafik, $item->total_pinjam);
            array_push($bulan_grafik, $item->tgl_pinjam);
        }

        $data_list = DetailPeminjaman::with('User', 'Buku', 'Peminjaman')->get();
        return view('admin.page.dashboard', compact('active', 'peminjaman_grafik', 'bulan_grafik', 'data_list'));
    }
}
