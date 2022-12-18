<?php

namespace App\Http\Controllers;

use App\Models\Item as ModelsItem;
use App\Models\Jenis as ModelsJenis;
use App\Models\Satuan as ModelsSatuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Item extends Controller
{
    public function index()
    {
        $item = ModelsItem::all();
        $title = 'Item';
        $satuan = DB::table('satuan')
            ->select('satuan as label', 'id as value')
            ->get();
        $jenis = DB::table('jenis_item')
            ->select('jenis as label', 'id as value')
            ->get();

        $listJenis =  json_encode($jenis);
        $listSatuan =  json_encode($satuan);

        return view('item.index', compact(['item', 'title', 'listSatuan', 'listJenis']));
    }

    public function show($id = null)
    {
        $item = ModelsItem::where('id', $id)->first();
        return view('item.detail', compact(['item']));
    }
}
