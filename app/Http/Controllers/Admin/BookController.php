<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bukus;
use App\Models\DetailPeminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class BookController extends Controller
{
    public function index()
    {
        $active = 'book';
        $data = Bukus::all();
        $peminjaman = DetailPeminjaman::with('Buku')->select('keterangan', 'id_buku');
        // Bukus::withTrashed()->restore();
        return view('admin.page.book', compact('active', 'data', 'peminjaman'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'isbn' => 'required',
            'judul' => 'required',
            // 'gmd' => 'required',
            'edisi' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required',
            // 'tempat_penerbit' => 'required',
            'deskripsi_fisik' => 'required',
            // 'judul_seri' => 'required',
            // 'nomor_panggilan' => 'required',
            'bahasa' => 'required',
            // 'no_klas' => 'required',
            'pengarang' => 'required',
        ]);

        if ($validator->fails()) {
            // Alert::toast($validator->messages()->all(), 'error');
            dd($validator->messages()->all());
            return back()->withInput();
        }

        $book = new Bukus();
        $book->isbn = $request->isbn;
        $book->judul = $request->judul;
        $book->gmd = $request->gmd;
        $book->edisi = $request->edisi;
        $book->penerbit = $request->penerbit;
        $book->tahun_terbit = $request->tahun_terbit;
        $book->tempat_terbit = $request->tempat_penerbit;
        $book->deskripsi_fisik = $request->deskripsi_fisik;
        $book->judul_seri = $request->judul_seri;
        $book->nomor_panggil = $request->nomor_panggilan;
        $book->bahasa = $request->bahasa;
        $book->no_klas = $request->no_klas;
        $book->pengarang = $request->pengarang;
        $book->save();
        // $book->save($request->all());

        Alert::toast('Success Add data', 'success');
        return back();
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'isbn' => 'required',
            'judul' => 'required',
            // 'gmd' => 'required',
            'edisi' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required',
            // 'tempat_penerbit' => 'required',
            'deskripsi_fisik' => 'required',
            // 'judul_seri' => 'required',
            // 'nomor_panggilan' => 'required',
            'bahasa' => 'required',
            // 'no_klas' => 'required',
            'pengarang' => 'required',
        ]);

        if ($validator->fails()) {
            // Alert::toast($validator->messages()->all(), 'error');
            dd($validator->messages()->all());
            return back()->withInput();
        }

        $book = Bukus::findOrFail($request->id);
        $book->update($request->all());

        Alert::toast('Success Update data', 'success');
        return back();
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        $book = Bukus::findOrFail($request->id);
        $book->delete();

        Alert::toast('Success Delete data', 'success');
        return back();
    }
}
