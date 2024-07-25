<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sistem Integrasi Monitoring Anak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        .navbar-brand img {
            height: 50px;
        }

        .hero {
            padding: 50px 0;
            text-align: center;
        }

        .hero img {
            max-width: 100%;
            height: 541px;
        }

        .gallery img {
            width: 100%;
            height: auto;
        }

        .counter {
            text-align: center;
            font-size: 2rem;
            padding: 20px;
            border: 1px solid #ddd;
            margin: 10px;
            border-radius: 10px;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 20px 0;
            text-align: center;
        }

        .lokasi-posyandu {
            background-color: #433A33;
        }

        #map {
            height: 500px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#"><img src="{{asset('img/LOGO SIGMA.png')}}" alt="Logo" /></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Posyandu</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#">Gallery</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="#user-section">Pengguna Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-dark text-white" href="{{route('show.login')}}"><i class="bi bi-people-fill"></i>
                            Masuk</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Footer -->
    <footer class="footer bg-light">
        <div class="container">
            <div class="row" style="text-align: start">
                <div class="col-md-1">
                    <img src="{{asset('img/LOGO SIGMA.png')}}" style="height: 30px;" alt="Logo" />
                </div>
                <div class="col-md-7">
                    <h5>Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Status Gizi</a></li>
                        <li><a href="#">Lokasi</a></li>
                        <li><a href="#">Gallery</a></li>
                        <li><a href="#">Pengguna Kami</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <p>
                        <i class="bi bi-geo-alt-fill"></i> Telkom University Surabaya. Jl.
                        Ketintang No.156,. Ketintang,. Kec. Gayungan,. Surabaya 60231,.
                        Jawa Timur, Indonesia.
                    </p>
                    <p style="font-size: large">
                        <i class="bi bi-person"></i> Nadira Luna Ramadhani
                    </p>
                    <p>© 2024 Sigma. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <!-- Stack for scripts -->
    @stack('scripts')
    </body>

</html>
