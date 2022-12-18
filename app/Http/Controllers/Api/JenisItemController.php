<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JenisItem;
use Illuminate\Http\Request;

class JenisItemController extends Controller
{
    public function index()
    {
        $jenis = JenisItem::all();


        //return collection of items as a resource
        return  response()->json(['data' => $jenis, 'message' => 'List Data Jenis', 'status' => 200], 200);
    }

    public function store(Request $request)
    {
        //create item
        $jenis = JenisItem::create([
            'jenis'     => $request->jenis,
        ]);

        //return response
        if ($jenis)
            return  response()->json(['data' => $jenis, 'message' => 'Data berhasil ditambahkan', 'status' => 200], 200);
        else
            return  response()->json(['data' => $jenis, 'message' => 'Data gagal ditambahkan', 'status' => 403], 403);
    }

    public function update(Request $request, $id)
    {
        //create item
        $jenis = JenisItem::where('id', $id)->first();

        //return response
        if ($jenis) {
            $jenis->update([
                'jenis' => $request->jenis
            ]);
            return  response()->json(['data' => $jenis, 'message' => 'Data berhasil diubah', 'status' => 200], 200);
        } else
            return  response()->json(['data' => $jenis, 'message' => 'Data gagal diubah', 'status' => 403], 403);
    }

    public function delete($id)
    {
        //create item
        $jenis = JenisItem::find($id);

        //return response
        if ($jenis) {
            $jenis->delete();
            return  response()->json(['data' => $jenis, 'message' => 'Data berhasil dihapus', 'status' => 200], 200);
        } else
            return  response()->json(['data' => $jenis, 'message' => 'Data gagal dihapus', 'status' => 403], 403);
    }
}
