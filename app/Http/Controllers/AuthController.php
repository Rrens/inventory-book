<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard.index');
        }
        return view('admin.auth.login');
    }

    public function post_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all(), 'Error');
            return back()->withInput();
        }

        $data = [
            'username' => $request->username,
            'password' => $request->password
        ];
        // dd(!Auth::attempt());

        if (!Auth::attempt($data)) {
            Session::flash('error', 'Username or Password is wrong');
            Alert::error(
                'error',
                'Username or Password is wrong'
            );
            return redirect()->route('login');
        }

        return redirect()->route('admin.dashboard.index');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
