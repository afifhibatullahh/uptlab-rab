<?php

namespace App\Http\Controllers;

use App\Models\JenisRab;
use App\Models\Laboratorium;
use App\Models\Rab as ModelsRab;
use App\Models\RabDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            ->join('jenis_item', 'items.jenis_item', '=', 'jenis_item.id')
            ->select('nama_barang', 'harga_satuan', 'items.id', 'jenis_item.jenis', 'satuan.satuan')
            ->get();


        $jenisrabs = JenisRab::all();
        $laboratorium = Laboratorium::all();


        $listItems =  json_encode($items);

        return view('rab.add', \compact(['listItems', 'jenisrabs', 'laboratorium']));
    }

    public function edit($id = null)
    {
        $rab = DB::table('rabs')
            ->select('*')
            ->where('rabs.id', $id)
            ->first();

        $rabdetail = DB::table('rabdetails')
            ->join('items', 'items.id', '=', 'rabdetails.id_item')
            ->join('jenis_item', 'jenis_item.id', '=', 'items.jenis_item')
            ->select('rabdetails.*', 'jenis_item.jenis as jenis_item', 'items.nama_barang', 'items.harga_satuan', 'items.sumber')
            ->where('rab_id_ref', $id)
            ->orderBy('nama_barang', 'asc')->get();


        $items = DB::table('items')
            ->join('satuan', 'items.satuan', '=', 'satuan.id')
            ->join('jenis_item', 'items.jenis_item', '=', 'jenis_item.id')
            ->select('nama_barang', 'harga_satuan', 'items.id', 'jenis_item.jenis', 'satuan.satuan')
            ->get();

        $total1 = 0;
        foreach ($rabdetail as $data) {
            $total1 += $data->jumlah_harga;
        }
        $total1 = \round($total1);
        $expenses = \round($total1 * 0.1);
        $total2 = $total1 + $expenses;
        $tax = \round($total2 * 0.11);
        $total_rab = $total2 + $tax;

        $summary = [
            'rab' => $rab,
            'rabdetail' => $rabdetail,
            'total1' => $total1,
            'expenses' => $expenses,
            'total2' => $total2,
            'tax' => $tax,
            'total_rab' => $total_rab,
        ];


        $jenisrabs = JenisRab::all();
        $laboratorium = Laboratorium::all();


        $listItems =  json_encode($items);
        $rabdetail =  json_encode($rabdetail);

        return view('rab.edit',  \compact(['rab', 'rabdetail', 'listItems', 'jenisrabs', 'laboratorium', 'summary']));
    }

    public function show($id = null)
    {


        $rab = DB::table('rabs')
            ->join('jenis_rab', 'rabs.jenis_rab', '=', 'jenis_rab.id')
            ->join('laboratorium', 'rabs.laboratorium', '=', 'laboratorium.id')
            ->select('rabs.*', 'jenis_rab.jenis as jenis_rab', 'laboratorium.laboratorium')
            ->where('rabs.id', $id)
            ->first();

        $rabdetail = DB::table('rabdetails')
            ->join('items', 'items.id', '=', 'rabdetails.id_item')
            ->join('jenis_item', 'jenis_item.id', '=', 'items.jenis_item')
            ->select('rabdetails.*', 'jenis_item.jenis as jenis_item', 'items.nama_barang', 'items.gambar', 'items.harga_satuan', 'items.sumber')
            ->where('rab_id_ref', $id)
            ->orderBy('nama_barang', 'asc')->get();

        $total1 = 0;
        foreach ($rabdetail as $data) {
            $total1 += $data->jumlah_harga;
        }
        $total1 = \round($total1);
        $expenses = \round($total1 * 0.1);
        $total2 = $total1 + $expenses;
        $tax = \round($total2 * 0.11);
        $total_rab = $total2 + $tax;

        $summary = [
            'rab' => $rab,
            'rabdetail' => $rabdetail,
            'total1' => $total1,
            'expenses' => $expenses,
            'total2' => $total2,
            'tax' => $tax,
            'total_rab' => $total_rab,
        ];

        $rabToJson = \json_encode($summary);

        return view('rab.detail', \compact(['rab', 'rabdetail', 'summary', 'rabToJson']));
    }
}
