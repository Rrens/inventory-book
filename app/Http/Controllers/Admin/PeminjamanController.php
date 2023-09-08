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
        // dd($data);
        foreach ($data as $item) {
            if ($item->Peminjaman[0]->tgl_kembali < Carbon::today()->toDateString()) {
                DetailPeminjaman::where('id', $item->id)->update(['keterangan' => 'Telat']);
            } else if ($item->keterangan == 'kembali') {
                // dd('ini');
                DetailPeminjaman::where('id', $item->id)->update(['keterangan' => 'kembali']);
            } else {
                DetailPeminjaman::where('id', $item->id)->update(['keterangan' => 'pinjam']);
            }
        }
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
            $book = Bukus::where('isbn', $isbn)->select('isbn', 'judul', 'id')->first();
            if (!empty(DetailPeminjaman::where('id_buku', $book->id)->where('keterangan', 'pinjam')->first())) {
                return response()->json([
                    'status' => 'Failed',
                    'keterangan' => 'Buku Masih dipinjam'
                ], 200);
            }
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

    public function get_book_for_pengembalian($member_name, $isbn)
    {
        try {
            $user = User::where('username', $member_name)->first();
            $buku = Bukus::Where('isbn', $isbn)->select('id')->first();

            if (empty($buku) || empty($user)) {
                return response()->json([
                    'status' => 'Failed',
                    'keterangan' => 'Buku tidak ditemukan'
                ], 200);
            }

            $detail_buku = DetailPeminjaman::with('Buku')
                ->where('id_user', $user->id)
                ->where('id_buku', $buku->id)
                ->where('keterangan', 'pinjam')
                ->latest()
                ->first();

            $check_telat = DetailPeminjaman::with('Buku')
                ->where('id_user', $user->id)
                ->where('id_buku', $buku->id)
                ->where('keterangan', 'Telat')
                ->latest()
                ->first();

            // dd($check_telat);

            if (!empty($check_telat)) {
                return response()->json([
                    'status' => 'Success',
                    'data_buku' => $check_telat
                ], 200);
            }


            if (empty($detail_buku)) {
                return response()->json([
                    'status' => 'Failed',
                    'keterangan' => 'Bukan ini buku yang dipinjaman'
                ], 200);
            }
            return response()->json([
                'status' => 'Success',
                'data_buku' => $detail_buku
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
            if (empty($user)) {
                return response()->json([
                    'status' => 'Failed',
                    'keterangan' => 'Nama User tidak ditemukan'
                ], 200);
            }

            if (empty(DetailPeminjaman::where('id_user', $user->id)->select('keterangan')->first())) {
                return response()->json([
                    'status' => 'Failed',
                    'keterangan' => 'Tidak ada pinjaman'
                ], 200);
            }

            $peminjaman_detail = DetailPeminjaman::with('peminjaman', 'Buku')->whereHas('Peminjaman', function ($query) {
                $query->select('tgl_kembali', 'tgl_pinjam');
            })
                ->where('id_user', $user->id)
                ->first();
            $detail_riwayat = DetailPeminjaman::where('id_user', $user->id)
                ->where('keterangan', 'pinjam')
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

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        if ($request->tanggal_kembali < Carbon::today()->toDateString()) {
            Alert::toast('Tanggal kembali tidak sebelum hari ini', 'error');
            return back()->withInput();
        }

        $buku = DetailPeminjaman::where('id_buku', Bukus::where('isbn', $request->isbn)->select('keterangan', 'id')->first()['id'])->first();

        if (!empty($buku) && $buku->keterangan == 'pinjam') {
            Alert::toast('Buku Masih dipinjam', 'error');
            return back()->withInput();
        }

        $for_keterangan_buku = Bukus::where('isbn', $request->isbn)->first();
        $for_keterangan_buku->keterangan = 'pinjam';
        $for_keterangan_buku->save();

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

        Alert::toast('Sukses Meminjam', 'success');
        return back();
    }

    public function store_pengembalian(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'member_name' => 'required',
            'tgl_pengembalian' => 'required',
            // 'tgl_pinjam' => 'required',
            'isbn' => 'required',
            // 'judul_buku' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }
        try {
            //code...
            $buku = Bukus::where('isbn', $request->isbn)->first();

            $buku->keterangan = 'ready';
            $buku->save();

            $id_user = User::where('username', $request->member_name)
                ->select('id')
                ->first();

            DetailPeminjaman::where('id_user', $id_user->id)
                ->where('id_buku', $buku->id)
                ->update(['keterangan' => 'kembali']);


            $id_peminjaman = DetailPeminjaman::where('id_user', $id_user->id)
                ->where('id_buku', $buku->id)
                ->where('keterangan', 'kembali')
                ->first();

            $peminjaman = Peminjaman::where('id', $id_peminjaman->id_peminjaman)->first();
            $peminjaman->tgl_pengembalian = $request->tgl_pengembalian;
            $peminjaman->save();
        } catch (Exception $error) {
            dd($error);
        }

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
