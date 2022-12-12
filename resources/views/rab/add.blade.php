@extends('template.layout')

@section('content')

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="d-flex mb-2">
                    <h2 class="page-title mb-0">
                        Buat Rencana Anggaran Belanja
                    </h2>
                </div>
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