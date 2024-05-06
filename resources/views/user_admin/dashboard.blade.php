@extends('user_admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a class="text-dark" href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-6 col-6">
                    <!-- small box -->
                    <div class="small-box shadow bg-white rounded p-2">
                        <div class="inner">
                            <h2>{{$jmlPos}}</h2>
                            <p>Jumlah Posyandu</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-house-medical"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-6 col-6">
                    <!-- small box -->
                    <div class="small-box shadow bg-white rounded p-2">
                        <div class="inner">
                            <h2>{{$jmlAnak}}</h2>
                            <p>Total Jumlah Anak</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-children"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>

    {{-- Section 2 Calon --}}
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info shadow">
                    <div class="card-header">
                        <h2 class="card-title">Data Posyandu</h2>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @foreach ($pos as $key => $posyandu)
                                            <td>{{$key+1}}</td>
                                            <td>{{$posyandu->nama}}</td>
                                            <td>{{$posyandu->alamat}}</td>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-info shadow">
                    <div class="card-header">
                        <h2 class="card-title">Data Anak</h2>
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
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
