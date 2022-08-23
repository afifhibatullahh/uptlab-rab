<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaketRab extends Controller
{
    public function index()
    {
        return view('paket_rab.index');
    }

    public function add()
    {
        return view('paket_rab.add');
    }
    public function edit($id = null)
    {
        return view('paket_rab.edit',  ['id' => $id]);
    }
    public function show($id = null)
    {
        return view('paket_rab.detail', ['id' => $id]);
    }
}
