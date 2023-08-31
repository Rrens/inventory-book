<?php

namespace App\Http\Controllers;

use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class LaporanController extends Controller
{
    public function index()
    {
        $active = 'laporan';
        $data = DB::table('detail_peminjaman as dp')
            ->join('peminjaman as p', 'p.id', '=', 'dp.id_peminjaman')
            ->groupBy('p.tgl_pinjam')
            ->get();

        $for_count =
            DB::table('detail_peminjaman as dp')
            ->select('p.tgl_pinjam', 'dp.keterangan')
            ->join('peminjaman as p', 'p.id', '=', 'dp.id_peminjaman')
            ->get();

        $data_detail =
            DetailPeminjaman::with('User', 'Peminjaman', 'Buku')
            ->get();

        foreach ($data_detail as $item) {
            $item->tanggal = $item->Peminjaman[0]->tgl_pinjam;
        }
        return view('admin.page.laporan', compact('active', 'data', 'data_detail', 'for_count'));
    }

    public function filter(Request $request)
    {
        $active = 'laporan';
        $validator = Validator::make($request->all(), [
            'date' => 'required|date'
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back();
        }

        $for_count =
            DB::table('detail_peminjaman as dp')
            ->select('p.tgl_pinjam', 'dp.keterangan')
            ->join('peminjaman as p', 'p.id', '=', 'dp.id_peminjaman')
            ->get();
        $data = DB::table('detail_peminjaman as dp')
            ->join('peminjaman as p', 'p.id', '=', 'dp.id_peminjaman')
            ->where('p.tgl_pinjam', $request->date)
            ->groupBy('p.tgl_pinjam')
            ->get();
        $data_detail =
            DetailPeminjaman::with('User', 'Peminjaman', 'Buku')
            ->get();

        foreach ($data_detail as $item) {
            $item->tanggal = $item->Peminjaman[0]->tgl_pinjam;
        }

        $date = $request->date;

        return view('admin.page.filter-laporan', compact('active', 'data', 'date', 'data_detail', 'for_count'));
    }

    public function print_laporan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'date',
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back();
        }
        $check_date = Peminjaman::where('tgl_pinjam', $request->date)
            ->select('id')
            ->get();

        $for_id = array();
        foreach ($check_date as $key) {
            array_push($for_id, $key->id);
        }

        $data = DetailPeminjaman::with('User', 'Peminjaman', 'Buku')
            // ->where('id_user', $request->id_user)
            ->whereIn('id_peminjaman', $for_id)
            ->get();

        return view('admin.print.print_laporan', compact('data'));
    }
}
