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
                    {{-- <button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target="#modal">Simpan</button> --}}
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="example-helping">Judul Pengadaan</label>
                                    <input type="text" id="example-helping" class="form-control"
                                        placeholder="Input with helping text">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="simpleinput">Nomor Akun</label>
                                    <input type="text" id="simpleinput" class="form-control">
                                </div>
                            </div> <!-- /.col -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="example-select">Jenis RAB</label>
                                    <select class="form-control" id="example-select">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="date-input1">Waktu Pelaksanaan</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control drgpicker" id="date-input1"
                                            value="04/24/2020" aria-describedby="button-addon2">
                                        <div class="input-group-append">
                                            <div class="input-group-text" id="button-addon-date"><span
                                                    class="fe fe-calendar fe-16"></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- / .card -->

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

    console.log(listItems);
</script>
<script src="{{url('js/features/rabdetail.js')}}"></script>
@endSection