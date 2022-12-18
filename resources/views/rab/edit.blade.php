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
                    <button type="button" class="btn btn-primary"
                        onclick="editRabDetail(<?= $rab->id; ?>)">Simpan</button>
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
                                        <input type="text" id="judul-pengadaan" value="{{$rab->title}}"
                                            class="form-control" name="title">
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="nomor_akun">Nomor Akun</label>
                                                <input type="number" name="nomor_akun" id="nomor_akun"
                                                    value="{{$rab->nomor_akun}}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="waktu_pelaksanaan">Waktu Pelaksanaan</label>
                                                <div class="input-group">
                                                    <input class="form-control" value="{{$rab->waktu_pelaksanaan }}"
                                                        id="waktu_pelaksanaan" type="date" name="waktu_pelaksanaan" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- /.col -->
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="jenis-select">Jenis RAB</label>
                                        <select class="form-control" name="jenis_rab" id="jenis-select">
                                            <option disabled>Pilih Jenis RAB</option>
                                            @foreach($jenisrabs as $jenisrab)
                                            <option value='{{$jenisrab->id}}' <?=$rab->jenis_rab ===
                                                $jenisrab->id?'selected':'' ?>>{{$jenisrab->jenis}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="laboratorium-select">Laboratorium</label>
                                        <select class="form-control" name="laboratorium" id="laboratorium-select">
                                            <option selected disabled>Pilih Laboratorium</option>
                                            @foreach($laboratorium as $lab)
                                            <option value='{{$lab->id}}' <?=$rab->laboratorium ===
                                                $lab->id?'selected':'' ?> >{{$lab->laboratorium}}</option>
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
    const rabdetails = <?= $rabdetail; ?>;

</script>

</script>
<script src="{{url('js/features/rabdetailtable.js')}}"></script>
<script src="{{url('js/features/rabdetail.js')}}"></script>
@endSection