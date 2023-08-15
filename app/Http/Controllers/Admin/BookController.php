<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $active = 'book';
        return view('admin.page.book', compact('active'));
    }

    public function peminjaman_buku()
    {
        $active = 'peminjaman';
        return view('admin.page.Peminjaman', compact('active'));
    }
}
