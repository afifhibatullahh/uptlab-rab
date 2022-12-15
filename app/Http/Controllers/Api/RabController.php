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
    public function index()
    {
        $rab = DB::table('rabs')
            ->join('jenisrab', 'rabs.jenis', '=', 'jenisrab.id')
            ->select('rabs.id', 'nomor_akun', 'status', 'jenisrab.jenisrab as jenis', 'waktu_pelaksanaan')
            ->get();

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
                $newDetail[] = [
                    'id_item' => $data['id'],
                    'netamount' => $data['netamount'],
                    'pajak' => $data['tax'],
                    'qty' => $data['jumlah'],
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


        try {
            DB::beginTransaction();


            RabDetail::where('rab_id_ref', $id)->delete();

            try {

                $rabCreated = Rab::where('id', $id)->update([
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
            foreach ($rabdetail as $data) {
                $newDetail[] = [
                    'id_item' => $data['id'],
                    'netamount' => $data['netamount'],
                    'pajak' => $data['tax'],
                    'qty' => $data['jumlah'],
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


    public function delete($id)
    {
        //create item
        $rab = Rab::find($id);

        //return response
        if ($rab) {

            try {
                DB::beginTransaction();


                $deleted = RabDetail::where('rab_id_ref', $id)->delete();

                if ($deleted === 0) {
                    $msg = ['data' => $rab, 'message' => 'RAB dengan id ' . $id . ' tidak ditemukan atau sudah dihapus', 'status' => 404];
                    return  response()->json($msg, 404);
                }


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
        $subtotal = $rabrequest['subtotal'];
        $tax = $rabrequest['tax'];
        $total = $rabrequest['total'];

        try {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->getColumnDimension('A')->setAutoSize(true);

            $sheet->setCellValue('A1', 'Rencana Anggaran Belanja (RAB)');

            $sheet->setCellValue('A3', 'Judul Pengadaan :');
            $sheet->setCellValue('B3', $rab[0]['title']);
            $sheet->setCellValue('A4', 'Nomor Akun :');
            $sheet->setCellValue('B4', $rab[0]['nomor_akun']);
            $sheet->setCellValue('A5', 'Jenis Pengadaan :');
            $sheet->setCellValue('B5', $rab[0]['jenis']);

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
                $sheet->setCellValue('I' . $row, 'Rp. ' . $detail['netamount']);
                $sheet->setCellValue('J' . $row, $detail['sumber']);
                $sheet->setCellValue('K' . $row, $detail['jenis']);

                $sheet->getStyle('C' . $row . ':K' . $row)->applyFromArray($styleBorders);
                $row++;
                $number++;
            }

            ++$row;
            $sheet->setCellValue('J' . $row, 'Subtotal :');
            $sheet->setCellValue('K' . $row, 'Rp. ' . $subtotal);
            $sheet->getStyle('J' . $row . ':K' . $row)->applyFromArray($styleArray);
            ++$row;
            $sheet->setCellValue('J' . $row, 'Pajak :');
            $sheet->setCellValue('K' . $row, 'Rp. ' . $tax);
            $sheet->getStyle('J' . $row . ':K' . $row)->applyFromArray($styleArray);
            ++$row;
            $sheet->setCellValue('J' . $row, 'Total :');
            $sheet->setCellValue('K' . $row, 'Rp. ' . $total);
            $sheet->getStyle('J' . $row . ':K' . $row)->applyFromArray($styleArray);


            $writer = new Xlsx($spreadsheet);
            $writer->save($rab[0]['title'] . '_' . $rab[0]['nomor_akun'] . '.xlsx');
        } catch (\Error $e) {
            return  response()->json(['message' => $e->getMessage(), 'status' => 400], 400);
        }

        return  response()->json(['data' => $rab[0]['title'] . '_' . $rab[0]['nomor_akun'] . '.xlsx', 'message' => 'Export RAB Berhasil', 'status' => 200], 200);
    }
}
