<?php

namespace App\Http\Controllers;

use App\Models\Item as ModelsItem;
use Illuminate\Http\Request;

class Item extends Controller
{
    public function index()
    {
        $item = ModelsItem::all();
        $title = 'Item';
        return view('item.index', compact(['item', 'title']));
    }

    public function show($id = null)
    {
        $item = ModelsItem::where('id', $id)->first();
        return view('item.detail', compact(['item']));
    }
}
