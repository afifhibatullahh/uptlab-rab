@extends('layout.master')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Barang</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/barang">Barang</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Form Edit Barang</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="formItem" action="/barang/store/{{$item->id}}" method="POST">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nama">Nama Barang</label>
                                    <input type="text" name="nama" class="form-control" value="{{$item->nama_barang}}" id="nama" placeholder="Nama barang">
                                </div>
                                <div class="form-group">
                                    <label for="spesifikasi">Spesifikasi</label>
                                    <input type="text" name="spesifikasi" class="form-control" value="{{$item->spesifikasi}}" id="spesifikasi" placeholder="Spesifikasi">
                                </div>
                                <div class="form-group">
                                    <label for="satuan">Satuan</label>
                                    <input type="text" name="satuan" class="form-control" value="{{$item->satuan}}" id="satuan" placeholder="Satuan">
                                </div>
                                <div class="form-group">
                                    <label for="harga">Harga Satuan</label>
                                    <input type="text" name="harga" class="form-control" value="{{$item->harga}}" id="harga" placeholder="Harga Satuan">
                                </div>
                                <div class="form-group">
                                    <label for="sumber">Sumber</label>
                                    <input type="text" name="sumber" class="form-control" value="{{$item->sumber}}" id="sumber" placeholder="Sumber">
                                </div>
                                <div class="form-group">
                                    <label for="gambar">Gambar</label>
                                    <input type="text" name="gambar" class="form-control" value="{{$item->gambar}}" id="gambar" placeholder="Gambar">
                                </div>
                                <div class="form-group">
                                    <label for="jenis">Jenis</label>
                                    <input type="text" name="jenis" class="form-control" value="{{$item->jenis}}" id="jenis" placeholder="Jenis Barang">
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
                <!-- right column -->
                <div class="col-md-6">

                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

@endsection

@section('javascripts')

<!-- jquery-validation -->
<script src="<?= url('/'); ?>/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?= url('/'); ?>/plugins/jquery-validation/additional-methods.min.js"></script>
<script>
    $(function() {
        $.validator.setDefaults({
            submitHandler: function(form) {
                form.submit();
            }
        });
        $('#formItem').validate({
            rules: {
                nama: {
                    required: true,
                },
                spesifikasi: {
                    required: true,
                },
                harga: {
                    required: true,
                    number: true
                },
                satuan: {
                    required: true,
                },
                sumber: {
                    required: true,
                    url: true
                },
                gambar: {
                    required: true,
                },
                jenis: {
                    required: true,
                },
            },
            messages: {
                nama: {
                    required: "Tolong masukan nama barang",
                },
                spesifikasi: {
                    required: "Tolong masukan spesifikasi barang",
                },
                harga: {
                    required: "Tolong masukan harga barang",
                    number: "Masukan hanya boleh bernilai angka",
                },
                satuan: {
                    required: "Tolong masukan satuan barang",
                },
                sumber: {
                    required: "Tolong masukan sumber barang",
                    url: "Tolong masukan URL yang valid"
                },
                gambar: {
                    required: "Tolong masukan gambar barang",
                },
                jenis: {
                    required: "Tolong masukan jenis barang",
                },
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
@endsection