<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rab;
use App\Models\RabDetail;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RabController extends Controller
{
    public function index()
    {
        $rab = Rab::all();


        //return collection of items as a resource
        return  response()->json(['data' => $rab, 'message' => 'List Data Rab', 'status' => 200], 200);
    }

    public function store(Request $request)
    {

        $rabrequest = $request->json()->all();

        $rab = $rabrequest['rab'];
        $rabdetail = $rabrequest['rabdetail'];
        try {
            DB::beginTransaction();
            // database queries here

            try {
                $rabCreated = Rab::create([
                    'title' => $rab['title'],
                    'jenis' => $rab['jenis'],
                    'nomor_akun' => $rab['nomor_akun'],
                    'waktu_pelaksanaan' => $rab['waktu_pelaksanaan'],
                    'jumlah' => $rab['jumlah'],
                ]);
            } catch (Exception $e) {
                return  response()->json(['data' => ['msg' => $e->getMessage(), 'msgdetail' => $e->getTrace()],], 403);
            }

            $newDetail = [];

            $idrab = $rabCreated->id;
            foreach ($rabdetail as $data) {

                $data['rab_id_ref'] = $idrab;

                \array_push($newDetail, $data);
            }

            \dd($newDetail);
            // RabDetail::insert()

            DB::commit();
        } catch (\PDOException $e) {
            // Woopsy
            DB::rollBack();
        }
    }


    public function delete($id)
    {
        //create item
        $rab = Rab::find($id);

        //return response
        if ($rab) {
            $rab->delete();
            return  response()->json(['data' => $rab, 'message' => 'Data berhasil dihapus', 'status' => 200], 200);
        } else
            return  response()->json(['data' => $rab, 'message' => 'Data gagal dihapus', 'status' => 403], 403);
    }
}
