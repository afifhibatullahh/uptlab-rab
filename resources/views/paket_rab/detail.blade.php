@extends('template.layout')


@section('css'); ?>
<style>
    tr.group,
    tr.group:hover {
        background-color: #ddd !important;
        color: #001a4e !important;
    }

    #tabledetailpaketrab td {
        vertical-align: top;
        border-bottom: solid 1px;
    }
</style>
@endSection
@section('content')

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row align-items-center mb-4">
                    <div class="col">
                        <h2 class="h5 page-title"><small class="text-muted text-uppercase">Nomor
                                Akun</small><br />{{$paket->nomor_akun}}
                        </h2>
                    </div>
                    <div class="col-auto">
                        <button type="button" onclick="exportPaketExcel()" class="btn btn-secondary"> <i
                                class="fe fe-download fe-16"></i></button>
                        <a href="edit/{{$paket->id}}" class="btn btn-primary">Edit</a>
                    </div>
                </div>
                <div class="card shadow">
                    <div class="card-body p-5">
                        <div class="row mb-5">
                            <div class="col-12 text-center mb-4">
                                <h2 class="mb-0 text-uppercase">Paket Rencana Anggaran Belanja (RAB)</h2>
                            </div>
                            <div class="col-md-7">
                                <p class="small text-muted text-uppercase">Judul Pengadaan</p>
                                <p>
                                    <strong>{{$paket->title}}</strong>
                                </p>
                                <p>
                                    <span class="small text-muted text-uppercase">Jenis Pengadaan</span><br />
                                    <strong>{{$paket->jenis_pengadaan}}</strong>
                                </p>
                            </div>
                            <div class="col-md-5">
                                <p>
                                    <small class="small text-muted text-uppercase">Waktu Pelaksanaan</small><br />
                                    <strong>{{$paket->waktu_pelaksanaan}}</strong>
                                </p>
                            </div>
                        </div> <!-- /.row -->
                        <table class="col-12 display" id='tabledetailpaketrab'>
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Spesifikasi</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th>Harga Satuan (Rp)</th>
                                    <th>Pajak (%)</th>
                                    <th>Jumlah Harga (Rp)</th>
                                    <th>Sumber/Supplier</th>
                                    <th>Jenis Barang</th>
                                    <th>Laboratorium</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($filteredItems as $item)
                                <tr>
                                    <td> {{$item->nama_barang}} </td>
                                    <td style="max-width: 200px"> {{$item->spesifikasi}} </td>
                                    <td> {{$item->qty}} </td>
                                    <td> {{$item->satuan}} </td>
                                    <td> {{$item->harga_satuan}} </td>
                                    <td> {{$item->pajak}} </td>
                                    <td> {{$item->jumlah_harga}} </td>
                                    <td style="max-width: 20px"> <a href="{{$item->sumber}}"> <span>{{$item->sumber}}
                                            </span></a> </td>
                                    <td> {{$item->jenis_item}} </td>
                                    <td> {{$item->laboratorium}} </td>
                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                        <div class="row mt-5">
                            <div class="col-md-6">
                                <p class="text-muted small">
                                    <strong>Memo :</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam
                                    hendrerit nisi sed sollicitudin pellentesque. Nunc posuere purus rhoncus pulvinar
                                    aliquam.
                                </p>
                            </div>
                            <div class="col-md-6">
                                <div class="float-right mr-2">
                                    <table>
                                        <tbody>
                                            @foreach($rekap as $key => $value)
                                            <tr>
                                                <td> <span class="text-muted">{{$key}}</span></td>
                                                <td> <span class="text-muted">: </span></td>
                                                <td> <strong>Rp. {{$value}}</strong></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <!-- /.row -->
                    </div> <!-- /.card-body -->
                </div> <!-- /.card -->
            </div>
        </div>
    </div>



    {{-- <div id="modal-rab"></div> --}}
</main>

@endSection

@section('script'); ?>
<script>
    const dataPaket = <?= $paketToJson; ?>;
</script>
<script src="{{url('js/features/paketrabshow.js')}}"></script>
<script src="{{url('js/features/exportExcel.js')}}"></script>
@endSection