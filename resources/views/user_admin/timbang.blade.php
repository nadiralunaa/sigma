@extends('user_admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">Proses Pengukuran</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a class="text-dark" href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Pengukuran</li>
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
                                <h2 class="card-title mb-0">Nilai Pengukuran</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{route("timbang")}}" method="POST">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="id_anak" value="{{ $anak->id }}">
                                <div class="col-md-6 col-sm-12">
                                    <div class="card" style="width: 18rem;text-align: center;align-items: center;">
                                        <div class="card-body">
                                            <label for="beratInput">tanggal penimbangan:</label>
                                            <input type="date" name="tanggal">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="card" style="width: 18rem;text-align: center;align-items: center;">
                                          {{-- <img src="{{ asset('img/weight.png') }}" class="card-img-top" alt="..."> --}}
                                        <div class="card-body">
                                            <label for="beratInput">Umur Dalam Bulan:</label>
                                            <input type="text" name="umur">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="card" style="width: 18rem;text-align: center;align-items: center;">
                                        <img src="{{ asset('img/weight.png') }}" class="card-img-top" style="height: 50px;width:50px" alt="...">
                                        <div class="card-body">
                                            <label for="beratInput">Berat Sensor (kg):</label>
                                            <input type="text" id="beratInput" name="beratsensor" value="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="card" style="width: 18rem;text-align: center;align-items: center;">
                                        <img src="{{ asset('img/height.png') }}" class="card-img-top" style="height: 50px;width:50px" alt="...">
                                        <div class="card-body">
                                            <label for="tinggiInput">Tinggi Sensor (cm):</label>
                                            <input type="text" id="tinggiInput" name="tinggisensor" value="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="card" style="width: 18rem;text-align: center;align-items: center;">
                                        <img src="{{ asset('img/weight.png') }}" class="card-img-top" style="height: 50px;width:50px" alt="...">
                                        <div class="card-body"> 
                                            <label for="beratInput">Berat Asli (kg):</label>
                                            <input type="text" id="beratInput" name="beratasli" value="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="card" style="width: 18rem;text-align: center;align-items: center;">
                                        <img src="{{ asset('img/height.png') }}" class="card-img-top" style="height: 50px;width:50px" alt="...">
                                        <div class="card-body">
                                            <label for="tinggiInput">Tinggi Asli (cm):</label>
                                            <input type="text" id="tinggiInput" name="tinggiasli" value="0">
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Umur</th>
                                        <th>Berat Asli</th>
                                        <th>Tingi Asli</th>
                                        <th>Berat Sensor</th>
                                        <th>Tinggi Sensor</th>
                                        <th>Status Gizi</th>
                                        <th>Tanggal Penimbangan</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($riwayat as $key => $riwayat)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$riwayat->umur}} Bulan</td>
                                        <td>{{$riwayat->berat_asli}} Kg</td>
                                        <td>{{$riwayat->tinggi_asli}} Cm</td>
                                        <td>{{$riwayat->berat_sensor}} Kg</td>
                                        <td>{{$riwayat->tinggi_sensor}} Cm</td>
                                        <td>{{$riwayat->status_gizi}}</td>
                                        <td>{{ \Carbon\Carbon::parse($riwayat->tanggal_timbang)->format('Y-m-d') }}</td>
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

    <script>
        // Function to fetch data from API and fill form inputs
        async function updateData() {
            try {
                const response = await fetch('/latest-data'); // Endpoint Laravel API
                if (!response.ok) {
                    throw new Error('Gagal mengambil data dari API');
                }
                const data = await response.json();
                document.getElementById('beratInput').value = data.berat;
                document.getElementById('tinggiInput').value = data.tinggi;
                } catch (error) {
                    console.error('Terjadi kesalahan:', error);
                }
        }

        setInterval(updateData, 1000); // Poll every 10 second
        updateData(); // Initial fetch
    </script>
@endsection
