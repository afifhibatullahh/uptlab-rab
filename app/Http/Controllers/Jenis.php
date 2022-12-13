<?php

namespace App\Http\Controllers;

use App\Models\Jenis as ModelsJenis;
use Illuminate\Http\Request;

class Jenis extends Controller
{
    public function index()
    {
        $jenis = ModelsJenis::all();
        $title = 'Jenis Item';
        return view('jenis.index', compact(['jenis', 'title']));
    }

    public function show($id = null)
    {
        $jenis = ModelsJenis::where('id', $id)->first();
        return view('jenis.detail', compact(['jenis']));
    }
}
