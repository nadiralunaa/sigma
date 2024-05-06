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
                                <h2 class="card-title mb-0">Tabel Anak</h2>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <form action="{{ route('posyandu.update', $posyandu->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>Masukan Nama Puskesmas :</label>
                                <input type="text" name="nama" class="form-control" value="{{ $posyandu->nama }}" required>
                            </div>
                            <div class="form-group">
                                <label>Masukan Alamat Puskesmas :</label>
                                <input type="text" name="alamat" class="form-control" value="{{ $posyandu->alamat }}" required>
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
