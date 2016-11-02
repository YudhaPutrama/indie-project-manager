
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Indie Corporation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all">
    <link href="/css/themify-icons.css" rel="stylesheet" type="text/css" media="all" />
    <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all" />
    <link href="css/flexslider.css" rel="stylesheet" type="text/css" media="all" />
    <link href="css/theme.css" rel="stylesheet" type="text/css" media="all" />
    <link href="css/custom.css" rel="stylesheet" type="text/css" media="all" />
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400%7CRaleway:100,400,300,500,600,700%7COpen+Sans:400,500,600' rel='stylesheet' type='text/css'>
</head>
<body class="boxed-layout btn-rounded scroll-assist">
<div class="nav-container">
    <nav>
        <div class="nav-bar">
            <div class="module left">
                <a href="/">
                    <img class="logo logo-light" alt="Indie Logo" src="img/logo-light.png">
                    <img class="logo logo-dark" alt="Indie Logo" src="img/logo-dark.png">
                </a>
            </div>
            <div class="module widget-handle mobile-toggle right visible-sm visible-xs">
                <i class="ti-menu"></i>
            </div>
            <div class="module-group right">
                <div class="module left">
                    <ul class="menu">
                        <li>
                            <a href="/">Home</a>
                        </li>
                        <li>
                            <a href="{{ url('/gallery') }}">Gallery</a>
                        </li>
                        <li>
                            <a href="{{ url('/about') }}">About</a>
                        </li>
                        <li>
                            <a href="{{ url('/contact') }}">Contact</a>
                        </li>
                        <span class="nav-divider"></span>
                        @if(Auth::check())
                        <li>
                            <a href="{{ url('/profile') }}">Member Area</a>
                        </li>
                        @else
                        <li>
                            <a href="{{ url('/login') }}">Login</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</div>
<div class="main-container">
    @yield('content')
    <footer class="footer-2 bg-dark pt96 pt-xs-40">
        <div class="container">
            <div class="row mb64 mb-xs-24">
                <div class="col-sm-12">
                    <a href="#">
                        <img alt="logo" class="image-xxs" src="img/logo-light.png">
                    </a>
                </div>
            </div>
            <div class="row mb64 mb-xs-24">
                <div class="col-md-3 col-sm-4">
                    <ul>
                        <li><a href="#"><h5 class="uppercase mb16 fade-on-hover">Home</h5></a></li>
                        <li><a href="#"><h5 class="uppercase mb16 fade-on-hover">About</h5></a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-4">
                    <ul>
                        <li><a href="#"><h5 class="uppercase mb16 fade-on-hover">Press</h5></a></li>
                    </ul>
                </div>
                <div class="col-md-4 col-md-offset-2 col-sm-4">
                    <p class="lead">Follow Us</p>
                    <ul class="list-inline social-list">
                        <li><a href="#"><i class="ti-twitter-alt"></i></a></li>
                        <li><a href="#"><i class="ti-facebook"></i></a></li>
                        <li><a href="#"><i class="ti-dribbble"></i></a></li>
                        <li><a href="#"><i class="ti-vimeo-alt"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="row fade-half">
                <div class="col-sm-12 text-center">
                    <span>© Copyright 2016 MiniArch Developer - All Rights Reserved</span>
                </div>
            </div>
        </div>
    </footer>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/flexslider.min.js"></script>
<script src="js/masonry.min.js"></script>
<script src="js/parallax.js"></script>
<script src="js/scripts.js"></script>
</body>
</html>