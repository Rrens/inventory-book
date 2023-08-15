<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboadController extends Controller
{
    public function index()
    {
        $active = 'dashboard';
        return view('admin.page.dashboard', compact('active'));
    }
}
