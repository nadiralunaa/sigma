        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="mr-1 d-none d-lg-inline text-gray-600 small">Admin</span>
                        <img src="https://www.pngmart.com/files/21/Admin-Profile-PNG-Clipart.png" class="img-profile"
                            style="width: 30px;">
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <!-- Formulir logout dengan token CSRF -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <!-- Tombol Submit -->
                            <button type="submit" class="dropdown-item btn btn-link">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-500"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </li>
            </ul>

        </nav>
        <!-- /.navbar -->
