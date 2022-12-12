<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rab;
use Illuminate\Http\Request;

class RabController extends Controller
{
    public function index()
    {
        $rab = Rab::all();


        //return collection of items as a resource
        return  response()->json(['data' => $rab, 'message' => 'List Data Rab', 'status' => 200], 200);
    }


    public function delete($id)
    {
        //create item
        $rab = Rab::find($id);

        //return response
        if ($rab) {
            $rab->delete();
            return  response()->json(['data' => $rab, 'message' => 'Data berhasil dihapus', 'status' => 200], 200);
        } else
            return  response()->json(['data' => $rab, 'message' => 'Data gagal dihapus', 'status' => 403], 403);
    }
}
