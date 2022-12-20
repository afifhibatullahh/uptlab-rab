@extends('template.layout')

@section('content')

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="d-flex justify-content-between mb-2">
                    <h2 class="page-title mb-0">
                        Edit Paket Rencana Anggaran Belanja
                    </h2>
                    <button type="button" class="btn btn-primary"
                        onclick="editPaketRabDetail({{$paketrab->id}})">Simpan</button>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">

            <div class="col-12">
                <form id="formpaket">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="judul-pengadaan">Judul Pengadaan</label>
                                        <input type="text" value="{{$paketrab->title}}" id="judul-pengadaan"
                                            class="form-control" name="title">
                                    </div>
                                </div> <!-- /.col -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="nomor_akun">Nomor Akun</label>
                                        <input type="number" name="nomor_akun" value="{{$paketrab->nomor_akun}}"
                                            id="nomor_akun" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="jenis_rab-select">Jenis RAB</label>
                                        <select class="form-control" name="jenis_rab" id="jenis_rab-select">
                                            <option selected disabled>Pilih Jenis RAB</option>
                                            @foreach($jenisrabs as $jenisrab)
                                            <option value='{{$jenisrab->id}}' <?=$paketrab->jenis_pengadaan ===
                                                $jenisrab->id?'selected':'' ?> >{{$jenisrab->jenis}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="waktu_pelaksanaan">Waktu Pelaksanaan</label>
                                        <div class="input-group">
                                            <input class="form-control" id="waktu_pelaksanaan" type="date"
                                                name="waktu_pelaksanaan" value="{{$paketrab->waktu_pelaksanaan}}" />
                                        </div>
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
                                <h3>RAB</h3>
                                <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal"
                                    data-target="#modal" onclick="addRab()">Tambah RAB</button>
                            </div>
                        </strong>
                    </div>
                    <div class="card-body">
                        <!-- table -->
                        <table class="table datatables" id="table-paketrabdetail">
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- .col-12 -->
    </div> <!-- .row -->
    </div>


    <!-- Modal -->
    <div id="modal-paketrabdetail"></div>
</main>

@endSection

@section('script'); ?>
<script>
    const listRabs = <?= $listRabs; ?>;
    const paketrabdetails = <?= $paketrabdetail; ?>;
</script>

</script>
<script src="{{url('js/features/paketrabdetail.js')}}"></script>
<script src="{{url('js/features/paketrabdetailtable.js')}}"></script>
@endSection