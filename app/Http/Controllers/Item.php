<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Item extends Controller
{
    public function index()
    {
        return view('item.index');
    }

    public function add()
    {
        return view('item.add');
    }
    public function edit($id = null)
    {
        return view('item.edit',  ['id' => $id]);
    }
    public function show($id = null)
    {
        return view('item.detail', ['id' => $id]);
    }
}
