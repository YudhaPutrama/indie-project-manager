<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<head>
    <meta charset="utf-8"/>
    <title>{{ config('app.name') }}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="{{ Config::get('app.name') }}" name="description"/>
    <meta content="Yudha Putrama" name="author"/>
    <!-- BEGIN STYLES -->
    @yield('css-depends')
    <!-- END STYLES -->
    <link rel="shortcut icon" href="favicon.ico"/>
</head>
<body class="page-header-fixed page-container-bg-solid">
<div class="page-header navbar navbar-fixed-top">
    <div class="page-header-inner">
        <div class="page-logo">
            <a href="/">
                <img src="/img/logo-indie.png" alt="logo" class="logo-default"/>
            </a>
        </div>
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
        </a>
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
                <!-- BEGIN NOTIFICATION DROPDOWN -->
                <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                    <a href="javascript;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <i class="icon-bell"></i>
                        <span class="badge badge-default">{{ Auth::user()->notifications->count() }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="external">
                            <h3><span class="bold">{{ Auth::user()->notifications->count() }} </span> notifications</h3>
                            <a href="{{ url('/notifications') }}">view all</a>
                        </li>
                        <li>
                            <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                @foreach(Auth::user()->notifications as $notification)
                                    <li>
                                        <a href="javascript:;">
                                            <span class="time"></span>
                                            <span class="details">
									            <span class="label label-sm label-icon label-success">
                                                   <i class="fa fa-plus"></i>
                                                </span>
	            								{{ $notification }}
                                            </span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </li>
                <!-- END NOTIFICATION DROPDOWN -->
                @if(isset($progress))
                <!-- BEGIN PROGRESS DROPDOWN -->
                <li class="dropdown dropdown-extended dropdown-tasks" id="header_task_bar">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <i class="icon-calendar"></i>
                        <span class="badge badge-default">
					3 </span>
                    </a>
                    <ul class="dropdown-menu extended tasks">
                        <li class="external">
                            <h3>You have <span class="bold">12 pending</span> tasks</h3>
                            <a href="/">view all</a>
                        </li>
                        <li>
                            <ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                                @foreach($progresses as $progress)
                                    <li>
                                        <a href="javascript:;">
                                        <span class="task">
                                        <span class="desc">New release v1.2 </span>
                                        <span class="percent">30%</span>
                                        </span>
                                            <span class="progress">
                                        <span style="width: 40%;" class="progress-bar progress-bar-success" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"><span class="sr-only">40% Complete</span></span>
                                        </span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </li>
                <!-- END TO DO DROPDOWN -->
                @endif
                <!-- BEGIN USER LOGIN DROPDOWN -->
                <li class="dropdown dropdown-user">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <img alt="" id="avatar-img" class="img-circle" src="{{ "/uploads/avatar/".((Auth::user()->avatar!=null)?Auth::user()->avatar:"default.jpg") }}"/>
                        <span class="username username-hide-on-mobile">{{ Auth::user()->nickname }}</span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        <li>
                            <a href="{{ url('/profile') }}">
                                <i class="icon-user"></i> Profile </a>
                        </li>
                        <li>
                            <a href="{{ url('/projects') }}">
                                <i class="icon-calendar"></i> Projects </a>
                        </li>
                        <li class="divider">
                        </li>
                        <li>
                            <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="icon-key"></i> Log Out </a>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            </form>
                        </li>
                    </ul>
                </li>
                <!-- END USER LOGIN DROPDOWN -->
            </ul>
        </div>
    </div>
</div>
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar-wrapper">
        {{--@yield('sidebar')--}}
        @include('layouts.sidebar')
    </div>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
        @yield('content')
        </div>
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer">
    <div class="page-footer-inner">
        2016 &copy; Develop by MiniArch Developer
    </div>
    <div class="scroll-to-top">
        <i class="icon-arrow-up"></i>
    </div>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS -->
@yield('js-depends')
<!-- END JAVASCRIPTS -->
</body>
</html>