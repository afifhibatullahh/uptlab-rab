<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Rab extends Controller
{
    public function index()
    {
        $title = 'Rencana Anggaran Belanja';
        return view('rab.index', \compact(['title']));
    }

    public function add()
    {
        $items = DB::table('items')
            ->join('satuan', 'items.satuan', '=', 'satuan.id')
            ->join('jenis', 'items.jenis', '=', 'jenis.id')
            ->select('nama_barang', 'harga', 'items.id', 'jenis.jenis', 'satuan.satuan')
            ->get();

        $listItems =  json_encode($items);
        return view('rab.add', \compact(['listItems']));
    }
    public function edit($id = null)
    {
        return view('rab.edit',  ['id' => $id]);
    }
    public function show($id = null)
    {
        return view('rab.detail', ['id' => $id]);
    }
}
