@extends('layouts.app')

@section('css-depends')
    @include('components.css.core')
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="/vendor/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
    <link href="/css/pages/profile.css" rel="stylesheet" type="text/css"/>
    <!-- END PAGE LEVEL STYLES -->
@endsection

@section('js-depends')
    @include('components.js.core')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="/vendor/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->

    <script>
        jQuery(document).ready(function() {

            toastr.options = {
                "closeButton": true,
                "debug": true,
                "positionClass": "toast-bottom-right",
                "showDuration": "1000",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
        });
    </script>
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
            <a href="{{ url('/users') }}">Users</a>
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
                    <img src="{{ "/uploads/avatar/".(($user['avatar']!=null)?$user['avatar']->avatar:"default.jpg") }}" class="img-responsive" alt="">
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
                    @if(Auth::user()->isAdmin())<a class="btn btn-circle btn-danger btn-sm">DELETE</a>@endif
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
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light">
                        <div class="portlet-title tabbable-line">
                            <div class="caption caption-md">
                                <i class="icon-globe theme-font hide"></i>
                                <span class="caption-subject font-blue-madison bold uppercase">Profile Account</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="form-group">
                                <label class="control-label">Fullname</label>
                                <input type="text" name="fullname" placeholder="John Doe" class="form-control" value="{{ $user['fullname'] }}" disabled/>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Nickname</label>
                                <input type="text" name="nickname" placeholder="Doe" class="form-control" value="{{ $user['nickname'] }}" disabled/>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Phone Number</label>
                                <input type="text" name="phone" placeholder="+628511111111 " class="form-control" value="{{ $user['phone'] }}" disabled/>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Title</label>
                                <input type="text" name="title" placeholder="Leader" class="form-control" value="{{ $user['title'] }}" disabled/>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Institution</label>
                                <input type="text" name="institution" placeholder="Google" class="form-control" value="{{ $user['institution'] }}" disabled/>
                            </div>
                            <div class="form-group">
                                <label class="control-label">About</label>
                                <textarea name="bio" class="form-control" rows="3" placeholder="About you" disabled>{{ $user['bio'] }}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Facebook URL</label>
                                <input type="text" name="facebook" placeholder="https://www.facebook.com/user" class="form-control" value="{{ $user['facebook'] }}" disabled/>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Twitter URL</label>
                                <input type="text" name="twitter" placeholder="https://www.twitter.com/user" class="form-control" value="{{ $user['twitter'] }}" disabled/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PROFILE CONTENT -->
    </div>
</div>
<!-- END PAGE CONTENT-->
@endsection