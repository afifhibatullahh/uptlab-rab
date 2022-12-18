@extends('template.layout')

@section('content')

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row align-items-center mb-4">
                    <div class="col">
                        <h2 class="h5 page-title"><small class="text-muted text-uppercase">Nomor
                                Akun</small><br />{{$rab->nomor_akun}}
                        </h2>
                    </div>
                    <div class="col-auto">
                        <button type="button" onclick="exportExcel()" class="btn btn-secondary"> <i
                                class="fe fe-download fe-16"></i></button>
                        <a href="edit/{{$rab->id}}" class="btn btn-primary">Edit</a>
                    </div>
                </div>
                <div class="card shadow">
                    <div class="card-body p-5">
                        <div class="row mb-5">
                            <div class="col-12 text-center mb-4">
                                <h2 class="mb-0 text-uppercase">Rencana Anggaran Belanja (RAB)</h2>
                                <p class="text-muted"> {{$rab->laboratorium}} </p>
                            </div>
                            <div class="col-md-7">
                                <p class="small text-muted text-uppercase">Judul Pengadaan</p>
                                <p>
                                    <strong>{{$rab->title}}</strong>
                                </p>
                                <p>
                                    <span class="small text-muted text-uppercase">Jenis Pengadaan</span><br />
                                    <strong>{{$rab->jenis_rab}}</strong>
                                </p>
                            </div>
                            <div class="col-md-5">
                                <p class="small text-muted text-uppercase">Status</p>
                                <p>
                                    <strong>{{$rab->status}}</strong>
                                </p>
                                <p>
                                    <small class="small text-muted text-uppercase">Waktu Pelaksanaan</small><br />
                                    <strong>{{$rab->waktu_pelaksanaan}}</strong>
                                </p>
                            </div>
                        </div> <!-- /.row -->
                        <table class="col-12" id='tabledetailrab'>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th>Harga Satuan (Rp)</th>
                                    <th>Jumlah Harga (Rp)</th>
                                    <th>Pajak (%)</th>
                                    <th>Sumber/Supplier</th>
                                    <th>Jenis Barang</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; ?>
                                @foreach ($rabdetail as $item)
                                <tr>
                                    <th scope="row">{{$i}}</th>
                                    <td> {{$item->nama_barang}} </td>
                                    <td> {{$item->qty}} </td>
                                    <td> {{$item->satuan}} </td>
                                    <td> {{$item->harga_satuan}} </td>
                                    <td> {{$item->jumlah_harga}} </td>
                                    <td> {{$item->pajak}} </td>
                                    <td> {{$item->sumber}} </td>
                                    <td> {{$item->jenis_item}} </td>

                                </tr>

                                <?php $i++; ?>
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
                                <div class="text-right mr-2">
                                    <p class="mb-2 h6">
                                        <span class="text-muted">Subtotal : </span>
                                        <strong>Rp.{{$subtotal}}</strong>
                                    </p>
                                    <p class="mb-2 h6">
                                        <span class="text-muted">Pajak : </span>
                                        <strong>Rp.{{$tax}}</strong>
                                    </p>
                                    <p class="mb-2 h6">
                                        <span class="text-muted">Total : </span>
                                        <span>Rp.{{$total}}</span>
                                    </p>
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
    const rab = <?= $rabToJson; ?>


</script>
<script src="{{url('js/features/exportExcel.js')}}"></script>
@endSection