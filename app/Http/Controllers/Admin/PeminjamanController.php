<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bukus;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class PeminjamanController extends Controller
{
    public function index()
    {
        $active = 'peminjaman';
        $date = Carbon::now()->toDateString();
        $data = DetailPeminjaman::with('Buku', 'User', 'Peminjaman')->get();
        $detail_riwayat = DetailPeminjaman::where('keterangan', 'pinjam')->get();
        return view('admin.page.Peminjaman', compact('active', 'date', 'data', 'detail_riwayat'));
    }

    public function get_user_id($id)
    {
        try {
            $user = User::where('id', $id)
                ->select('jenis_user', 'username', 'type_anggota')
                ->first();

            $detail_riwayat_belum = DetailPeminjaman::where('id_user', $id)
                ->where('keterangan', 'pinjam')
                ->count('id_user');
            $detail_riwayat = DetailPeminjaman::where('id_user', $id)
                ->count('id_user');

            return response()->json([
                'status' => 'Success',
                'data_user' => $user,
                'detail_riwayat_belum' => $detail_riwayat_belum,
                'detail_riwayat' => $detail_riwayat
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'status' => 'Error',
                'data' => $error->getMessage()
            ], 500);
        }
    }

    public function get_book_id($isbn)
    {
        try {
            $book = Bukus::where('isbn', $isbn)->select('isbn', 'judul')->first();
            return response()->json([
                'status' => 'Success',
                'data_buku' => $book
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'status' => 'Error',
                'data' => $error->getMessage()
            ], 500);
        }
    }

    public function get_user_name($member_name)
    {
        try {
            $user = User::where('username', $member_name)->first();
            $peminjaman_detail = DetailPeminjaman::with('peminjaman', 'Buku')->whereHas('Peminjaman', function ($query) {
                $query->select('tgl_kembali', 'tgl_pinjam');
            })
                ->where('id_user', $user->id)
                // ->select('tgl_kembali', 'tgl_pinjam')
                ->first();
            $detail_riwayat = DetailPeminjaman::where('id_user', $user->id)
                ->count('id_user');
            return response()->json([
                'status' => 'Success',
                'data_user' => $user,
                'detail_peminjaman' => $peminjaman_detail,
                'detail_riwayat' => $detail_riwayat
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'status' => 'Error',
                'data' => $error->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_member' => 'required',
            'isbn' => 'required',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date'
        ]);
        // dd(Bukus::where('isbn', $request->isbn)->select('id')->first()['id']);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }
        $peminjaman = new Peminjaman();
        $peminjaman->tgl_pinjam = $request->tanggal_pinjam;
        $peminjaman->tgl_kembali = $request->tanggal_kembali;
        $peminjaman->save();

        $peminjaman_detail = new DetailPeminjaman();
        $peminjaman_detail->id_peminjaman = $peminjaman->id;
        $peminjaman_detail->id_user = $request->id_member;
        $peminjaman_detail->id_buku = Bukus::where('isbn', $request->isbn)->select('id')->first()['id'];
        $peminjaman_detail->keterangan = 'pinjam';
        $peminjaman_detail->save();

        Alert::toast('Sukses Meminjam', 'Success');
        return back();
    }

    public function store_pengembalian(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'member_name' => 'required',
            'denda' => 'required'
            // 'tgl_pinjam' => 'required',
            // 'isbn' => 'required',
            // 'judul_buku' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        // dd(User::where('username', $request->member_name)->select('id')->first()['id']);
        $peminjaman_detail = DetailPeminjaman::where('id_user', User::where('username', $request->member_name)->select('id')->first()['id']);
        $peminjaman_detail->keterangan = 'selesai';
        $peminjaman_detail->save();

        $peminjaman = Peminjaman::where('id', $peminjaman_detail->id_peminjaman)->first();
        $peminjaman->denda = $request->denda;
        $peminjaman->tgl_pengembalian = $request->tgl_pengembalian;
        $peminjaman->save();

        Alert::toast('Success add Pengembalian', 'success');
        return back();
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_member' => 'required',
            'isbn' => 'required',
            'id_peminjaman' => 'required',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date'
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        $peminjaman = Peminjaman::findOrFail($request->id_peminjaman);
        $peminjaman->tgl_pinjam = $request->tanggal_pinjam;
        $peminjaman->tgl_kembali = $request->tanggal_kembali;
        $peminjaman->save();

        $peminjaman_detail = DetailPeminjaman::where('id_peminjaman', $peminjaman->id)->first();
        $peminjaman_detail->id_user = $request->id_member;
        $peminjaman_detail->id_buku = Bukus::where('isbn', $request->isbn)->select('id')->first()['id'];
        $peminjaman_detail->keterangan = 'pinjam';
        $peminjaman_detail->save();

        Alert::toast('Success Update Peminjaman', 'success');
        return back();
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_peminjaman'
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        Peminjaman::where('id', $request->id_peminjaman)->delete();
        DetailPeminjaman::where('id_peminjaman', $request->id_peminjaman)->delete();

        Alert::toast('Success Delete Peminjaman', 'success');
        return back();
    }
}
