<?php

namespace App\Http\Controllers;

use App\Models\Laboratorium;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ManajemenUser extends Controller
{
    public function users()
    {
        $title = 'List User';

        $users = DB::table('users')->select('name', 'email', 'role', 'id')->where('role', '!=', 'super admin')->get()->toArray();

        return view('manajemen_user.users.index', \compact(['title', 'users']));
    }

    public function addUser()
    {
        $title = 'Tambah User';

        $laboratorium = Laboratorium::all()->toArray();

        return view('manajemen_user.users.add', \compact(['title', 'laboratorium']));
    }

    public function storeUser(Request $request)
    {
        $email = $request->email;
        $name = $request->name;
        $laboratorium = $request->laboratorium;
        $password = $request->password;

        $isRegistered = DB::table('users')->where('email', $email)->first();

        if ($isRegistered) {
            return redirect()->back()->withInput()->with('error_email', 'Email telah digunakan');
        }

        User::create([
            'email'     => $email,
            'name'     => $name,
            'laboratorium'     => $laboratorium,
            'password'     =>  Hash::make($password),
            'role'     => 'admin',
        ]);

        return redirect('users');
    }

    public function deleteUser()
    {
    }

    public function account()
    {
        $title = 'Profile';
        return view('manajemen_user.account.index', \compact(['title']));
    }

    public function editAccount()
    {
        $title = 'Edit Profile';
        return view('manajemen_user.account.edit', \compact(['title']));
    }

    public function updateAccount()
    {
    }
}
