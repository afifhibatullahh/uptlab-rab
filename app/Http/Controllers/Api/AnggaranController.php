<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Anggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class AnggaranController extends Controller
{
    public function index(Request $request)
    {
        $id_lab = $request->id_lab;

        $anggaran = DB::table('anggaran')->where('laboratorium', $id_lab)->get();

        return  response()->json(['data' => $anggaran, 'message' => 'List Anggaran', 'status' => 200], 200);
    }

    public function store(Request $request)
    {
        //create item

        // $isHasbeenCreatedPeriod = DB::table('anggaran')
        //     ->where('laboratorium', '=', $request->laboratorium)
        //     ->where('datestart', '<=', $request->datestart)
        //     ->where('dateend', '>=', $request->datestart)
        //     ->first();

        // if (isset($isHasbeenCreatedPeriod)) {
        //     return  response()->json(['message' => 'Anggaran periode tersebut sudah ada', 'status' => 400], 400);
        // }

        $rules = [
            "anggaran" => 'required|numeric',
            "periode" => 'required|numeric|digits:4',
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);


        if ($validator->fails()) {
            return  response()->json(['message' => $validator->errors()->first()], 403);
        }

        $anggaran = Anggaran::create([
            'laboratorium'     => $request->laboratorium,
            'anggaran'     => $request->anggaran,
            'periode'     => $request->periode,
            'catatan'     => $request->catatan,
        ]);

        //return response
        if ($anggaran)
            return  response()->json(['data' => $anggaran, 'message' => 'Data berhasil ditambahkan', 'status' => 200], 200);
        else
            return  response()->json(['data' => $anggaran, 'message' => 'Data gagal ditambahkan', 'status' => 403], 403);
    }

    public function update(Request $request, $id)
    {
        //create item
        $anggaran = Anggaran::where('id', $id)->first();

        // $isHasbeenCreatedPeriod = DB::table('anggaran')
        //     ->where('laboratorium', '=', $request->laboratorium)
        //     ->where('datestart', '<=', $request->datestart)
        //     ->where('dateend', '>=', $request->datestart)
        //     ->first();

        // $isStillOnPeriod = $anggaran->datestart <= $request->datestart && $anggaran->dateend >= $request->datestart;

        //return response
        // if ($anggaran && ($isStillOnPeriod || empty($isHasbeenCreatedPeriod))) {
        if ($anggaran) {

            $anggaran->update([
                'laboratorium'     => $request->laboratorium,
                'anggaran'     => $request->anggaran,
                'periode'     => $request->periode,
                'catatan'     => $request->catatan,
            ]);


            return  response()->json(['data' => $anggaran, 'message' => 'Data berhasil diubah', 'status' => 200], 200);
        } else {
            if (isset($isHasbeenCreatedPeriod)) {
                return  response()->json(['data' => $anggaran, 'message' => 'Data periode sudah ada', 'status' => 403], 403);
            }
            return  response()->json(['data' => $anggaran, 'message' => 'Data gagal diubah', 'status' => 403], 403);
        }
    }

    public function delete($id)
    {
        //create item
        $anggaran = Anggaran::find($id);

        //return response
        if ($anggaran) {
            $anggaran->delete();
            return  response()->json(['data' => $anggaran, 'message' => 'Data berhasil dihapus', 'status' => 200], 200);
        } else
            return  response()->json(['data' => $anggaran, 'message' => 'Data gagal dihapus', 'status' => 403], 403);
    }
}
