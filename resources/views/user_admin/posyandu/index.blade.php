@extends('user_admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Posyandu</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a class="text-dark" href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Posyandu</li>
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
                                <h2 class="card-title mb-0">Tabel Posyandu</h2>
                            </div>

                            <div class="col-12 col-md-auto text-md-right">
                                <button type="button" class="btn"
                                    style="background-color: #004085; border-color: #004085; color: #ffffff;"
                                    data-toggle="modal" data-target=".bd-example-modal-lg">
                                    <i class="fas fa-arrow-up-from-bracket"></i> Tambah Data Posyandu</button>
                                <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
                                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" style="color: black">Tambah Data Posyandu</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"><span aria-hidden="true">x</span></button>
                                            </div>
                                            <div class="modal-body" style="text-align: left;color:black">
                                                <form action="{{ route('posyandu.store') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label>Masukan Nama Puskesmas :</label>
                                                        <input type="text" name="nama" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Masukan Alamat Puskesmas :</label>
                                                        <input type="text" name="alamat" class="form-control">
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
                                        <th>Alamat</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($posyandu as $key => $posyandu)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$posyandu->nama}}</td>
                                        <td>{{$posyandu->alamat}}</td>
                                        <td>
                                            <span>
                                                {{-- Edit --}}
                                                <a href="{{ route('posyandu.edit', $posyandu->id) }}" class="btn btn-warning btn-sm"><i
                                                        class="fas fa-edit"></i></a>
                                            </span>
                                            <form action="{{ route('posyandu.destroy', $posyandu->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')   
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus posyandu ini?')"><i class="fas fa-trash-alt"></i></button>
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
