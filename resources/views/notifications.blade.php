@extends('layouts.app')

@section('css-depends')
    @include('components.css.core')
    @include('components.css.dashboard')
@endsection

@section('js-depends')
    @include('components.js.core')
    @include('components.js.dashboard')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
    <h3 class="page-title">
        Notifications <small></small>
    </h3>
    <div class="row">
        <div class="col-sm-12">
            <div class="dashboard-stat blue-madison">
                <div class="visual">
                    <i class="fa fa-comments"></i>
                </div>
                <div class="details">
                    <div class="number">
                        {{ \App\Comment::all()->count() }}
                    </div>
                    <div class="desc">
                        Comments
                    </div>
                </div>
                {{--<a class="more" href="#">--}}
                {{--View more <i class="m-icon-swapright m-icon-white"></i>--}}
                {{--</a>--}}
            </div>
        </div>
    </div>
    <div class="clearfix">
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="portlet box blue-steel">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-bell-o"></i>Recent Comments
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="scroller" style="height: 300px;" data-always-visible="1" data-rail-visible="0">
                        <ul class="feeds">
                            @foreach(Auth::user()->notifications as $notification)
                                <li>
                                    <div class="col1">
                                        <div class="cont">
                                            <div class="cont-col1">
                                                <div class="label label-sm label-info">
                                                    <i class="fa fa-check"></i>
                                                </div>
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc">
                                                    {{ $notification['data'] }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        Just now
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    {{--<div class="scroller-footer">--}}
                    {{--<div class="btn-arrow-link pull-right">--}}
                    {{--<a href="#">See All Records</a>--}}
                    {{--<i class="icon-arrow-right"></i>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>
    </div>
@endsection