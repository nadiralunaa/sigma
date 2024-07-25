@extends('user_admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0">Data Anak</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a class="text-dark" href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item active">Anak</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- DataTables Example -->
<div class="container-fluid p-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info shadow">
                <div class="card-header">
                    <h2 class="card-title"></h2>

                    <div class="row justify-content-between align-items-center">
                        <div class="col-12 col-md-auto text-md-left mb-3 mb-md-0">
                            <h2 class="card-title mb-0">Tabel User</h2>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Masukan Nama User:</label>
                            <input type="text" name="name" class="form-control" value="{{$user->name}}">
                        </div>
                        <div class="form-group">
                            <label>Masukan Email User</label>
                            <input type="email" name="email" class="form-control" value="{{$user->email}}">
                        </div>
                        <div class="form-group">
                            <label>Masukan No Telpon :</label>
                            <input type="text" name="no_telp" class="form-control" value="{{$user->no_telp}}">
                        </div>
                        <div class="form-group">
                            <label>Masukan Alamat :</label>
                            <input type="text" name="alamat" class="form-control" value="{{$user->alamat_users}}">
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
                                <option value="{{ $posyandu->id }}" {{ $user->kode_posyandu == $posyandu->id ? 'selected' : '' }}>{{ $posyandu->nama }}</option>
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer justify-content-between" style="margin-top: 10px">
                            <a href="{{URL::previous()}}"><button type="button" class="btn btn-default">Batal</button></a>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
