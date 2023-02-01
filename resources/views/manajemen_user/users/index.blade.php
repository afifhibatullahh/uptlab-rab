@extends('template.layout')

@section('content')

<?php $isSuperAdmin = Auth::user()->role == 'super admin' ? 1 : 0?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="d-flex justify-content-between mb-2">
                    <h2 class="page-title mb-0">
                        <?= $title ?>
                    </h2>
                    @if($isSuperAdmin)
                    <a class="btn btn-outline-primary btn-sm" href="/user/add" role="button">Tambah User</a>
                    @endif
                </div>

                <!-- Table -->
                <div class="row my-4">
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <table class="table datatables" id="table-user" style="cursor: pointer;"></table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of table -->
            </div>
        </div>
    </div>

</main>

@endSection

@section('script'); ?>
<script>
    const isSuperAdmin = <?= $isSuperAdmin; ?>;
</script>
<script src="{{url('js/features/users.js')}}">
</script>
@endSection