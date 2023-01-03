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
                </div>
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @elseif (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
                @endif
                <div class="card-deck">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <strong class="card-title">Profile</strong>
                        </div>
                        <div class="card-body">
                            <form action="{{ url('account/update') }}" method="POST">
                                <div class="form-group">
                                    <label for="inputEmail4">Email</label>
                                    <input type="email" class="form-control" value="{{Auth::user()->email}}"
                                        id="inputEmail4" name="email" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="name" class="form-control" id="nama"
                                        value="{{Auth::user()->name}}">
                                </div>
                                <button type="submit" class="btn btn-primary">Ubah</button>
                            </form>
                        </div>
                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <strong class="card-title">Password</strong>
                        </div>
                        <div class="card-body">
                            <form action="{{ url('account/updatepassword') }}" method="POST">

                                <div class="form-group row">
                                    <label for="old_password" class="col-sm-3 col-form-label">Password Lama</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" name="old_password"
                                            id="old_password" placeholder="Old Password">
                                        @error('old_password')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Password Baru</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" id="inputPassword3"
                                            name="new_password" placeholder="Confirm New Password">
                                        @error('new_password')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-2">
                                    <button type="submit" class="btn btn-primary">Ubah Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- / .card-desk-->

            </div>
        </div>
    </div>

</main>

@endSection

@section('script'); ?>
<script>
</script>
@endSection