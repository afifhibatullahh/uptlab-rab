<?php

namespace App\Http\Controllers;

use App\Models\JenisRab as ModelsJenisRab;
use Illuminate\Http\Request;

class JenisRab extends Controller
{
    public function index()
    {
        $jenisrab = ModelsJenisRab::all();
        $title = 'Jenis RAB';
        return view('jenis_rab.index', compact(['jenisrab', 'title']));
    }

    public function show($id = null)
    {
        $jenisrab = ModelsJenisRab::where('id', $id)->first();
        return view('jenis_rab.detail', compact(['jenisrab']));
    }
}
