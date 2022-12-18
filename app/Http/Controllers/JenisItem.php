<?php

namespace App\Http\Controllers;

use App\Models\JenisItem as ModelsJenisItem;

class JenisItem extends Controller
{
    public function index()
    {
        $jenis = ModelsJenisItem::all();
        $title = 'Jenis Item';
        return view('jenis_item.index', compact(['jenis', 'title']));
    }

    public function show($id = null)
    {
        $jenis = ModelsJenisItem::where('id', $id)->first();
        return view('jenis_item.detail', compact(['jenis']));
    }
}
