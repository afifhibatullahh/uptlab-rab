<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Satuan;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    public function index()
    {
        $satuan = Satuan::all();


        //return collection of items as a resource
        return  response()->json(['data' => $satuan, 'message' => 'List Data Satuan', 'status' => 200], 200);
    }

    public function store(Request $request)
    {
        //create item
        try {
            $satuan = Satuan::create([
                'satuan'     => $request->satuan,
            ]);
        } catch (\Throwable $th) {
            return  response()->json(['message' => 'Data gagal ditambahkan', 'status' => 403], 403);
        }

        return  response()->json(['data' => $satuan, 'message' => 'Data berhasil ditambahkan', 'status' => 200], 200);
    }

    public function update(Request $request, $id)
    {
        //create item
        $satuan = Satuan::where('id', $id)->first();

        //return response
        if ($satuan) {
            $satuan->update([
                'satuan' => $request->satuan
            ]);
            return  response()->json(['data' => $satuan, 'message' => 'Data berhasil diubah', 'status' => 200], 200);
        } else
            return  response()->json(['data' => $satuan, 'message' => 'Data gagal diubah', 'status' => 403], 403);
    }

    public function delete($id)
    {
        //create item
        $satuan = Satuan::find($id);

        //return response
        if ($satuan) {
            $satuan->delete();
            return  response()->json(['data' => $satuan, 'message' => 'Data berhasil dihapus', 'status' => 200], 200);
        } else
            return  response()->json(['data' => $satuan, 'message' => 'Data gagal dihapus', 'status' => 403], 403);
    }
}
