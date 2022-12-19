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
                    <a class="btn btn-outline-primary btn-sm" href="/user/add" role="button">Tambah User</a>
                </div>

                <!-- Table -->
                <div class="row my-4">
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <table class="table datatables" id="table-users" style="cursor: pointer;">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                        <tr>
                                            <td> {{$user->name}} </td>
                                            <td> {{$user->email}} </td>
                                            <td> {{$user->role}} </td>
                                            <td> </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
</script>
@endSection