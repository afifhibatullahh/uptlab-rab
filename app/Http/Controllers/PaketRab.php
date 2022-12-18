<?php

namespace App\Http\Controllers;

use App\Models\JenisRab;
use App\Models\Rab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaketRab extends Controller
{
    public function index()
    {
        $title = 'Laporan Paket Rencana Anggaran Belanja';
        return view('paket_rab.index', \compact(['title']));
    }

    public function add()
    {

        $rabs = DB::table('rabs')
            ->join('laboratorium', 'rabs.laboratorium', '=', 'laboratorium.id')
            ->join('jenis_rab', 'rabs.jenis_rab', '=', 'jenis_rab.id')
            ->select('title', 'nomor_akun', 'waktu_pelaksanaan as tanggal', 'rabs.id', 'jenis_rab.jenis as jenis_rab', 'laboratorium.laboratorium')
            ->get();


        $jenisrabs = JenisRab::all();

        $listRabs =  json_encode($rabs);

        return view('paket_rab.add', \compact(['rabs', 'jenisrabs', 'listRabs']));
    }

    public function show($id = null)
    {


        $paket = DB::table('pakets')
            ->join('jenis_rab', 'pakets.jenis_pengadaan', '=', 'jenis_rab.id')
            ->select('pakets.*', 'jenis_rab.jenis as jenis_pengadaan')
            ->where('pakets.id', $id)
            ->first();

        $rabdetail = DB::table('paket_rab_details')
            ->join('rabs', 'rabs.id', '=', 'paket_rab_details.id_rab')
            ->join('jenis_rab', 'jenis_rab.id', '=', 'rabs.jenis_rab')
            ->join('laboratorium', 'laboratorium.id', '=', 'rabs.laboratorium')
            ->select('rabs.*', 'jenis_rab.jenis as jenis_rab', 'laboratorium.laboratorium as laboratorium',)
            ->where('id_paket', $id)
            ->get()->toArray();

        $rab_items = [];

        foreach ($rabdetail as $rab) {
            $rab_items[] = [
                'laboratorium' => $rab->laboratorium,
                'items' => DB::table('rabdetails')
                    ->join('items', 'items.id', '=', 'rabdetails.id_item')
                    ->join('jenis_item', 'jenis_item.id', '=', 'items.jenis_item')
                    ->select('rabdetails.*', 'jenis_item.jenis as jenis_item', 'items.nama_barang', 'items.harga_satuan', 'items.sumber', 'items.spesifikasi')
                    ->where('rab_id_ref', $rab->id)
                    ->get()->toArray()
            ];
        }

        $paketToJson = [];
        $filteredItems = [];

        foreach ($rab_items as $items) {
            $lab = ($items['laboratorium']);
            foreach ($items['items'] as $item) {
                $item->laboratorium = $lab;
                $filteredItems[] = $item;
                $paketToJson[$item->jenis_item][] = $item;
            }
        }

        return view('paket_rab.detail', \compact(['paket', 'rabdetail', 'filteredItems', 'paketToJson']));
    }
}
