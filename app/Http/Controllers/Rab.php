<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Rab extends Controller
{
    public function index()
    {
        $title = 'Rencana Anggaran Belanja';
        return view('rab.index', \compact(['title']));
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
