@extends('layout.master')

@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Barang</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Barang</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- /.card -->

                    <div class="card">
                        <div class="card-header d-flex">
                            <h3 class="card-title">Table Barang</h3>
                            <a class="btn btn-primary ml-auto" href="/barang/add" role="button">Tambah</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Spesifikasi</th>
                                        <th>Satuan</th>
                                        <th>Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($item as $data)
                                    <tr>
                                        <td>{{$data->nama_barang}}</td>
                                        <td>{{$data->spesifikasi}}
                                        </td>
                                        <td>{{$data->satuan}}</td>
                                        <td>{{$data->harga}}</td>
                                        <td>
                                            <button><a href="/barang/edit/{{$data->id}}">update</a></button>
                                            <button><a href="/barang/{{$data->id}}">detail</a></button>
                                            <form action="/barang/delete/{{$data->id}}" method='post' style="display: inline;">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" onclick="return confirm('Yakin untuk menghapus data?')">delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection