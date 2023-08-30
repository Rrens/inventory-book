<?php

namespace App\Http\Controllers;

use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class LaporanController extends Controller
{
    public function index()
    {
        $active = 'laporan';
        $data = DetailPeminjaman::with('User', 'Peminjaman', 'Buku')
            ->groupBy('id_user')
            ->get();
        $data_detail =
            DetailPeminjaman::with('User', 'Peminjaman', 'Buku')
            ->get();
        // dd($data);
        return view('admin.page.laporan', compact('active', 'data', 'data_detail'));
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

        $check_date = Peminjaman::where('tgl_pinjam', $request->date)
            ->select('id')
            ->get();
        // $date = Peminjaman::all();

        $for_id = array();
        foreach ($check_date as $key) {
            array_push($for_id, $key->id);
        }
        // dd($for_id);
        $data = DetailPeminjaman::with('User', 'Peminjaman', 'Buku')
            ->whereIn('id_peminjaman', $for_id)
            ->groupBy('id_user')
            ->get();

        $data_detail =
            DetailPeminjaman::with('User', 'Peminjaman', 'Buku')
            ->whereIn('id_peminjaman', $for_id)
            ->get();
        $date = $request->date;

        return view('admin.page.filter-laporan', compact('active', 'data', 'date', 'data_detail'));
    }

    public function print_laporan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'date',
            'id_user' => 'required'
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back();
        }
        if ($request->has('date')) {
            $check_date = Peminjaman::where('tgl_pinjam', $request->date)
                ->select('id')
                ->get();

            $for_id = array();
            foreach ($check_date as $key) {
                array_push($for_id, $key->id);
            }

            $data = DetailPeminjaman::with('User', 'Peminjaman', 'Buku')
                ->where('id_user', $request->id_user)
                ->whereIn('id_peminjaman', $for_id)
                ->get();
        } else {
            $data = DetailPeminjaman::with('User', 'Peminjaman', 'Buku')
                ->where('id_user', $request->id_user)
                ->get();
        }

        return view('admin.print.print_laporan', compact('data'));
    }
}
