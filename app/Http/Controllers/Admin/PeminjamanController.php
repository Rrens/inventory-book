<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        $active = 'peminjaman';
        return view('admin.page.Peminjaman', compact('active'));
    }
}
