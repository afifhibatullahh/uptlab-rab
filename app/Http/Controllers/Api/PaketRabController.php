<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use App\Models\PaketDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

        $validator = Validator::make($paketrab, [
            'title' => 'required',
            'jenis_rab' => 'required',
            'nomor_akun' => 'required',
            'waktu_pelaksanaan' => 'required',
        ])->validate();

        if (count($paketrabdetail) <= 0) {
            return  response()->json(['message' => 'Rab Harus diisi', 'status' => 400], 400);
        }

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
        $paketrabrequest = $request->json()->all();



        $paketrab = $paketrabrequest['paketrab'];
        $paketrabdetail = $paketrabrequest['paketrabdetail'];
        $validator = Validator::make($paketrab, [
            'title' => 'required',
            'jenis_rab' => 'required',
            'nomor_akun' => 'required',
            'waktu_pelaksanaan' => 'required',
        ])->validate();

        if (count($paketrabdetail) <= 0) {
            return  response()->json(['message' => 'Rab Harus diisi', 'status' => 400], 400);
        }

        try {
            DB::beginTransaction();


            PaketDetail::where('id_paket', $id)->delete();

            try {

                $rabCreated = Paket::where('id', $id)->update([
                    'title' => $paketrab['title'],
                    'jenis_pengadaan' => $paketrab['jenis_rab'],
                    'nomor_akun' => $paketrab['nomor_akun'],
                    'waktu_pelaksanaan' => $paketrab['waktu_pelaksanaan'],
                ]);
            } catch (Exception $e) {
                return  response()->json(['data' => ['msg' => $e->getMessage(), 'msgdetail' => $e->getTrace()],], 403);
            }

            $newDetail = [];
            foreach ($paketrabdetail as $data) {
                $newDetail[] = [
                    'id_rab' => $data['id'],
                    'id_paket' => $id,
                ];
            }

            PaketDetail::insert($newDetail);

            DB::commit();
        } catch (\PDOException $e) {
            // Woopsy
            DB::rollBack();
            return  response()->json(['message' => $e->getMessage(), 'status' => 400], 400);
        }


        return  response()->json(['message' => 'Data Paket berhasil Diubah', 'id' => $id, 'status' => 200], 200);
    }

    public function delete($id)
    {
        $paketrab = Paket::find($id);

        //return response
        if ($paketrab) {

            try {
                DB::beginTransaction();


                $deleted = PaketDetail::where('id_paket', $id)->delete();

                if ($deleted === 0) {
                    $msg = ['data' => $paketrab, 'message' => 'Paket dengan id ' . $id . ' tidak ditemukan atau sudah dihapus', 'status' => 404];
                    return  response()->json($msg, 404);
                }


                DB::commit();
            } catch (\PDOException $e) {
                // Woopsy
                DB::rollBack();
                return  response()->json(['message' => $e->getMessage(), 'status' => 400], 400);
            }

            $paketrab->delete();

            return  response()->json(['data' => $paketrab, 'message' => 'Data berhasil dihapus', 'status' => 200], 200);
        } else
            return  response()->json(['data' => $paketrab, 'message' => 'Data gagal dihapus', 'status' => 403], 403);
    }


    public function exportPaketRab(Request $request)
    {
        $paketrabrequest = $request->json()->all();

        if (!($paketrabrequest)) {
            return response()->json(['message' => 'error', 'status' => 403], 404);
        }

        $paketrab = $paketrabrequest['paketrab'];
        $paketrabdetail = $paketrabrequest['paketrabdetail'];
        $rekap = $paketrabrequest['rekap'];

        try {
            $spreadsheet = new Spreadsheet();


            $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Rekap');

            $spreadsheet->addSheet($myWorkSheet, 0);

            $sheet = $spreadsheet->getSheet(0);

            foreach (range(1, 5) as $rowID) {
                $sheet->mergeCells('A' . $rowID . ':E' . $rowID);
            }
            $sheet->setCellValue('A1', 'Rencana Anggaran Belanja (RAB)');

            $sheet->setCellValue('A3', 'Judul Pengadaan : ' . $paketrab['title']);
            $sheet->setCellValue('A4', 'Nomor Akun : ' . $paketrab['nomor_akun']);
            $sheet->setCellValue('A5', 'Jenis Pengadaan : ' . $paketrab['jenis_pengadaan']);

            $sheet->mergeCells('C7:E7');

            $style = array(
                'alignment' => array(
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                )
            );

            $sheet->getStyle('C7:E7')->applyFromArray($style);

            $sheet->setCellValue('C7', 'REKAP');

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

            $sheet->setCellValue('C9', 'No');
            $sheet->setCellValue('D9', 'Nama Barang');
            $sheet->setCellValue('E9', 'Spesifikasi');


            $sheet->getStyle('C9:E9')->applyFromArray($styleArray);

            $no = 1;
            $start = 10;

            $styleBorders = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ];

            foreach ($rekap as $key => $value) {
                $sheet->setCellValue('C' . $start, $no);
                $sheet->setCellValue('D' . $start, $key);
                $sheet->setCellValue('E' . $start, 'Rp. ' . $value);

                $sheet->getStyle('C' . $start . ':E' . $start)->applyFromArray($styleBorders);

                $start++;
                $no++;
            }

            foreach (range('A', 'E') as $columnID) {
                $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }



            $i = 1;
            foreach ($paketrabdetail as $key => $paket) {

                $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, $key);

                $spreadsheet->addSheet($myWorkSheet, $i);

                $sheet = $spreadsheet->getSheet($i);


                foreach (range('A', 'L') as $columnID) {
                    $sheet->getColumnDimension($columnID)->setAutoSize(true);
                }

                $sheet->setCellValue('C7', 'No');
                $sheet->setCellValue('D7', 'Nama Barang');
                $sheet->setCellValue('E7', 'Spesifikasi');
                $sheet->setCellValue('F7', 'Jumlah');
                $sheet->setCellValue('G7', 'Satuan');
                $sheet->setCellValue('H7', 'Harga Satuan');
                $sheet->setCellValue('I7', 'Jumlah Harga');
                $sheet->setCellValue('J7', 'Sumber');
                $sheet->setCellValue('K7', 'Jenis Barang');
                $sheet->setCellValue('L7', 'Laboratorium');

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


                $sheet->getStyle('C7:L7')->applyFromArray($styleArray);

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
                foreach ($paket as $detail) {
                    $sheet->setCellValue('C' . $row, $number);
                    $sheet->setCellValue('D' . $row, $detail['nama_barang']);
                    $sheet->setCellValue('E' . $row, '-');
                    $sheet->setCellValue('F' . $row, $detail['qty']);
                    $sheet->setCellValue('G' . $row, $detail['satuan']);
                    $sheet->setCellValue('H' . $row, 'Rp. ' . $detail['harga_satuan']);
                    $sheet->setCellValue('I' . $row, 'Rp. ' . $detail['jumlah_harga']);
                    $sheet->setCellValue('J' . $row, $detail['sumber']);
                    $sheet->setCellValue('K' . $row, $detail['jenis_item']);
                    $sheet->setCellValue('L' . $row, $detail['laboratorium']);

                    $sheet->getStyle('C' . $row . ':L' . $row)->applyFromArray($styleBorders);
                    $row++;
                    $number++;
                }

                $i++;
            }




            $writer = new Xlsx($spreadsheet);
            $writer->save($paketrab['title'] . '_' . $paketrab['nomor_akun'] . '.xlsx');
        } catch (\Error $e) {
            return  response()->json(['message' => $e->getMessage(), 'status' => 400], 400);
        }

        return  response()->json(['data' => $paketrab['title'] . '_' . $paketrab['nomor_akun'] . '.xlsx', 'message' => 'Export RAB Berhasil', 'status' => 200], 200);
    }
}
