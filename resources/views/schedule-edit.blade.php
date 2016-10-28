@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('css-depends')
    @include('components.css.core')
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="/vendor/fullcalendar/fullcalendar.min.css" rel="stylesheet"/>
    <!-- END PAGE LEVEL STYLES -->

@endsection

@section('js-depends')
    @include('components.js.core')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <!-- IMPORTANT! fullcalendar depends on jquery-ui.min.js for drag & drop support -->
    <script src="/vendor/moment.min.js"></script>
    <script src="/vendor/fullcalendar/fullcalendar.min.js"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="/js/metronic.js" type="text/javascript"></script>
    <script src="/js/layout.js" type="text/javascript"></script>
    <script src="/js/pages/calendar.js"></script>
    <script>
        jQuery(document).ready(function() {
            // initiate layout and plugins
            Calendar.init();
        });
    </script>
    <!-- END PAGE LEVEL SCRIPTS -->
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
                <a href="{{ url('/schedule') }}">Schedule</a>
            </li>
        </ul>
        {{--<div class="page-toolbar">--}}
            {{--<div class="btn-group pull-right">--}}
                {{--<a href="#request-schedule" type="button" class="btn btn-fit-height red">--}}
                    {{--Request Schedule--}}
                {{--</a>--}}
            {{--</div>--}}
        {{--</div>--}}
    </div>
    <h3 class="page-title">
        Calendar <small>calendar page</small>
    </h3>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light calendar" id="request-schedule">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i>Schedule
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="calendar" class="has-toolbar  schedule-request">
                            </div>
                        </div>
                    </div>
                    <!-- END CALENDAR PORTLET-->
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
@endsection