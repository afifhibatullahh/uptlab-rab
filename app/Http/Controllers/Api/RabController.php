<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\MailNotify;
use App\Models\Rab;
use App\Models\RabDetail;
use Carbon\Carbon;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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

        // $anggaran = DB::table('anggaran')
        //     ->where('laboratorium', '=', $rab['laboratorium'])
        //     ->where('datestart', '<=', $rab['waktu_pelaksanaan'])
        //     ->where('dateend', '>=', $rab['waktu_pelaksanaan'])
        //     ->first();

        $periode = date('Y', strtotime(($rab['waktu_pelaksanaan'])));

        $anggaran = DB::table('anggaran')
            ->where('laboratorium', '=', $rab['laboratorium'])
            ->where('periode', '=', $periode)
            ->sum('anggaran');


        if (empty($anggaran) || $anggaran <= 0) {
            return  response()->json(['message' => 'Periode Rencana Anggaran Belanja pada waktu pelaksanaan tersebut tidak ada', 'status' => 400], 400);
        }

        // $budget_used = DB::table('rabs')
        //     ->where('laboratorium', '=', $rab['laboratorium'])
        //     ->where('waktu_pelaksanaan', '>=', $anggaran->datestart)
        //     ->where('waktu_pelaksanaan', '<=', $anggaran->dateend)
        //     ->sum('jumlah');

        $budget_used = DB::table('rabs')
            ->where('laboratorium', '=', $rab['laboratorium'])
            ->whereYear('waktu_pelaksanaan', '=', $periode)
            ->sum('jumlah');

        $remain_budget = $anggaran - $budget_used;

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

        // $anggaran = DB::table('anggaran')
        //     ->where('laboratorium', '=', $rab['laboratorium'])
        //     ->where('datestart', '<=', $rab['waktu_pelaksanaan'])
        //     ->where('dateend', '>=', $rab['waktu_pelaksanaan'])
        //     ->first();


        $periode = date('Y', strtotime(($rab['waktu_pelaksanaan'])));

        $anggaran = DB::table('anggaran')
            ->where('laboratorium', '=', $rab['laboratorium'])
            ->where('periode', '=', $periode)
            ->sum('anggaran');


        if (empty($anggaran) || $anggaran <= 0) {
            return  response()->json(['message' => 'Periode Rencana Anggaran Belanja pada waktu pelaksanaan tersebut tidak ada', 'status' => 400], 400);
        }

        // $budget_used = DB::table('rabs')
        //     ->where('id', '!=', $id)
        //     ->where('laboratorium', '=', $rab['laboratorium'])
        //     ->where('waktu_pelaksanaan', '>=', $anggaran->datestart)
        //     ->where('waktu_pelaksanaan', '<=', $anggaran->dateend)
        //     ->sum('jumlah');

        // $remain_budget = $anggaran->anggaran - $budget_used;

        $budget_used = DB::table('rabs')
            ->where('laboratorium', '=', $rab['laboratorium'])
            ->whereYear('waktu_pelaksanaan', '=', $periode)
            ->sum('jumlah');

        $remain_budget = $anggaran - $budget_used;

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


        $msg = [
            'rejected' => 'Mohon Maaf, periksa dan perbaiki kembali Rencana Anggaran Belanja dengan informasi sebagai berikut:',
            'accepted' => 'RAB dengan informasi berikut telah disetujui.',
            'update' => 'RAB dengan informasi berikut perlu di update kembali.',
            'pending' => 'RAB dengan informasi berikut di ubah ke status pending'
        ];

        try {

            $rab = DB::table('rabs')
                ->join('jenis_rab', 'jenis_rab.id', '=', 'rabs.jenis_rab')
                ->join('laboratorium', 'laboratorium.id', '=', 'rabs.laboratorium')
                ->where('rabs.id', $id)
                ->select(['rabs.*', 'jenis_rab.jenis', 'laboratorium.laboratorium as laboratoriumname'])
                ->get()->toArray();

            $users = DB::table('users')->where('laboratorium', '=', $rab[0]->laboratorium)
                ->select('email')
                ->get()->toArray();


            Rab::where('id', $id)->update(array('status' => $status));

            $data = [
                'subject' => 'Rencana Aggaran Belanja',
                "body" => $rab,
                'message' => $msg[$status]
            ];

            foreach ($users as  $user) {
                Mail::to($user->email)->send(new MailNotify($data));
            }
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

            $style = array(
                'alignment' => array(
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                )
            );

            $sheet->getStyle('A1:J1')->applyFromArray($style);

            foreach (range(1, 5) as $rowID) {
                $sheet->mergeCells('A' . $rowID . ':J' . $rowID);
            }

            $sheet->setCellValue('A1', 'Rencana Anggaran Belanja (RAB)');

            $sheet->setCellValue('A2', 'Judul Pengadaan : ' . $rab['title']);
            $sheet->setCellValue('A3', 'Nomor Akun : ' . $rab['nomor_akun']);
            $sheet->setCellValue('A4', 'Jenis Pengadaan : ' . $rab['jenis_rab']);
            $sheet->setCellValue('A5', 'Waktu Pelaksanaan : ' . $rab['waktu_pelaksanaan']);

            $sheet->setCellValue('A7', 'No');
            $sheet->setCellValue('B7', 'Nama Barang');
            $sheet->setCellValue('C7', 'Spesifikasi');
            $sheet->setCellValue('D7', 'Jumlah');
            $sheet->setCellValue('E7', 'Satuan');
            $sheet->setCellValue('F7', 'Harga Satuan');
            $sheet->setCellValue('G7', 'Jumlah Harga');
            $sheet->setCellValue('H7', 'Sumber');
            $sheet->setCellValue('I7', 'Jenis Barang');

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


            $sheet->getStyle('A7:I7')->applyFromArray($styleArray);



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
                $sheet->setCellValue('A' . $row, $number);
                $sheet->setCellValue('B' . $row, $detail['nama_barang']);
                $sheet->setCellValue('C' . $row, '-');
                $sheet->setCellValue('D' . $row, $detail['qty']);
                $sheet->setCellValue('E' . $row, $detail['satuan']);
                $sheet->setCellValue('F' . $row, 'Rp. ' . $detail['harga_satuan']);
                $sheet->setCellValue('G' . $row, 'Rp. ' . $detail['jumlah_harga']);
                $sheet->setCellValue('H' . $row, $detail['sumber']);
                $sheet->setCellValue('I' . $row, $detail['jenis_item']);

                $sheet->getStyle('A' . $row . ':I' . $row)->applyFromArray($styleBorders);
                $row++;
                $number++;
            }

            ++$row;
            $sheet->setCellValue('H' . $row, 'Total Harga :');
            $sheet->setCellValue('I' . $row, 'Rp. ' . $total1);
            $sheet->getStyle('H' . $row . ':I' . $row)->applyFromArray($styleArray);
            ++$row;
            $sheet->setCellValue('H' . $row, 'Ongkir/Kenaikan Harga 10% :');
            $sheet->setCellValue('I' . $row, 'Rp. ' . $expenses);
            $sheet->getStyle('H' . $row . ':I' . $row)->applyFromArray($styleArray);
            ++$row;
            $sheet->setCellValue('H' . $row, 'Total 2 :');
            $sheet->setCellValue('I' . $row, 'Rp. ' . $total2);
            $sheet->getStyle('H' . $row . ':I' . $row)->applyFromArray($styleArray);
            ++$row;
            $sheet->setCellValue('H' . $row, 'PPN 11% :');
            $sheet->setCellValue('I' . $row, 'Rp. ' . $tax);
            $sheet->getStyle('H' . $row . ':I' . $row)->applyFromArray($styleArray);
            ++$row;
            $sheet->setCellValue('H' . $row, 'Total RAB :');
            $sheet->setCellValue('I' . $row, 'Rp. ' . $total_rab);
            $sheet->getStyle('H' . $row . ':I' . $row)->applyFromArray($styleArray);


            $writer = new Xlsx($spreadsheet);
            $writer->save($rab['title'] . '_' . $rab['nomor_akun'] . '.xlsx');
        } catch (\Error $e) {
            return  response()->json(['message' => $e->getMessage(), 'status' => 400], 400);
        }

        return  response()->json(['data' => $rab['title'] . '_' . $rab['nomor_akun'] . '.xlsx', 'message' => 'Export RAB Berhasil', 'status' => 200], 200);
    }
}
