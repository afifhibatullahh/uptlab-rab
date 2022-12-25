<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rab;
use App\Models\RabDetail;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



class RabController extends Controller
{

    public function index(Request $request)
    {

        $userId = $request->userId;

        if ($userId == 1)
            $rab = DB::table('rabs')
                ->join('jenis_rab', 'rabs.jenis_rab', '=', 'jenis_rab.id')
                ->select('rabs.id', 'nomor_akun', 'status', 'jenis_rab.jenis as jenis', 'waktu_pelaksanaan')
                ->get();
        else {
            $laboratorium = DB::table('users')->select('laboratorium')->where('id', $userId)->first();

            $rab = DB::table('rabs')
                ->join('jenis_rab', 'rabs.jenis_rab', '=', 'jenis_rab.id')
                ->select('rabs.id', 'nomor_akun', 'status', 'jenis_rab.jenis as jenis', 'waktu_pelaksanaan')
                ->where('laboratorium', $laboratorium->laboratorium)
                ->get();
        }

        //return collection of items as a resource
        return  response()->json(['data' => $rab, 'message' => 'List Data Rab', 'status' => 200], 200);
    }

    public function store(Request $request)
    {

        $rabrequest = $request->json()->all();

        $rab = $rabrequest['rab'];
        $rabdetail = $rabrequest['rabdetail'];

        $anggaran = DB::table('anggaran')
            ->where('laboratorium', '=', $rab['laboratorium'])
            ->where('datestart', '<=', $rab['waktu_pelaksanaan'])
            ->where('dateend', '>=', $rab['waktu_pelaksanaan'])
            ->first();


        if (empty($anggaran)) {
            return  response()->json(['message' => 'Periode Rencana Anggaran Belanja pada waktu pelaksanaan tersebut tidak ada', 'status' => 400], 400);
        }

        $budget_used = DB::table('rabs')
            ->where('laboratorium', '=', $rab['laboratorium'])
            ->where('waktu_pelaksanaan', '>=', $anggaran->datestart)
            ->where('waktu_pelaksanaan', '<=', $anggaran->dateend)
            ->sum('jumlah');

        $remain_budget = $anggaran->anggaran - $budget_used;

        if ($rab['jumlah'] > $remain_budget) {
            return  response()->json(['message' => 'RAB melebihi Anggaran, sisa anggaran : ' . $remain_budget, 'status' => 400], 400);
        }

        try {
            DB::beginTransaction();
            // database queries here

            try {
                $rabCreated = Rab::create([
                    'title' => $rab['title'],
                    'jenis_rab' => $rab['jenis_rab'],
                    'nomor_akun' => $rab['nomor_akun'],
                    'laboratorium' => $rab['laboratorium'],
                    'waktu_pelaksanaan' => $rab['waktu_pelaksanaan'],
                    'jumlah' => $rab['jumlah'],
                ]);
            } catch (Exception $e) {
                return  response()->json(['data' => ['msg' => $e->getMessage(), 'msgdetail' => $e->getTrace()],], 403);
            }

            $newDetail = [];
            $idrab = $rabCreated->id;
            foreach ($rabdetail as $data) {
                $newDetail[] = [
                    'id_item' => $data['id'],
                    'jumlah_harga' => $data['jumlah_harga'],
                    'qty' => $data['qty'],
                    'satuan' => $data['satuan'],
                    'rab_id_ref' => $idrab,
                ];
            }

            RabDetail::insert($newDetail);

            DB::commit();
        } catch (\PDOException $e) {
            // Woopsy
            DB::rollBack();
            return  response()->json(['message' => $e->getMessage(), 'status' => 400], 400);
        }


        return  response()->json(['message' => 'Data Rab berhasil ditambah', 'id' => $idrab, 'status' => 200], 200);
    }

