<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JenisRab;
use Illuminate\Http\Request;

class JenisRabController extends Controller
{
    public function index()
    {
        $jenisrab = JenisRab::all();

        //return collection of items as a resource
        return  response()->json(['data' => $jenisrab, 'message' => 'List Data JenisRab', 'status' => 200], 200);
    }

    public function store(Request $request)
    {
        //create item
        $jenisrab = JenisRab::create([
            'jenis'     => $request->jenis,
        ]);

        //return response
        if ($jenisrab)
            return  response()->json(['data' => $jenisrab, 'message' => 'Data berhasil ditambahkan', 'status' => 200], 200);
        else
            return  response()->json(['data' => $jenisrab, 'message' => 'Data gagal ditambahkan', 'status' => 403], 403);
    }

    public function update(Request $request, $id)
    {
        //create item
        $jenisrab = JenisRab::where('id', $id)->first();

        //return response
        if ($jenisrab) {
            $jenisrab->update([
                'jenis' => $request->jenis
            ]);
            return  response()->json(['data' => $jenisrab, 'message' => 'Data berhasil diubah', 'status' => 200], 200);
        } else
            return  response()->json(['data' => $jenisrab, 'message' => 'Data gagal diubah', 'status' => 403], 403);
    }

    public function delete($id)
    {
        //create item
        $jenisrab = JenisRab::find($id);

        //return response
        if ($jenisrab) {
            $jenisrab->delete();
            return  response()->json(['data' => $jenisrab, 'message' => 'Data berhasil dihapus', 'status' => 200], 200);
        } else
            return  response()->json(['data' => $jenisrab, 'message' => 'Data gagal dihapus', 'status' => 403], 403);
    }
}
