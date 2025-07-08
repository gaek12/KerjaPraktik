
<!DOCTYPE html>
<html>
   <head>
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>@yield('title')</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" type="text/css" href="{{ url('css/bootstrap.min.css') }}">
      <!-- style css -->
      <link rel="stylesheet" type="text/css" href="{{ url('css/style.css') }}">
      <!-- Responsive-->
      <link rel="stylesheet" href="{{ url('css/responsive.css') }}">
      <!-- fevicon -->
      <link rel="icon" href="{{ url('images/logo.png') }}" type="image/gif" />
      <!-- fonts -->
      <link href="https://fonts.googleapis.com/css?family=Poppins:400,700|Sen:400,700,800&display=swap" rel="stylesheet">
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="{{ url('css/jquery.mCustomScrollbar.min.css') }}">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
   </head>
   <body>
        <div class="header_section">
            <div class="container">
                <!-- Logo di atas -->
                <div class="text-center mt-3 mb-2">
                    <a href="#"><img src="{{ url('images/logo.png') }}" style="height: 60px;"></a>
                </div>
                <!-- Navbar -->
                <nav class="navbar navbar-expand-lg navbar-dark bg-transparant">
                    <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                        <ul class="navbar-nav">
                            <li class="nav-item"><a class="nav-link" href="{{ url('/dashboard') }}">Dashboard</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('kendaraan.index') }}#kendaraan">Data Kendaraan</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('kendaraan.create') }}#tambahkendaraan">Tambah Kendaraan</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('perbaikan.index') }}#perbaikan"">Riwayat Perbaikan</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Tambah Perbaikan</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Kontak</a></li>
                            <li class="nav-item">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="#" class="nav-link" onclick="event.preventDefault(); this.closest('form').submit();">
                                        Logout
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <!-- banner section start --> 
            <div class="banner_section layout_padding mt-3">
                <div id="my_slider" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="container-fluid">
                                <div class="row justify-content-center">
                                    <div class="col-12 text-center">
                                        <div class="banner_img">
                                            <img src="{{ url('images/background2.jpg') }}" class="img-fluid" style="height: auto; max-height: 550px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <div class="banner_img">
                                            <img src="{{ url('images/background1.jpg') }}" class="img-fluid mx-auto d-block" alt="banner">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <a class="carousel-control-prev" href="#my_slider" role="button" data-slide="prev">
                    <i class="fa fa-angle-left"></i>
                    </a>
                    <a class="carousel-control-next" href="#my_slider" role="button" data-slide="next">
                    <i class="fa fa-angle-right"></i>
                    </a>
                </div>
            </div>
         <!-- banner section end -->
        </div>
        <!-- header section end -->
        <!-- content section start -->
        <div class="domain_section">
            <div class="container">
                <div class="domain_box">
                    @yield('content')
                </div>
            </div>
        </div>
        <!-- content section end -->
        <!-- Javascript files-->
        <script src="{{ url('js/jquery.min.js') }}"></script>
        <script src="{{ url('js/popper.min.js') }}"></script>
        <script src="{{ url('js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ url('js/jquery-3.0.0.min.js') }}"></script>
        <script src="{{ url('js/plugin.js') }}"></script>
        <!-- sidebar -->
        <script src="{{ url('js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
        <script src="{{ url('js/custom.js') }}"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const hash = window.location.hash;
                if (hash) {
                    const el = document.querySelector(hash);
                    if (el) {
                        el.scrollIntoView({ behavior: "smooth" });
                    }
                }
            });
        </script>
        @stack('scripts')
   </body>
</html>