@extends('user_guest.layout')

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel"
                data-bs-interval="5000">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row align-items-center">
                            <div class="col-md-6" style="text-align: start">
                                <h1>Aksi Bersama untuk Generasi Sehat</h1>
                                <p>
                                    Gunakan teknologi untuk mendeteksi dan mencegah stunting sejak
                                    dini. Mari ciptakan masa depan yang lebih baik.
                                </p>
                            </div>
                            <div class="col-md-6">
                                <img src="{{asset('img/cuate1.png')}}" alt="Hero Image" />
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row align-items-center ">
                            <div class="col-md-6" style="text-align: start">
                                <h1>Tentang Kami</h1>
                                <p>
                                    Selamat datang di Sigma, platform inovatif yang didedikasikan
                                    untuk mendeteksi dan mencegah stunting pada anak-anak di
                                    Indonesia. Kami memahami bahwa stunting adalah masalah
                                    kesehatan yang serius dan kompleks yang dapat mempengaruhi
                                    perkembangan fisik dan kognitif anak-anak kita. Oleh karena
                                    itu, kami hadir dengan solusi berbasis teknologi untuk
                                    membantu mengidentifikasi, memantau, dan mengatasi masalah
                                    stunting secara efektif.
                                </p>
                            </div>
                            <div class="col-md-6">
                                <img src="{{asset('img/cuate.png')}}" alt="Hero Image" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="gallery bg-warning py-5">
        <div class="container">
            <h2 class="text-center mb-4">Gallery</h2>
            <div class="row">
                <div class="col-md-3">
                    <div class="card" style="height: 440px">
                        <img src="{{asset('img/am8.png')}}" class="card-img-top" alt="Gallery Image 1" />
                        <div class="card-body">
                            <h5 class="card-title">Penimbangan Balita</h5>
                            <p class="card-text">
                                Melakukan Penimbangan Balita menggunakan Timbangan Stunting
                                Berbasis IoT
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card" style="height: 440px">
                        <img src="{{asset('img/asyik 1.png')}}" class="card-img-top" alt="Gallery Image 2" />
                        <div class="card-body">
                            <h5 class="card-title">Penimbangan di Melati 11</h5>
                            <p class="card-text">
                                Kegiatan penimbangan di Balita Posyandu Melati 11.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card" style="height: 440px">
                        <img src="{{asset('img/am2.png')}}" class="card-img-top" alt="Gallery Image 3" />
                        <div class="card-body">
                            <h5 class="card-title">Penyuluhan Anggrek Merpati 2</h5>
                            <p class="card-text">
                                Melakukan penyuluhan kepada Anggota Posyandu AM 2 mengenai
                                timbangan Stunting IoT.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card" style="height: 440px">
                        <img src="{{asset('img/am82.png')}}" class="card-img-top" alt="Gallery Image 4" />
                        <div class="card-body">
                            <h5 class="card-title">
                                Pengambilan Data di Posyandu Melati 8
                            </h5>
                            <p class="card-text">
                                Kegiatan pengambilan data balita pada Posyandu Melati 8.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Counters Section -->
    <section class="counters py-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-6">
                    <div class="counter bg-light">
                        <h3>Jumlah Posyandu</h3>
                        <p id="posyandu-count">0</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="counter bg-light">
                        <h3>Jumlah Anak Balita</h3>
                        <p id="anak-count">0</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Placeholder for Status Gizi -->
    <section class="status-gizi py-5">
        <div class="container text-center">
            <h2>Status Gizi</h2>
            <div id="line-chart"></div>
        </div>
    </section>

    <!-- Placeholder for Lokasi Posyandu -->
    <section class="lokasi-posyandu text-white py-5">
        <div class="container text-center">
            <h2 class="text-warning">Lokasi Posyandu</h2>
            <div id="map" class="border"></div>
        </div>
    </section>

    <!-- User Section -->
    <section id="user-section" class="user-section py-5">
        <div class="container">
            <h2 class="text-center">Pengguna Aplikasi</h2>
            <p class="text-center">
                Aplikasi ini dapat digunakan oleh berbagai pihak, mulai dari kader
                posyandu untuk melakukan pencatatan pemeriksaan berat badan dan tinggi
                anak, puskesmas mendapatkan laporan tentang data stunting.
            </p>
            <div class="row">
                <div class="col-md-4 user-card">
                    <h2><i class="bi bi-people"></i> Posyandu</h2>
                    <p>
                        Pencatatan dan pelaporan penimbangan anak secara otomatis
                        menggunakan timbangan Stunting Berbasis IoT oleh kader mudah
                        melalui Web.
                    </p>
                </div>
                <div class="col-md-4 user-card">
                    <h2><i class="bi bi-people-fill"></i> Orang Tua</h2>
                    <p>
                        Orang tua dapat memantau hasil penimbangan anak. Dan pelajari
                        pencegahan stunting melalui aplikasi.
                    </p>
                </div>
                <div class="col-md-4 user-card">
                    <h2><i class="bi bi-hospital"></i> Puskesmas</h2>
                    <p>
                        Monitoring, evaluasi dan kelola data penimbangan anak dari
                        posyandu secara lebih efektif, real time dan paper less.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <script>
        // Counter Animation
        document.addEventListener("DOMContentLoaded", function () {
            const counters = [
                { id: "posyandu-count", value: {{$jmlPos}} },
                { id: "anak-count", value: {{$jmlAnak}} },
            ];

            counters.forEach((counter) => {
                let count = 0;
                const updateCount = () => {
                    const target = counter.value;
                    const increment = target / 200;

                    if (count < target) {
                        count += increment;
                        document.getElementById(counter.id).innerText = Math.ceil(count);
                        setTimeout(updateCount, 10);
                    } else {
                        document.getElementById(counter.id).innerText = target;
                    }
                };

                updateCount();
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            // Initialize the map
            var map = L.map('map').setView([-7.327062845758115, 112.73093143487492], 13);

            // Add a tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
            }).addTo(map);

            // Fetch the posyandu data
            fetch('/api/maps')
                .then(response => response.json())
                .then(data => {
                    data.posyandu.forEach(posyandu => {
                        // Create a marker for each posyandu
                        var marker = L.marker([posyandu.latitude, posyandu.longitude]).addTo(map);

                        // Create popup content
                        var popupContent = `<strong>${posyandu.nama}</strong><br>`;
                        Object.keys(posyandu.status_gizi).forEach(status => {
                            popupContent += `${status}: ${posyandu.status_gizi[status]}<br>`;
                        });

                        // Bind popup to the marker
                        marker.bindPopup(popupContent).on('click', function () {
                            updateChart(posyandu.nama, posyandu.status_gizi);
                        });
                    });
                })
                .catch(error => {
                    console.error('Error fetching posyandu data:', error); // Debugging line
                });

            // Prepare data for Plotly
            const data = [
                {
                    "bulan": "jan",
                    "status_gizi": {
                        "Berisiko gizi lebih (possible risk of overweight)": 7,
                        "Gizi baik (normal)": 89,
                        "Gizi lebih (overweight)": 8,
                        "Obesitas (obese)": 1
                    }
                },
                {
                    "bulan": "feb",
                    "status_gizi": {
                        "Berisiko gizi lebih (possible risk of overweight)": 21,
                        "Gizi baik (normal)": 79,
                        "Gizi lebih (overweight)": 5,
                        "Obesitas (obese)": 1
                    }
                },
                {
                    "bulan": "mar",
                    "status_gizi": {
                        "Berisiko gizi lebih (possible risk of overweight)": 25,
                        "Gizi baik (normal)": 124,
                        "Gizi lebih (overweight)": 2,
                        "Obesitas (obese)": 2
                    }
                },
                {
                    "bulan": "apr",
                    "status_gizi": {
                        "Berisiko gizi lebih (possible risk of overweight)": 12,
                        "Gizi baik (normal)": 83,
                        "Gizi lebih (overweight)": 0,
                        "Obesitas (obese)": 0
                    }
                },
                {
                    "bulan": "may",
                    "status_gizi": {
                        "Berisiko gizi lebih (possible risk of overweight)": 9,
                        "Gizi baik (normal)": 96,
                        "Gizi lebih (overweight)": 0,
                        "Obesitas (obese)": 1
                    }
                },
                {
                    "bulan": "jun",
                    "status_gizi": {
                        "Berisiko gizi lebih (possible risk of overweight)": 10,
                        "Gizi baik (normal)": 147,
                        "Gizi lebih (overweight)": 0,
                        "Obesitas (obese)": 1
                    }
                },
                {
                    "bulan": "jul",
                    "status_gizi": {
                        "Berisiko gizi lebih (possible risk of overweight)": 12,
                        "Gizi baik (normal)": 106,
                        "Gizi lebih (overweight)": 0,
                        "Obesitas (obese)": 1
                    }
                }
            ];

            // Data for Line Chart
            const months = data.map(item => item.bulan);
            const riskOverweight = data.map(item => item.status_gizi["Berisiko gizi lebih (possible risk of overweight)"]);
            const goodNutrition = data.map(item => item.status_gizi["Gizi baik (normal)"]);
            const overweight = data.map(item => item.status_gizi["Gizi lebih (overweight)"]);
            const obese = data.map(item => item.status_gizi["Obesitas (obese)"]);

            const lineTrace1 = {
                x: months,
                y: riskOverweight,
                type: 'scatter',
                mode: 'lines+markers',
                name: 'Berisiko gizi lebih'
            };

            const lineTrace2 = {
                x: months,
                y: goodNutrition,
                type: 'scatter',
                mode: 'lines+markers',
                name: 'Gizi baik (normal)'
            };

            const lineTrace3 = {
                x: months,
                y: overweight,
                type: 'scatter',
                mode: 'lines+markers',
                name: 'Gizi lebih'
            };

            const lineTrace4 = {
                x: months,
                y: obese,
                type: 'scatter',
                mode: 'lines+markers',
                name: 'Obesitas'
            };

            const linePlotData = [lineTrace1, lineTrace2, lineTrace3, lineTrace4];

            const lineLayout = {
                title: 'Status Gizi per Bulan',
                xaxis: {
                    title: 'Bulan'
                },
                yaxis: {
                    title: 'Jumlah'
                },
                responsive: true
            };

            // Plot the line chart using Plotly
            Plotly.newPlot('line-chart', linePlotData, lineLayout);

            function updateChart(posyanduName, statusGizi) {
                var labels = Object.keys(statusGizi);
                var data = Object.values(statusGizi);

                Plotly.restyle('line-chart', 'values', [data]);
                Plotly.relayout('line-chart', {
                    title: `Status Gizi di ${posyanduName}`
                });
            }
        });
    </script>
@endsection
