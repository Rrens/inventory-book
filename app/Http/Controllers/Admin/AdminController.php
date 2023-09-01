<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    public function index()
    {
        // User::withTrashed()->restore();
        $active = 'user';
        $date = Carbon::now()->toDateString();
        $data = User::all();
        return view('admin.page.user', compact('active', 'date', 'data'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type_anggota' => 'required',
            // 'email' => 'email',
            'kode_pos' => 'numeric|digits:5',
            'jenis_user' => 'numeric',
            'alamat' => 'required',
            'nama_instansi' => 'required',
            'tgl_Lahir' => 'required|date',
            'username' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'password' => 'required'
        ]);

        if ($request->has('jenis_user')) {
            $validator = Validator::make($request->all(), [
                'type_anggota' => 'required',
                // 'email' => 'email',
                'kode_pos' => 'numeric|digits:5',
                'jenis_user' => 'numeric',
                'alamat' => 'required',
                'nama_instansi' => 'required',
                'tgl_Lahir' => 'required|date',
                'username' => 'required',
                'gender' => 'required',
                'phone' => 'required',
            ]);
        }

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->gender = $request->gender;
        // dd($user);
        $user->alamat = $request->alamat;
        $user->nama_instansi = $request->nama_instansi;
        if ($request->file('image')) {
            $image = $request->file('image');
            if ($request->jenis_user == 0) {
                $image_name = time() . '-admin-' . $request->username . '.' . $image->getClientOriginalExtension();
            } else {
                $image_name = time() . '-user-' . $request->username . '.' . $image->getClientOriginalExtension();
            }
            Storage::putFileAs('public/uploads/user/', $image, $image_name);
            $user->image = $image_name;
        }
        $user->phone = $request->phone;
        $user->kode_pos = $request->kode_pos;
        $user->jenis_user = $request->jenis_user;
        $user->type_anggota = $request->type_anggota;
        $user->tanggal_lahir = $request->tgl_Lahir;
        $user->tanggal_input = Carbon::now()->toDateString();
        $user->password = Hash::make($request->password);
        // dd($user);
        $user->save();

        Alert::toast('Success Add data', 'success');
        return back();
    }

    public function update(Request $request)
    {
        $commonRules = [
            'id' => 'required',
            // 'email' => 'email',
            'kode_pos' => 'numeric|digits:5',
            'jenis_user' => 'numeric',
            'alamat' => 'required',
            'nama_instansi' => 'required',
            'tgl_lahir' => 'required|date',
            'username' => 'required',
            'gender' => 'required',
            'phone' => 'required',
        ];

        $passwordRules = [
            'password' => 'required',
        ];

        $rules = [
            'type_anggota' => 'required',
        ];

        if ($request->has('type_anggota')) {
            $rules = array_merge($commonRules, $rules);
        }

        if (!empty($request->password)) {
            $rules = array_merge($commonRules, $passwordRules);
        }

        $validator = Validator::make($request->all(), $commonRules);



        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        $user =  User::findOrFail($request->id);
        $user->username = $request->username;
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->alamat = $request->alamat;
        $user->nama_instansi = $request->nama_instansi;
        if ($request->file('image')) {
            $image = $request->file('image');
            if ($request->jenis_user == 0) {
                $image_name = time() . '-admin-' . $request->username . '.' . $image->getClientOriginalExtension();
            } else {
                $image_name = time() . '-user-' . $request->username . '.' . $image->getClientOriginalExtension();
            }
            Storage::putFileAs('public/uploads/user/', $image, $image_name);
            $user->image = $image_name;
        }
        $user->phone = $request->phone;
        $user->kode_pos = $request->kode_pos;
        $user->jenis_user = $request->jenis_user;
        $user->type_anggota = $request->type_anggota;
        $user->tanggal_lahir = $request->tgl_lahir;
        $user->tanggal_input = Carbon::now()->toDateString();
        !empty($request->password) ? Hash::make($request->password) : '';
        // dd($user);
        $user->save();

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

        // dd($request->all());
        $user = User::where('id', $request->id)->delete();
        Alert::toast('Success Delete data', 'success');
        return back();
    }
}
