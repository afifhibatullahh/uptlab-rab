@extends('template.layout')

@section('content')

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="d-flex justify-content-between mb-2">
                    <h2 class="page-title mb-0">
                        <?= $title ?>
                    </h2>
                    <a class="btn btn-outline-primary btn-sm" href="rab/add" role="button">Tambah</a>
                </div>

                <!-- Table -->
                <div class=" row my-4">
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <table class="table datatables" id="table-rab" style="cursor: pointer;"></table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of table -->
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="modal-rab"></div>
</main>

@endSection

@section('script'); ?>
<script>
</script>
<script src="{{url('js/features/rab.js')}}"></script>
@endSection