@extends('layouts.app')

@section('css-depends')
    @include('components.css.core')
    @include('components.css.profile')
@endsection

@section('js-depends')
    @include('components.js.core')
    @include('components.js.profile')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
<!-- BEGIN PAGE HEADER-->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="/">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="{{ url('/profile') }}">Profile</a>
        </li>
    </ul>
</div>
<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<div class="row margin-top-20">
    <div class="col-md-12">
        <!-- BEGIN PROFILE SIDEBAR -->
        <div class="profile-sidebar">
            <!-- PORTLET MAIN -->
            <div class="portlet light">
                <!-- SIDEBAR USERPIC -->
                <div class="profile-userpic">
                    <img src="{{ '/uploads/avatar/'.$user['avatar'] }}" class="img-responsive" alt="">
                </div>
                <!-- END SIDEBAR USERPIC -->
                <!-- SIDEBAR USER TITLE -->
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name">{{ $user['fullname'] }}</div>
                    <div class="profile-usertitle-job">{{ $user['title'] }}</div>
                </div>
                <!-- END SIDEBAR USER TITLE -->
                <!-- SIDEBAR BUTTONS -->
                <div class="profile-userbuttons">
                    <a href="{{ ($user['id']==Auth::user()->id)?'/profile/edit':'/user/'.$user['id'].'/edit' }}" class="btn btn-circle green-haze btn-sm">EDIT</a>
                    @if(Entrust::hasRole('admin'))<a class="btn btn-circle btn-danger btn-sm">DELETE</a>@endif
                </div>
                <!-- END SIDEBAR BUTTONS -->
                <div class="margin-top-20">
                    <h4 class="profile-desc-title">About</h4>
                    <span class="profile-desc-text">{{ $user['bio'] }}</span>
                    <div class="margin-top-20 profile-desc-link">
                        <i class="fa fa-phone"></i>
                        <a>{{ $user['phone'] }}</a>
                    </div>
                    <div class="margin-top-20 profile-desc-link">
                        <i class="fa fa-twitter"></i>
                        <a href="{{ $user['twitter'] }}">Twitter</a>
                    </div>
                    <div class="margin-top-20 profile-desc-link">
                        <i class="fa fa-facebook"></i>
                        <a href="{{ $user['facebook'] }}">Facebook</a>
                    </div>
                </div>
            </div>
            <!-- END PORTLET MAIN -->
        </div>
        <!-- END BEGIN PROFILE SIDEBAR -->
        <!-- BEGIN PROFILE CONTENT -->

        <div class="profile-content">
            {{--
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN PORTLET -->
                    <div class="portlet light">
                        <div class="portlet-title tabbable-line">
                            <div class="caption caption-md">
                                <i class="icon-globe theme-font hide"></i>
                                <span class="caption-subject font-blue-madison bold uppercase">Activities</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="scroller" style="height: 320px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                                <ul class="feeds">
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-success">
                                                        <i class="fa fa-bell-o"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc">You have 4 pending tasks.
                                                        <span class="label label-sm label-info">
                                                            Take action <i class="fa fa-share"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date">
                                                Just now
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-danger">
                                                        <i class="fa fa-bolt"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc">
                                                        Database server #12 overloaded. Please fix the issue.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date">
                                                24 mins
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- END PORTLET -->
                </div>
            </div>
            --}}
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN PORTLET -->
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption caption-md">
                                <i class="icon-bar-chart theme-font hide"></i>
                                <span class="caption-subject font-blue-madison bold uppercase">Last Comments</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="scroller" style="height: 305px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                                <div class="general-item-list">
                                    @if(isset($comments))
                                        @foreach($comments as $comment)
                                            <div class="item">
                                                <div class="item-head">
                                                    <div class="item-details">
                                                        <a href="" class="item-name primary-link">{{ $comment['title'] }}</a>
                                                        <span class="item-label">@if($comment['isRead']=='1') new @endif</span>
                                                    </div>
                                                    <span class="item-status">{{ $comment['time'] }}</span>
                                                </div>
                                                <div class="item-body">
                                                    {{ $comment['body'] }}
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END PORTLET -->
                </div>
            </div>
        </div>

        <!-- END PROFILE CONTENT -->
    </div>
</div>
<!-- END PAGE CONTENT-->
@endsection