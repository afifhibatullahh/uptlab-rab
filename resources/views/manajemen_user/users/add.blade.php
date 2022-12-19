@extends('template.layout')

@section('content')

<main role="main" class="main-content">
    <div class="container-fluid">
        <!-- Table -->
        <div class="row my-4">
            <div class="col-md-12">
                <form class="col-lg-6 col-md-8 col-10 mx-auto" id="userform" action="/user/store" method="POST">
                    <div class="mx-auto text-center my-4">
                        <h2 class="my-3">
                            <?= $title ?>
                        </h2>
                    </div>
                    @if(Session::get('error_email'))
                    <div class="alert alert-danger" role="alert">
                        {{Session::get('error_email')}}
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" id="email">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">Nama</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="laboratorium-select">Laboratorium</label>
                            <select class="form-control" name="laboratorium" id="laboratorium-select">
                                <option selected disabled>Pilih Laboratorium</option>
                                @foreach($laboratorium as $lab)
                                <option value={{$lab['id']}}>{{$lab['laboratorium']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <hr class="my-4">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputPassword5">Password Baru</label>
                                <input type="password" name="password" class="form-control" id="password">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputPassword6">Konfirmasi Password</label>
                                <input type="password" name="confirmPassword" class="form-control" id="inputPassword6">
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Simpan</button>
                </form>
            </div>
        </div>
        <!-- End of table -->
    </div>

</main>

@endSection

@section('script'); ?>

<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
<script>
    $('#userform').validate({ // initialize the plugin
        rules: {
            name: 'required',
            email: {
                required: true,
                email: true
            },
            laboratorium: 'required',
            password: 'required',
            confirmPassword: {
                equalTo: "#password"
            },
        },
        messages :{
        name : 'Masukan nama user',
        laboratorium : 'Pilih laboratorium',
        password : 'Masukan nama password',
        confirmPassword : {
            equalTo:'Password harus sama',
        },
        email : {
            required: "Masukan email user",
            email: "Email tidak valid"
        },
    }
    });

</script>
@endSection