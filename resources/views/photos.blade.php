@extends('layouts.app')

@section('css-depends')
    @include('components.css.core')
    @include('components.css.dashboard')
    <link href="/vendor/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css">
@endsection

@section('js-depends')
    @include('components.js.core')
    <script src="/js/metronic.js" type="text/javascript"></script>
    <script src="/js/layout.js" type="text/javascript"></script>
    <script src="/js/pages/photos.js" type="text/javascript"></script>

    <script>
        jQuery(document).ready(function() {
            Metronic.init(); // init metronic core componets
            Layout.init(); // init layout
            Photos.initComments();
        });
    </script>
@endsection


@section('content')
    <!-- BEGIN PAGE HEADER-->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{ url('/home') }}">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#">Project</a>
            </li>
        </ul>
    </div>
    <h3 class="page-title">
        Photo Review<small></small>
    </h3>
    <!-- END PAGE HEADER-->
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-photo"></i>Photo
                    </div>

                    <div class="actions">
                        {{--<span href="{{ Request::url().'/upload' }}" class="btn btn-circle red-sunglo btn-file">--}}
                            {{--<i class="fa fa-plus"></i> Update <input type="file" name="avatar" accept="image/*" id="avatar"></span>--}}

                        <span class="btn btn-circle blue btn-file">
                            <span>Change </span>
                            <input type="file" name="avatar" accept="image/*" id="avatar">
                        </span>
                        <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="#" data-original-title="" title="">
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <img src="{{ Config::get('image.dir.projects.photos').$photo['url'] }}" class="img-responsive">
                    <blockquote class="hero">
                        <p>
                            {{ $photo['title'] }}
                        </p>
                        <small>{{ $photo['location'] }}</small>
                    </blockquote>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-comments"></i>Comments
                    </div>
                </div>
                <div class="portlet-body" id="chats">
                    <ul class="chats">
                        @foreach($comments as $comment)
                            @if($comment['user']->id == Auth::user()->id)
                                <li class="out">
                            @else
                                <li class="in">
                            @endif
                            <img class="avatar" alt="" src="{{ Config::get('image.dir.avatar').$comment['user']->avatar }}"/>
                            <div class="message">
                                <span class="arrow"></span>
                                <a href="#" class="name"> {{ $comment['user']->fullname }} </a>
                                <span class="datetime"> at {{ (new Carbon\Carbon('2016-10-15 23:36:12'))->diffForHumans() }} </span>
                                <span class="body">
                                    {{ $comment['body'] }}
                                </span>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    <div class="chat-form">
                        <div class="input-cont">
                            <input class="form-control" type="text" placeholder="Type a message here..."/>
                        </div>
                        <div class="btn-cont">
									<span class="arrow">
									</span>
                            <a href="" class="btn blue icn-only">
                                <i class="fa fa-send icon-white"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection