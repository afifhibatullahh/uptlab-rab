<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManajemenUserController extends Controller
{
    public function index()
    {
        $users = DB::table('users')->select('name', 'email', 'role', 'id')->where('role', '!=', 'super admin')->get()->toArray();

        //return collection of items as a resource
        return  response()->json(['data' => $users, 'message' => 'List Data Users', 'status' => 200], 200);
    }

    public function delete($id)
    {
        //create item
        $user = User::find($id);

        //return response
        if ($user) {
            $user->delete();
            return  response()->json(['data' => $user, 'message' => 'Data berhasil dihapus', 'status' => 200], 200);
        } else
            return  response()->json(['data' => $user, 'message' => 'Data gagal dihapus', 'status' => 403], 403);
    }
}
