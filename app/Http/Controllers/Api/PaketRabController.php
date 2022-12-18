<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use App\Models\PaketDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaketRabController extends Controller
{
    public function index()
    {
        $paketrab = DB::table('pakets')
            ->join('jenis_rab', 'jenis_rab.id', '=', 'pakets.jenis_pengadaan')
            ->select('title', 'pakets.id', 'jenis_rab.jenis as jenis_pengadaan')->get();

        //return collection of items as a resource
        return  response()->json(['data' => $paketrab, 'message' => 'List Data Paket Rab', 'status' => 200], 200);
    }

    public function store(Request $request)
    {

        $paketrabrequest = $request->json()->all();

        $paketrab = $paketrabrequest['paketrab'];
        $paketrabdetail = $paketrabrequest['paketrabdetail'];
        try {
            DB::beginTransaction();
            // database queries here

            try {
                $rabCreated = Paket::create([
                    'title' => $paketrab['title'],
                    'jenis_pengadaan' => $paketrab['jenis_rab'],
                    'nomor_akun' => $paketrab['nomor_akun'],
                    'waktu_pelaksanaan' => $paketrab['waktu_pelaksanaan'],
                ]);
            } catch (Exception $e) {
                return  response()->json(['data' => ['msg' => $e->getMessage(), 'msgdetail' => $e->getTrace()],], 403);
            }

            $newDetail = [];
            $idPaket = $rabCreated->id;

            foreach ($paketrabdetail as $data) {
                $newDetail[] = [
                    'id_rab' => $data['id'],
                    'id_paket' => $idPaket,
                ];
            }

            PaketDetail::insert($newDetail);

            DB::commit();
        } catch (\PDOException $e) {
            // Woopsy
            DB::rollBack();
            return  response()->json(['message' => $e->getMessage(), 'status' => 400], 400);
        }


        return  response()->json(['message' => 'Data Rab berhasil ditambah', 'id' => $idPaket, 'status' => 200], 200);
    }

    public function update(Request $request, $id)
    {
    }

    public function delete($id)
    {
    }
}
