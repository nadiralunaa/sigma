@extends('user_posyandu.layouts.app')

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
            <!-- ./col -->
            <div class="col">
                <!-- small box -->
                <div class="small-box shadow bg-white rounded p-2">
                    <div class="inner">
                        <h2>{{ $jmlAnak }}</h2>
                        <p>Total Jumlah Anak</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-children"></i>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="small-box shadow bg-white rounded p-2">
                    <div id="plot"></div>
                </div>
            </div>

        </div>
        <!-- /.row -->
        <!-- /.container-fluid -->
    </section>

    {{-- Section 2 Calon --}}
    <section class="content">
        <div class="row">
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
                                        <th>Tanggal Lahir</th>
                                        <th>Alamat</th>
                                        <th>Nama Orang Tua</th>
                                        <th>Posysandu</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($anak as $key => $anak)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $anak->nama }}</td>
                                            @if ($anak->gender == 'p')
                                                <td>Perempuan</td>
                                            @else
                                                <td>Laki - Laki</td>
                                            @endif
                                            <td>{{ $anak->tanggal_lahir }}</td>
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

@push('scripts')
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Convert posyandu name to valid file name (optional: depends on how your files are named)
            const posyanduName = "{{ $pos->nama }}".replace(/\s+/g, '_').toLowerCase();
            const jsonFilePath = `/data/${posyanduName}`;

            console.log("Fetching JSON data from: " + jsonFilePath); // Debugging line

            // Fetch the JSON data
            fetch(jsonFilePath)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(data); // Debugging line

                    const traces = [];
                    const statusKeys = Object.keys(data);

                    statusKeys.forEach(status => {
                        const originalData = data[status].original;
                        const forecastData = data[status].forecast;

                        const originalTrace = {
                            x: originalData.map(item => item.Date),
                            y: originalData.map(item => item.Count),
                            mode: 'lines',
                            name: `${status} Observed`
                        };

                        const forecastTrace = {
                            x: forecastData.map(item => item.Date),
                            y: forecastData.map(item => item.Count),
                            mode: 'lines',
                            name: `${status} Forecast`,
                            line: {
                                dash: 'dash'
                            }
                        };

                        traces.push(originalTrace, forecastTrace);
                    });

                    const layout = {
                        title: 'Grafik Kondisi Anak Posyandu ' + '{{$pos->nama}}',
                        xaxis: {
                            title: 'Bulan'
                        },
                        yaxis: {
                            title: 'Jumlah'
                        }
                    };

                    // Plot the data using Plotly
                    Plotly.newPlot('plot', traces, layout);
                })
                .catch(error => {
                    console.error('Error fetching the JSON data:', error); // Debugging line
                });
        });
    </script>
@endpush
