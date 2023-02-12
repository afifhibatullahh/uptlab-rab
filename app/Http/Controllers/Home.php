<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Home extends Controller
{
    public function index()
    {
        $total_rab = DB::table('rabs')->whereYear('waktu_pelaksanaan', date('Y'))->get()->toArray();
        $total_rab_accepted = DB::table('rabs')->whereYear('waktu_pelaksanaan', date('Y'))->where('status', '=', 'accepted')->get()->toArray();

        $total_rab = \count($total_rab);
        $total_rab_accepted = \count($total_rab_accepted);

        $laboratorium_anggaran = DB::table('anggaran')
            ->join('laboratorium', 'laboratorium.id', '=', 'anggaran.laboratorium')
            ->whereYear('periode', \date('Y'));

        if (Auth::user()->role !== 'super admin') {
            $laboratorium_anggaran->where('anggaran.laboratorium', '=', Auth::user()->laboratorium);
        }

        $laboratorium_anggaran->select(['laboratorium.laboratorium', DB::raw('SUM(anggaran) as anggaran')])
            ->groupBy('laboratorium');

        $laboratorium_anggaran = ($laboratorium_anggaran->get()->toArray());

        return view('home', \compact(['total_rab', 'total_rab_accepted', 'laboratorium_anggaran']));
    }
}
