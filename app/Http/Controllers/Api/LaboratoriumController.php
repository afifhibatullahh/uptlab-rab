<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Laboratorium;
use Illuminate\Http\Request;

class LaboratoriumController extends Controller
{
    public function index()
    {
        $laboratorium = Laboratorium::all();


        //return collection of items as a resource
        return  response()->json(['data' => $laboratorium, 'message' => 'List Data Laboratorium', 'status' => 200], 200);
    }

    public function store(Request $request)
    {
        //create item
        $laboratorium = Laboratorium::create([
            'laboratorium'     => $request->laboratorium,
        ]);

        //return response
        if ($laboratorium)
            return  response()->json(['data' => $laboratorium, 'message' => 'Data berhasil ditambahkan', 'status' => 200], 200);
        else
            return  response()->json(['data' => $laboratorium, 'message' => 'Data gagal ditambahkan', 'status' => 403], 403);
    }

    public function update(Request $request, $id)
    {
        //create item
        $laboratorium = Laboratorium::where('id', $id)->first();

        //return response
        if ($laboratorium) {
            $laboratorium->update([
                'laboratorium' => $request->laboratorium
            ]);
            return  response()->json(['data' => $laboratorium, 'message' => 'Data berhasil diubah', 'status' => 200], 200);
        } else
            return  response()->json(['data' => $laboratorium, 'message' => 'Data gagal diubah', 'status' => 403], 403);
    }

    public function delete($id)
    {
        //create item
        $laboratorium = Laboratorium::find($id);

        //return response
        if ($laboratorium) {
            $laboratorium->delete();
            return  response()->json(['data' => $laboratorium, 'message' => 'Data berhasil dihapus', 'status' => 200], 200);
        } else
            return  response()->json(['data' => $laboratorium, 'message' => 'Data gagal dihapus', 'status' => 403], 403);
    }
}
