@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('css-depends')
    @include('components.css.core')
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="/vendor/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css"/>
    <link href="/css/pages/portfolio.css" rel="stylesheet" type="text/css"/>
    <!-- END PAGE LEVEL STYLES -->
@endsection

@section('js-depends')
    @include('components.js.core')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script type="text/javascript" src="/vendor/jquery-mixitup/jquery.mixitup.min.js"></script>
    <script type="text/javascript" src="/vendor/fancybox/source/jquery.fancybox.pack.js"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <script src="/js/metronic.js" type="text/javascript"></script>
    <script src="/js/layout.js" type="text/javascript"></script>
    <script src="/js/pages/portfolio.js"></script>
    <script>
        jQuery(document).ready(function() {
            Metronic.init(); // init metronic core components
            Layout.init(); // init current layout
            Portfolio.init();
        });
    </script>
@endsection

@section('content')
        <!-- BEGIN PAGE HEADER-->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Project</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Gallery</a>
                </li>
            </ul>
            <div class="page-toolbar">
                <div class="btn-group pull-right">
                    <a class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
                        Upload<i class="fa fa-angle-down"></i>
                    </a>
                </div>
            </div>
        </div>
        <h3 class="page-title">
            Gallery <small></small>
        </h3>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-12">
                            <!-- BEGIN FILTER -->
                            <div class="filter-v1 margin-top-10">
                                <ul class="mix-filter">
                                    <li class="filter" data-filter="all">
                                        All
                                    </li>
                                    <li class="filter" data-filter="category_1">
                                        UI Design
                                    </li>
                                    <li class="filter" data-filter="category_2">
                                        Web Development
                                    </li>
                                    <li class="filter" data-filter="category_3">
                                        Photography
                                    </li>
                                    <li class="filter" data-filter="category_3 category_1">
                                        Wordpress and Logo
                                    </li>
                                </ul>
                                <div class="row mix-grid thumbnails">
                                    <div class="col-md-4 col-sm-6 mix category_1">
                                        <div class="mix-inner">
                                            <img class="img-responsive" src="/img/works/img1.jpg" alt="">
                                            <div class="mix-details">
                                                <h3>Cascusamus et iusto odio</h3>
                                                <p>
                                                    At vero eos et accusamus et iusto odio digniss imos duc sasdimus qui sint blanditiis prae sentium.
                                                </p>
                                                <a class="mix-link">
                                                    <i class="fa fa-link"></i>
                                                </a>
                                                <a class="mix-preview fancybox-button" href="/img/works/img1.jpg" title="Project Name" data-rel="fancybox-button">
                                                    <i class="fa fa-search"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 mix category_2">
                                        <div class="mix-inner">
                                            <img class="img-responsive" src="/img/works/img2.jpg" alt="">
                                            <div class="mix-details">
                                                <h3>Cascusamus et iusto odio</h3>
                                                <p>
                                                    At vero eos et accusamus et iusto odio digniss imos duc sasdimus qui sint blanditiis prae sentium.
                                                </p>
                                                <a class="mix-link">
                                                    <i class="fa fa-link"></i>
                                                </a>
                                                <a class="mix-preview fancybox-button" href="/img/works/img2.jpg" title="Project Name" data-rel="fancybox-button">
                                                    <i class="fa fa-search"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 mix category_3">
                                        <div class="mix-inner">
                                            <img class="img-responsive" src="/img/works/img3.jpg" alt="">
                                            <div class="mix-details">
                                                <h3>Cascusamus et iusto odio</h3>
                                                <p>
                                                    At vero eos et accusamus et iusto odio digniss imos duc sasdimus qui sint blanditiis.
                                                </p>
                                                <a class="mix-link">
                                                    <i class="fa fa-link"></i>
                                                </a>
                                                <a class="mix-preview fancybox-button" href="/img/works/img3.jpg" title="Project Name" data-rel="fancybox-button">
                                                    <i class="fa fa-search"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 mix category_1 category_2">
                                        <div class="mix-inner">
                                            <img class="img-responsive" src="/img/works/img4.jpg" alt="">
                                            <div class="mix-details">
                                                <h3>Cascusamus et iusto odio</h3>
                                                <p>
                                                    At vero eos et accusamus et iusto odio digniss imos duc sasdimus qui sint blanditiis prae sentium.
                                                </p>
                                                <a class="mix-link">
                                                    <i class="fa fa-link"></i>
                                                </a>
                                                <a class="mix-preview fancybox-button" href="/img/works/img4.jpg" title="Project Name" data-rel="fancybox-button">
                                                    <i class="fa fa-search"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 mix category_2 category_1">
                                        <div class="mix-inner">
                                            <img class="img-responsive" src="/img/works/img5.jpg" alt="">
                                            <div class="mix-details">
                                                <h3>Cascusamus et iusto odio</h3>
                                                <p>
                                                    At vero eos et accusamus et iusto odio digniss imos duc sasdimus qui sint blanditiis prae.
                                                </p>
                                                <a class="mix-link">
                                                    <i class="fa fa-link"></i>
                                                </a>
                                                <a class="mix-preview fancybox-button" href="/img/works/img5.jpg" title="Project Name" data-rel="fancybox-button">
                                                    <i class="fa fa-search"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 mix category_1 category_2">
                                        <div class="mix-inner">
                                            <img class="img-responsive" src="/img/works/img6.jpg" alt="">
                                            <div class="mix-details">
                                                <h3>Cascusamus et iusto odio</h3>
                                                <p>
                                                    At vero eos et accusamus et iusto odio digniss imos duc sasdimus qui sint blanditiis prae sentium.
                                                </p>
                                                <a class="mix-link">
                                                    <i class="fa fa-link"></i>
                                                </a>
                                                <a class="mix-preview fancybox-button" href="/img/works/img6.jpg" title="Project Name" data-rel="fancybox-button">
                                                    <i class="fa fa-search"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 mix category_2 category_3">
                                        <div class="mix-inner">
                                            <img class="img-responsive" src="/img/works/img1.jpg" alt="">
                                            <div class="mix-details">
                                                <h3>Cascusamus et iusto odio</h3>
                                                <p>
                                                    At vero eos et accusamus et iusto odio digniss imos duc sasdimus qui sint blanditiis.
                                                </p>
                                                <a class="mix-link">
                                                    <i class="fa fa-link"></i>
                                                </a>
                                                <a class="mix-preview fancybox-button" href="/img/works/img1.jpg" title="Project Name" data-rel="fancybox-button">
                                                    <i class="fa fa-search"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 mix category_1 category_2">
                                        <div class="mix-inner">
                                            <img class="img-responsive" src="/img/works/img2.jpg" alt="">
                                            <div class="mix-details">
                                                <h3>Cascusamus et iusto odio</h3>
                                                <p>
                                                    At vero eos et accusamus et iusto odio digniss imos duc sasdimus qui sint blanditiis prae sentium.
                                                </p>
                                                <a class="mix-link">
                                                    <i class="fa fa-link"></i>
                                                </a>
                                                <a class="mix-preview fancybox-button" href="/img/works/img2.jpg" title="Project Name" data-rel="fancybox-button">
                                                    <i class="fa fa-search"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 mix category_3">
                                        <div class="mix-inner">
                                            <img class="img-responsive" src="/img/works/img4.jpg" alt="">
                                            <div class="mix-details">
                                                <h3>Cascusamus et iusto odio</h3>
                                                <p>
                                                    At vero eos et accusamus et iusto odio digniss imos duc sasdimus qui sint blanditiis.
                                                </p>
                                                <a class="mix-link">
                                                    <i class="fa fa-link"></i>
                                                </a>
                                                <a class="mix-preview fancybox-button" href="/img/works/img4.jpg" title="Project Name" data-rel="fancybox-button">
                                                    <i class="fa fa-search"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 mix category_1">
                                        <div class="mix-inner">
                                            <img class="img-responsive" src="/img/works/img3.jpg" alt="">
                                            <div class="mix-details">
                                                <h3>Cascusamus et iusto odio</h3>
                                                <p>
                                                    At vero eos et accusamus et iusto odio digniss imos duc sasdimus qui sint blanditiis prae sentium voluptatum.
                                                </p>
                                                <a class="mix-link">
                                                    <i class="fa fa-link"></i>
                                                </a>
                                                <a class="mix-preview fancybox-button" href="/img/works/img3.jpg" title="Project Name" data-rel="fancybox-button">
                                                    <i class="fa fa-search"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END FILTER -->
            </div>
        </div>
        <!-- END PAGE CONTENT-->
@endsection