    public function update(Request $request, $id)
    {

        $rabrequest = $request->json()->all();



        $rab = $rabrequest['rab'];
        $rabdetail = $rabrequest['rabdetail'];

        $anggaran = DB::table('anggaran')
            ->where('laboratorium', '=', $rab['laboratorium'])
            ->where('datestart', '<=', $rab['waktu_pelaksanaan'])
            ->where('dateend', '>=', $rab['waktu_pelaksanaan'])
            ->first();


        if (empty($anggaran)) {
            return  response()->json(['message' => 'Periode Rencana Anggaran Belanja pada waktu pelaksanaan tersebut tidak ada', 'status' => 400], 400);
        }

        $budget_used = DB::table('rabs')
            ->where('id', '!=', $id)
            ->where('laboratorium', '=', $rab['laboratorium'])
            ->where('waktu_pelaksanaan', '>=', $anggaran->datestart)
            ->where('waktu_pelaksanaan', '<=', $anggaran->dateend)
            ->sum('jumlah');

        $remain_budget = $anggaran->anggaran - $budget_used;

        if ($rab['jumlah'] > $remain_budget) {
            return  response()->json(['message' => 'RAB melebihi Anggaran, sisa anggaran : ' . $remain_budget, 'status' => 400], 400);
        }

        try {
            DB::beginTransaction();


            RabDetail::where('rab_id_ref', $id)->delete();

            try {

                $rabCreated = Rab::where('id', $id)->update([
                    'title' => $rab['title'],
                    'jenis_rab' => $rab['jenis_rab'],
                    'laboratorium' => $rab['laboratorium'],
                    'nomor_akun' => $rab['nomor_akun'],
                    'waktu_pelaksanaan' => $rab['waktu_pelaksanaan'],
                    'jumlah' => $rab['jumlah'],
                ]);
            } catch (Exception $e) {
                return  response()->json(['data' => ['msg' => $e->getMessage(), 'msgdetail' => $e->getTrace()],], 403);
            }

            $newDetail = [];
            foreach ($rabdetail as $data) {
                $newDetail[] = [
                    'id_item' => $data['id'],
                    'jumlah_harga' => $data['jumlah_harga'],
                    'qty' => $data['qty'],
                    'satuan' => $data['satuan'],
                    'rab_id_ref' => $id,
                ];
            }

            RabDetail::insert($newDetail);

            DB::commit();
        } catch (\PDOException $e) {
            // Woopsy
            DB::rollBack();
            return  response()->json(['message' => $e->getMessage(), 'status' => 400], 400);
        }


        return  response()->json(['message' => 'Data Rab berhasil Diubah', 'id' => $id, 'status' => 200], 200);
    }

    public function updateStatus(Request $request, $id)
    {

        $status =  $request->status;
        try {
            //code...
            Rab::where('id', $id)->update(array('status' => $status));
        } catch (Error $e) {
            return  response()->json(['message' => $e->getMessage(), 'status' => 400], 400);
        }


        return  response()->json(['message' => 'Status RAB berhasil diubah', 'id' => $id, 'status' => 200], 200);
    }

    public function delete($id)
    {
        //create item
        $rab = Rab::find($id);

        //return response
        if ($rab) {

            try {
                DB::beginTransaction();


                RabDetail::where('rab_id_ref', $id)->delete();

                DB::commit();
            } catch (\PDOException $e) {
                // Woopsy
                DB::rollBack();
                return  response()->json(['message' => $e->getMessage(), 'status' => 400], 400);
            }

            $rab->delete();

            return  response()->json(['data' => $rab, 'message' => 'Data berhasil dihapus', 'status' => 200], 200);
        } else
            return  response()->json(['data' => $rab, 'message' => 'Data gagal dihapus', 'status' => 403], 403);
    }

