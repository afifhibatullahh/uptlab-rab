@extends('layout.master')

@section('content')

<div class="content-wrapper">
    <div class="container-fluid">
        <h2>{{$item->nama_barang}}</h2>
        <p>{{$item->spesifikasi}}</p>
        <p>{{$item->harga}}</p>
        <p>{{$item->satuan}}</p>
        <p>{{$item->sumber}}</p>
    </div>
</div>

@endsection