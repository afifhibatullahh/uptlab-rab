<?php

namespace App\Http\Controllers;

use App\Models\Laboratorium as ModelsLaboratorium;
use Illuminate\Http\Request;

class Laboratorium extends Controller
{
    public function index()
    {
        $laboratorium = ModelsLaboratorium::all();
        $title = 'Laboratorium';
        return view('laboratorium.index', compact(['laboratorium', 'title']));
    }

    public function show($id = null)
    {

        $laboratorium = ModelsLaboratorium::where('id', $id)->first();
        $title = 'Laboratorium ' . $laboratorium->laboratorium;

        return view('laboratorium.anggaran', compact(['laboratorium', 'title', 'id']));
    }
}
