<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    public function index()
    {
        //get items
        $item = Item::all();

        //return collection of items as a resource
        return new ItemResource($item, 200, 'List Data item',);
    }

    public function store(Request $request)
    {
        //upload image
        $image = $request->file('gambar');
        $imageName = 'default.jpg';
        if (!empty($image)) {
            $imageName =  $image->hashName();
            $image->move(public_path('/assets/images/item'), $imageName);
        }

        //create item
        $item = Item::create([
            'gambar'     => $imageName,
            'nama_barang'     => $request->nama_barang,
            'satuan'   => $request->satuan,
            'jenis_item'   => $request->jenis_item,
            'sumber'   => $request->sumber,
            'harga_satuan'   => $request->harga_satuan,
            'spesifikasi'   => $request->spesifikasi,
        ]);

        //return response
        return new ItemResource($item, 200, 'Data item Berhasil Ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        //create item
        $item = Item::where('id', $id)->first();

        $image_name = Item::find($id)['gambar'];


        $image = $request->file('gambar');

        if (!empty($image)) {

            if (File::exists(\public_path(('assets/images/item/' . $image_name))) && $image_name !== 'default.jpg') {
                File::delete(\public_path('assets/images/item/' . $image_name));
            }

            $image_name = $image->hashName();
            $image->move(public_path('/assets/images/item'), $image_name);
        }


        //return response
        if ($item) {
            $item->update([
                'gambar'     => $image_name,
                'nama_barang'     => $request->nama_barang,
                'satuan'   => $request->satuan,
                'sumber'   => $request->sumber,
                'jenis_item'   => $request->jenis_item,
                'harga_satuan'   => $request->harga_satuan,
                'spesifikasi'   => $request->spesifikasi,
            ]);
            return  response()->json(['data' => $item, 'message' => 'Data berhasil diubah', 'status' => 200], 200);
        } else
            return  response()->json(['data' => $item, 'message' => 'Data gagal diubah', 'status' => 403], 403);
    }

    public function delete($id)
    {
        //create item
        $item = Item::find($id);

        //return response
        if ($item) {
            $item->delete();
            return  response()->json(['data' => $item, 'message' => 'Data berhasil dihapus', 'status' => 200], 200);
        } else
            return  response()->json(['data' => $item, 'message' => 'Data gagal dihapus', 'status' => 403], 403);
    }
}
