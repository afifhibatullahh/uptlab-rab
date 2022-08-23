<?php

namespace App\Http\Controllers;

use App\Models\Item as ModelsItem;
use Illuminate\Http\Request;

class Item extends Controller
{
    public function index()
    {
        $item = ModelsItem::all();
        return view('item.index', compact(['item']));
    }

    public function add()
    {
        return view('item.add');
    }
    public function edit($id = null)
    {
        if ($id !== null) {
            $item = ModelsItem::where('id', $id)->first();
            return view('item.edit',  compact(['item']));
        }
        return redirect('/barang');
    }
    public function show($id = null)
    {
        $item = ModelsItem::where('id', $id)->first();
        return view('item.detail', compact(['item']));
    }

    public function store(Request $request, $id = null)
    {
        $data = [
            'nama_barang' => $request->nama,
            'spesifikasi' => $request->spesifikasi,
            'satuan' => $request->satuan,
            'harga' => $request->harga,
            'sumber' => $request->sumber,
            'gambar' => $request->gambar,
            'jenis' => $request->jenis,
        ];
        if ($id == null) {
            ModelsItem::create($data);

            return redirect('/barang');
        } else {
            $item = ModelsItem::find($id);
            $item->update($data);
            return redirect('/barang');
        }
    }

    public function delete($id)
    {
        ModelsItem::destroy($id);
        return redirect('/barang');
    }
}