    public function exportRab(Request $request)
    {
        $rabrequest = $request->json()->all();

        if (!($rabrequest)) {
            return response()->json(['message' => 'error', 'status' => 403], 404);
        }

        $rab = $rabrequest['rab'];
        $rabdetail = $rabrequest['rabdetail'];
        $total1 = $rabrequest['total1'];
        $expenses = $rabrequest['expenses'];
        $total2 = $rabrequest['total2'];
        $tax = $rabrequest['tax'];
        $total_rab = $rabrequest['total_rab'];

        try {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();


            foreach (range('A', 'K') as $columnID) {
                $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }


            $sheet->setCellValue('A1', 'Rencana Anggaran Belanja (RAB)');

            $sheet->setCellValue('A3', 'Judul Pengadaan :');
            $sheet->setCellValue('B3', $rab['title']);
            $sheet->setCellValue('A4', 'Nomor Akun :');
            $sheet->setCellValue('B4', $rab['nomor_akun']);
            $sheet->setCellValue('A5', 'Jenis Pengadaan :');
            $sheet->setCellValue('B5', $rab['jenis_rab']);

            $sheet->setCellValue('C7', 'No');
            $sheet->setCellValue('D7', 'Nama Barang');
            $sheet->setCellValue('E7', 'Spesifikasi');
            $sheet->setCellValue('F7', 'Jumlah');
            $sheet->setCellValue('G7', 'Satuan');
            $sheet->setCellValue('H7', 'Harga Satuan');
            $sheet->setCellValue('I7', 'Jumlah Harga');
            $sheet->setCellValue('J7', 'Sumber');
            $sheet->setCellValue('K7', 'Jenis Barang');

            $styleArray = [
                'font' => [
                    'bold' => true,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'rotation' => 90,
                    'startColor' => [
                        'argb' => 'ffffff00',
                    ],
                ],
            ];


            $sheet->getStyle('C7:K7')->applyFromArray($styleArray);



            $startrRow = 8;
            $row = $startrRow;

            $styleBorders = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ];

            $number = 1;
            foreach ($rabdetail as $detail) {
                $sheet->setCellValue('C' . $row, $number);
                $sheet->setCellValue('D' . $row, $detail['nama_barang']);
                $sheet->setCellValue('E' . $row, '-');
                $sheet->setCellValue('F' . $row, $detail['qty']);
                $sheet->setCellValue('G' . $row, $detail['satuan']);
                $sheet->setCellValue('H' . $row, 'Rp. ' . $detail['harga_satuan']);
                $sheet->setCellValue('I' . $row, 'Rp. ' . $detail['jumlah_harga']);
                $sheet->setCellValue('J' . $row, $detail['sumber']);
                $sheet->setCellValue('K' . $row, $detail['jenis_item']);

                $sheet->getStyle('C' . $row . ':K' . $row)->applyFromArray($styleBorders);
                $row++;
                $number++;
            }

            ++$row;
            $sheet->setCellValue('J' . $row, 'Total Harga :');
            $sheet->setCellValue('K' . $row, 'Rp. ' . $total1);
            $sheet->getStyle('J' . $row . ':K' . $row)->applyFromArray($styleArray);
            ++$row;
            $sheet->setCellValue('J' . $row, 'Ongkir/Kenaikan Harga 10% :');
            $sheet->setCellValue('K' . $row, 'Rp. ' . $expenses);
            $sheet->getStyle('J' . $row . ':K' . $row)->applyFromArray($styleArray);
            ++$row;
            $sheet->setCellValue('J' . $row, 'Total 2 :');
            $sheet->setCellValue('K' . $row, 'Rp. ' . $total2);
            $sheet->getStyle('J' . $row . ':K' . $row)->applyFromArray($styleArray);
            ++$row;
            $sheet->setCellValue('J' . $row, 'PPN 11% :');
            $sheet->setCellValue('K' . $row, 'Rp. ' . $tax);
            $sheet->getStyle('J' . $row . ':K' . $row)->applyFromArray($styleArray);
            ++$row;
            $sheet->setCellValue('J' . $row, 'Total RAB :');
            $sheet->setCellValue('K' . $row, 'Rp. ' . $total_rab);
            $sheet->getStyle('J' . $row . ':K' . $row)->applyFromArray($styleArray);


            $writer = new Xlsx($spreadsheet);
            $writer->save($rab['title'] . '_' . $rab['nomor_akun'] . '.xlsx');
        } catch (\Error $e) {
            return  response()->json(['message' => $e->getMessage(), 'status' => 400], 400);
        }

        return  response()->json(['data' => $rab['title'] . '_' . $rab['nomor_akun'] . '.xlsx', 'message' => 'Export RAB Berhasil', 'status' => 200], 200);
    }
}
