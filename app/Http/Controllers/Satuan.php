<?php

namespace App\Http\Controllers;

use App\Models\Satuan as ModelsSatuan;
use Illuminate\Http\Request;

class Satuan extends Controller
{
    public function index()
    {
        $satuan = ModelsSatuan::all();
        $title = 'Satuan';
        return view('satuan.index', compact(['satuan', 'title']));
    }

    public function show($id = null)
    {
        $satuan = ModelsSatuan::where('id', $id)->first();
        return view('satuan.detail', compact(['satuan']));
    }
}
