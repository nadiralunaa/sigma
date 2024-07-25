@extends('user_posyandu.layouts.app')

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
                        <form action="{{ route('anaks.update', $anak->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>Masukan Nama Anak :</label>
                                <input type="text" name="nama" class="form-control" value="{{$anak->nama}}">
                            </div>
                            <div class="form-group">
                                <label>Pilih Jenis Kelamin Anak :</label>
                                <select name="gender" id="" class="form-control">
                                    @if ($anak->gender == 'p')
                                        <option value="p">perempuan</option>
                                        <option value="l">Laki - Laki</option>
                                    @else
                                        <option value="l">Laki - Laki</option>
                                        <option value="p">perempuan</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Masukan Umur Anak :</label>
                                <input type="number" name="umur" class="form-control" value="{{$anak->umur}}">
                            </div>
                            <div class="form-group">
                                <label>Masukan Alamat Anak :</label>
                                <input type="text" name="alamat" class="form-control" value="{{$anak->alamat}}">
                            </div>
                            <div class="form-group">
                                <label>Masukan Nama Orang Tua Anak :</label>
                                <input type="text" name="namaortu" class="form-control" value="{{$anak->namaortu}}">
                            </div>
                            <div class="form-group">
                                <label>Pilih Lokasi Posyandu Anak:</label>
                                <select name="kode_posyandu" id="" class="form-control" disabled>
                                    <option value="{{ $posyandu->id }}" {{ $anak->kode_posyandu == $posyandu->id ? 'selected' : '' }}>{{ $posyandu->nama }}</option>
                                        </option>
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
