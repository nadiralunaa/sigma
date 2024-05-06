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

                            <div class="col-12 col-md-auto text-md-right">
                                <button type="button" class="btn"
                                    style="background-color: #004085; border-color: #004085; color: #ffffff;"
                                    data-toggle="modal" data-target=".bd-example-modal-lg">
                                    <i class="fas fa-arrow-up-from-bracket"></i> Tambah Data Anak</button>
                                <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
                                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" style="color: black">Tambah Data Anak</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"><span aria-hidden="true">x</span></button>
                                            </div>
                                            <div class="modal-body" style="text-align: left;color:black">
                                                <form action="{{ route('anaks.store') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label>Masukan Nama Anak :</label>
                                                        <input type="text" name="nama" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Pilih Jenis Kelamin Anak :</label>
                                                        <select name="gender" id="" class="form-control">
                                                            <option value="">Pilih Jenis Kelamin</option>
                                                            <option value="l">Laki - Laki</option>
                                                            <option value="p">Perempuan</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Masukan Umur Anak :</label>
                                                        <input type="number" name="umur" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Masukan Alamat Anak :</label>
                                                        <input type="text" name="alamat" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Masukan Nama Orang Tua Anak :</label>
                                                        <input type="text" name="namaortu" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Pilih Lokasi Posyandu Anak:</label>
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
                                        <th>Jenis Kelamin</th>
                                        <th>Umur</th>
                                        <th>Alamat</th>
                                        <th>Nama Orang Tua</th>
                                        <th>Posysandu</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($anak as $key => $anak)
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td>{{ $anak->nama }}</td>
                                            @if ( $anak->gender =='p')
                                                <td>Perempuan</td>
                                            @else
                                                <td>Laki - Laki</td>
                                            @endif
                                            <td>{{ $anak->umur }}</td>
                                            <td>{{ $anak->alamat }}</td>
                                            <td>{{ $anak->namaortu }}</td>
                                            <td>{{ $anak->posyandu->nama }}</td>
                                            <td>
                                                <span>
                                                    {{-- Edit --}}
                                                    <a href="{{ route('anaks.edit', $anak->id) }}" class="btn btn-warning btn-sm"><i
                                                            class="fas fa-edit"></i></a>
                                                </span>
                                                <form action="{{ route('anaks.destroy', $anak->id) }}" method="POST"
                                                    style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus anak ini?')"><i class="fas fa-trash-alt"></i></button>
                                                </form>
                                                <span>
                                                    {{-- Edit --}}
                                                    <a href="{{route('penimbangan.create',$anak->id)}}" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen-ruler"></i></a>
                                                </span>
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
