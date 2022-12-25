@extends('template.layout')

@section('content')

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="d-flex justify-content-between mb-2">
                    <h2 class="page-title mb-0">
                        Anggaran
                        <?= $title ?>
                    </h2>
                    <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal"
                        data-target="#modal" onclick="create()">Tambah Anggaran</button>
                </div>

                <!-- Table -->
                <div class="row my-4">
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <table class="table datatables" id="table-anggaran" style="cursor: pointer;">
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of table -->
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="modal-anggaran"></div>
</main>

@endSection

@section('script'); ?>
<script>
    const id_lab = <?= $id; ?>;
</script>
<script src="{{url('js/features/anggaran.js')}}"></script>
@endSection