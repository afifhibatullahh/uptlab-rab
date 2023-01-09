@extends('template.layout')

@section('content')

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="d-flex justify-content-between mb-2">
                    <h2 class="page-title mb-0">
                        Buat Rencana Anggaran Belanja
                    </h2>
                    <button type="button" class="btn btn-primary" onclick="saveRabDetail()">Simpan</button>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">

            <div class="col-12">
                <form id="formrab">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="judul-pengadaan">Judul Pengadaan</label>
                                        <input type="text" required id="judul-pengadaan" class="form-control"
                                            name="title">
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="nomor_akun">Nomor Akun</label>
                                                <input type="number" required name="nomor_akun" id="nomor_akun"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="waktu_pelaksanaan">Waktu Pelaksanaan</label>
                                                <div class="input-group">
                                                    <input class="form-control" required id="waktu_pelaksanaan"
                                                        type="date" name="waktu_pelaksanaan" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- /.col -->
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="jenis_rab-select">Jenis RAB</label>
                                        <select class="form-control" required name="jenis_rab" id="jenis_rab-select">
                                            <option selected disabled>Pilih Jenis RAB</option>
                                            @foreach($jenisrabs as $jenisrab)
                                            <option value='{{$jenisrab->id}}'>{{$jenisrab->jenis}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <?php $isSuperAdmin = Auth::user()->role == 'super admin'; ?>
                                    <?php $userLab = Auth::user()->laboratorium; ?>

                                    <div class="form-group mb-3">
                                        <label for="laboratorium-select">Laboratorium</label>
                                        <select class="form-control" required <?=$isSuperAdmin ? '' : 'disabled' ; ?>
                                            name="laboratorium" id="laboratorium-select">
                                            <option selected disabled>Pilih Laboratorium</option>
                                            @foreach($laboratorium as $lab)
                                            @if($isSuperAdmin){
                                            <option value='{{$lab->id}}'>{{$lab->laboratorium}}</option>
                                            }
                                            @else{
                                            <option value='{{$lab->id}}' <?=$userLab===$lab->id?'selected':'' ?>
                                                >{{$lab->laboratorium}}</option>
                                            }
                                            @endif

                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- / .card -->
                </form>

                <div class="card shadow mb-4">
                    <div class="card-header">
                        <strong class="card-title">
                            <div class="d-flex justify-content-between mb-2">
                                <h3>Item</h3>
                                <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal"
                                    data-target="#modal" onclick="addItem()">Tambah Item</button>
                            </div>
                        </strong>
                    </div>
                    <div class="card-body">
                        <!-- table -->
                        <table class="table datatables" id="table-rabdetail">
                            <!-- <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th>Harga Satuan(Rp)</th>
                                    <th>Jumlah Harga</th>
                                    <th>Jenis Barang</th>
                                    <th>Pajak (%)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Imani Lara</td>
                                    <td>2</td>
                                    <td>pcs</td>
                                    <td>2000</td>
                                    <td>4000</td>
                                    <td>High Wycombe</td>
                                    <td>11</td>
                                    <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="text-muted sr-only">Action</span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#">Edit</a>
                                            <a class="dropdown-item" href="#">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody> -->
                        </table>
                        <div class="row mt-5">
                            <div class="col-12">
                                <div class="float-right mr-2">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td> <span class="text-muted">Total Harga</span></td>
                                                <td> <span class="text-muted">: </span></td>
                                                <td> <strong id="total1">Rp.0</strong></td>
                                            </tr>
                                            <tr>
                                                <td> <span class="text-muted">Ongkir/Kenaikan Harga 10%</span></td>
                                                <td> <span class="text-muted">: </span></td>
                                                <td> <strong id="expenses">Rp.0</strong></td>
                                            </tr>
                                            <tr>
                                                <td> <span class="text-muted">Total 2</span></td>
                                                <td> <span class="text-muted">: </span></td>
                                                <td> <strong id="total2">Rp.0</strong></td>
                                            </tr>
                                            <tr>
                                                <td> <span class="text-muted">PPN 11%</span></td>
                                                <td> <span class="text-muted">: </span></td>
                                                <td> <strong id="tax">Rp.0</strong></td>
                                            </tr>
                                            <tr>
                                                <td> <span class="text-muted">Total RAB</span></td>
                                                <td> <span class="text-muted">: </span></td>
                                                <td> <strong id="total_rab">Rp.0</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <!-- /.row -->
                    </div>
                </div>
            </div>
        </div> <!-- .col-12 -->
    </div> <!-- .row -->
    </div>


    <!-- Modal -->
    <div id="modal-rabdetail"></div>
</main>

@endSection

@section('script'); ?>
<script>
    const listItems = <?= $listItems; ?>;

     const rabdetails=[];
</script>

</script>
<script src="{{url('js/features/rabdetailtable.js')}}"></script>
<script src="{{url('js/features/rabdetail.js')}}"></script>
@endSection