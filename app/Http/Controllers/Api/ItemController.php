<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Http\Request;
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
        //define validation rules
        // $validator = Validator::make($request->all(), [
        //     'nama_barang'     => 'required',
        //     'satuan'   => 'required',
        //     'jenis'   => 'required',
        //     'sumber'   => 'required',
        //     'harga'   => 'required',
        // ]);
        // //check if validation fails
        // if ($validator) {
        //     return new ItemResource([], 403, response()->json($validator->errors(), 422));
        // }

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
            'jenis'   => $request->jenis,
            'sumber'   => $request->sumber,
            'harga'   => $request->harga,
            'spesifikasi'   => $request->spesifikasi,
        ]);

        //return response
        return new ItemResource($item, 200, 'Data item Berhasil Ditambahkan!');
    }
}
