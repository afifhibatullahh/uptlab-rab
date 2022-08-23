<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Rab extends Controller
{
    public function index()
    {
        return view('rab.index');
    }

    public function add()
    {
        return view('rab.add');
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
