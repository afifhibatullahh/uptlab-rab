<?php

namespace App\Http\Controllers;

use App\Models\JenisRab;
use App\Models\Rab as ModelsRab;
use App\Models\RabDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Rab extends Controller
{
    public function index()
    {
        $title = 'Rencana Anggaran Belanja';
        return view('rab.index', \compact(['title']));
    }

    public function add()
    {
        $items = DB::table('items')
            ->join('satuan', 'items.satuan', '=', 'satuan.id')
            ->join('jenis', 'items.jenis', '=', 'jenis.id')
            ->select('nama_barang', 'harga', 'items.id', 'jenis.jenis', 'satuan.satuan')
            ->get();


        $jenisrabs = JenisRab::all();


        $listItems =  json_encode($items);

        return view('rab.add', \compact(['listItems', 'jenisrabs']));
    }

    public function edit($id = null)
    {
        $rab = DB::table('rabs')
            ->join('jenisrab', 'rabs.jenis', '=', 'jenisrab.id')
            ->select('rabs.*', 'jenisrab.jenisrab as jenis',)
            ->where('rabs.id', $id)
            ->get();

        $rabdetail = DB::table('rabdetails')
            ->join('items', 'items.id', '=', 'rabdetails.id_item')
            ->join('jenis', 'jenis.id', '=', 'items.jenis')
            ->select('rabdetails.*', 'jenis.jenis as jenis', 'items.nama_barang', 'items.harga as harga_satuan', 'items.sumber')
            ->where('rab_id_ref', $id)->get();

        $items = DB::table('items')
            ->join('satuan', 'items.satuan', '=', 'satuan.id')
            ->join('jenis', 'items.jenis', '=', 'jenis.id')
            ->select('nama_barang', 'harga', 'items.id', 'jenis.jenis', 'satuan.satuan')
            ->get();

        $jenisrabs = JenisRab::all();


        $listItems =  json_encode($items);
        $rabdetail =  json_encode($rabdetail);

        return view('rab.edit',  \compact(['rab', 'rabdetail', 'listItems', 'jenisrabs']));
    }

    public function show($id = null)
    {

        $rab = DB::table('rabs')
            ->join('jenisrab', 'rabs.jenis', '=', 'jenisrab.id')
            ->select('rabs.*', 'jenisrab.jenisrab as jenis',)
            ->where('rabs.id', $id)
            ->first();

        $rabdetail = DB::table('rabdetails')
            ->join('items', 'items.id', '=', 'rabdetails.id_item')
            ->join('jenis', 'jenis.id', '=', 'items.jenis')
            ->select('rabdetails.*', 'jenis.jenis as jenis', 'items.nama_barang', 'items.harga as harga_satuan', 'items.sumber')
            ->where('rab_id_ref', $id)
            ->orderBy('nama_barang', 'asc')->get();

        $subtotal = 0;
        $tax = 0;
        foreach ($rabdetail as $data) {
            $subtotal += $data->netamount;

            if ($data->pajak > 0) {
                $tax +=  $data->netamount / $data->pajak;
            }
        }
        $subtotal = \round($subtotal);
        $tax = \round($tax);
        $total = $subtotal - $tax;

        $rabToJson = \json_encode([
            'rab' => $rab,
            'rabdetail' => $rabdetail,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
        ]);

        return view('rab.detail', \compact(['rab', 'rabdetail', 'total', 'subtotal', 'tax', 'rabToJson']));
    }
}
