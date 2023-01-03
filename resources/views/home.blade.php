@extends('template.layout')

@section('content')

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row align-items-center mb-2">
                    <div class="col">
                        <h2 class="h5 page-title">Welcome <span style="font-size: 16px">
                                {{Auth::user()->name}}
                            </span>
                            !
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-3 text-center">
                                <span class="circle circle-sm bg-primary">
                                    <i class="fe fe-16 fe-shopping-bag text-white mb-0"></i>
                                </span>
                            </div>
                            <div class="col">
                                <p class="small text-muted mb-0" style="font-size: 9px">Total Rencana Anggaran
                                    Belanja Tahun ini</p>
                                <span class="h3 mb-0">{{$total_rab}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-3 text-center">
                                <span class="circle circle-sm bg-primary">
                                    <i class="fe fe-16 fe-check text-white mb-0"></i>
                                </span>
                            </div>
                            <div class="col">
                                <p class="small text-muted mb-0" style="font-size: 9px">Total Rencana Anggaran
                                    Belanja yang disetujui Tahun ini</p>
                                <span class="h3 mb-0">{{$total_rab_accepted}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <strong class="card-title">Laboratorium</strong>
                            <strong class="card-title">Anggaran (Rp)
                                <p class="small text-muted mb-0" style="font-size: 9px">Tahun ini</p>
                            </strong>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush my-n3">
                            <div class="list-group-item">
                                @foreach ($laboratorium_anggaran as $item)
                                <div class="row align-items-center">
                                    <div class="col">
                                        <strong>{{$item->laboratorium}}</strong>
                                    </div>
                                    <div class="col-auto">
                                        <strong>@convert($item->anggaran)</strong>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div> <!-- / .list-group -->
                    </div> <!-- / .card-body -->
                </div> <!-- / .card -->
            </div> <!-- / .col-md-3 -->
        </div>
    </div>
</main>

@endSection

@section('script')
@endSection