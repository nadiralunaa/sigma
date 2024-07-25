@extends('user_admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah User Posyandu</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a class="text-dark" href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item active">User</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="container-fluid p-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info shadow">
                    <div class="card-header">
                        <h2 class="card-title"></h2>

                        <div class="row justify-content-between align-items-center">
                            <div class="col-12 col-md-auto text-md-left mb-3 mb-md-0">
                                <h2 class="card-title mb-0">Tabel User Posyandu</h2>
                            </div>

                            <div class="col-12 col-md-auto text-md-right">
                                <button type="button" class="btn"
                                    style="background-color: #004085; border-color: #004085; color: #ffffff;"
                                    data-toggle="modal" data-target="#tambahDataAnakModal">
                                    <i class="fas fa-arrow-up-from-bracket"></i> Tambah Data User
                                </button>
                                <div class="modal fade" id="tambahDataAnakModal" tabindex="-1" role="dialog"
                                    aria-labelledby="tambahDataAnakModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" style="color: black">Tambah Data User</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"><span aria-hidden="true">x</span></button>
                                            </div>
                                            <div class="modal-body" style="text-align: left;color:black">
                                                <form action="{{ route('users.store') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label>Masukan Nama User:</label>
                                                        <input type="text" name="name" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Masukan Email User</label>
                                                        <input type="email" name="email" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Masukan No Telpon :</label>
                                                        <input type="text" name="no_telp" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Masukan Alamat :</label>
                                                        <input type="text" name="alamat" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Masukan Password User:</label>
                                                        <input type="text" name="password" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Pilih Lokasi Posyandu:</label>
                                                        <select name="kode_posyandu" id="" class="form-control">
                                                            <option value="">Pilih Posyandu</option>
                                                            @foreach ($posyandu as $posyandu)
                                                                <option value="{{ $posyandu->id }}">{{ $posyandu->nama }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="modal-footer justify-content-between"
                                                        style="margin-top: 10px">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Alamat</th>
                                        <th>No Telpon</th>
                                        <th>Posysandu</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($users as $key => $user)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->alamat_users }}</td>
                                            <td>{{ $user->no_telp }}</td>
                                            <td>{{ $user->posyandu->nama }}</td>
                                            <td>
                                                <span>
                                                    {{-- Edit --}}
                                                    <a href="{{ route('users.edit', $user->id) }}"
                                                        class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                                </span>
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                    style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')"><i
                                                            class="fas fa-trash-alt"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
