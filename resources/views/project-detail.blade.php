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
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <li>
                <a href="{{ url('/profile') }}">
                    <i class="icon-user"></i>
                    <span class="title">Profile</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/projects') }}">
                    <i class="icon-briefcase"></i>
                    <span class="title">Projects</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/schedule') }}">
                    <i class="icon-calendar"></i>
                    <span class="title">Schedule</span>
                </a>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
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
        Project Detail<small></small>
    </h3>
    <!-- END PAGE HEADER-->
    <div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>Overview
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-2">
                        <img class="project-picture" src="{{ ($project['project_picture'].isEmptyOrNullString())?'/img/project-holder.jpg':'/img/projects/pictures/'.$project['project_picture'] }}" class="img-responsive" alt="">
                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 style="margin-top: 0px;">{{ $project['title'] }}</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <p>
                                    <span class="label label-primary">
                                        <i class="fa fa-file-photo-o"></i> {{ $countAll = $project['photos']->count() }}
                                    </span>
                                            <span class="label label-success">
                                        <i class="fa fa-check"></i> {{ $countDone = $project['photos']->where('status','done')->count() }}
                                    </span>
                                            <span class="label label-warning">
                                        <i class="fa fa-times"></i> {{ ($countAll-$countDone) }}
                                    </span>
                                </p>
                                <div class="note note-warning">
                                    <p>
                                        Progress bars
                                    </p>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{ $countDone }}" aria-valuemin="0" aria-valuemax="{{ $countAll }}" style="width: {{ $progressDone = $countDone/(($countAll>0)?$countAll:1)*100 }}%">
                                <span class="sr-only">
                                    40% Complete (success)
                                </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h4>Shared</h4>
                                <ul class="list-inline">
                                    @foreach($project['members'] as $member)
                                        <li class="tooltips" data-container="body" data-placement="bottom" data-original-title="{{ $member['fullname'] }}">
                                            <span class="photo">
                                                <img  src="{{ "/uploads/avatar/".$member['avatar'] }}" class="img-circle" style="width: 45px; height: 45px;">
                                            </span>
                                        </li>
                                        @if($loop->count == 4)
                                            <li class="tooltips" data-container="body" data-placement="bottom" data-original-title="Others">
                                            <span class="photo">
                                                <img  src="/img/avatar.png" class="img-circle" style="width: 45px; height: 45px;">
                                            </span>
                                            </li>
                                            @break
                                        @endif

                                    @endforeach
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p>{{ $project['description'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <!-- BEGIN PORTLET-->
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i>Schedule
                    </div>
                    <div class="actions">
                        <a href="#" class="btn btn-circle red-sunglo ">
                            <i class="fa fa-plus"></i> Add </a>
                        <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="#" data-original-title="" title="">
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-advance table-hover">
                            <thead>
                            <tr>
                                <th><i class="fa fa-briefcase"></i> Date</th>
                                <th class="hidden-xs"><i class="fa fa-user"></i> Time</th>
                                <th><i class="fa fa-calendar-o"></i> Event</th>
                                <th><i class="fa fa-location"></i> Location</th>
                                <th><i class="fa fa-tag"></i> Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($project['schedule'] as $event)
                                {{$start = new \Carbon\Carbon($event['start'])}}
                                <tr>
                                    <td class="highlight">{{ $start->toDateString() }}</td>
                                    <td class="hidden-xs">{{ $start->toTimeString() }}</td>
                                    <td>{{ $event['$event'] }}</td>
                                    <td>{{ $event['location'] }}</td>
                                    @if($event['status']=='done')
                                        <td>Complete</td>
                                    @elseif($event['status']=='pending')
                                        <td>Pending</td>
                                    @else
                                        <td>On Going</td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{--<ul class="pagination bootpag"><li data-lp="1" class="prev disabled"><a href="javascript:void(0);"><i class="fa fa-angle-left"></i></a></li><li data-lp="1" class="disabled"><a href="javascript:void(0);">1</a></li><li data-lp="2"><a href="javascript:void(0);">2</a></li><li data-lp="3"><a href="javascript:void(0);">3</a></li><li data-lp="4"><a href="javascript:void(0);">4</a></li><li data-lp="5"><a href="javascript:void(0);">5</a></li><li data-lp="6"><a href="javascript:void(0);">6</a></li><li data-lp="2" class="next"><a href="javascript:void(0);"><i class="fa fa-angle-right"></i></a></li></ul>--}}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <!-- BEGIN PORTLET-->
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i>Photo List
                    </div>
                    <div class="actions">
                        <a href="{{ Request::url().'/upload' }}" class="btn btn-circle red-sunglo ">
                            <i class="fa fa-plus"></i> Add </a>
                        <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="#" data-original-title="" title="">
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="scroller" data-always-visible="1" data-rail-visible="0">
                        <ul class="feeds">
                            @foreach($project['photos'] as $photo)
                            <li>
                                <a href="{{ Request::url().'/'.$photo['id'] }}">
                                    <div class="col1">
                                        <div class="cont">
                                            <div class="cont-col1">
                                                @if($photo['status']=="done")
                                                    <div class="label label-sm label-success">
                                                        <i class="fa fa-check"></i>
                                                    </div>
                                                @elseif($photo['status']=="reviewed")
                                                    <div class="label label-sm label-info">
                                                        <i class="fa fa-pencil"></i>
                                                    </div>
                                                @elseif($photo['status']=="uploaded")
                                                    <div class="label label-sm label-info">
                                                        <i class="fa fa-arrow-up"></i>
                                                    </div>
                                                @else
                                                    <div class="label label-sm label-danger">
                                                        <i class="fa fa-times"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc">
                                                    {{ $photo['title'] }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date">
                                            <i class="fa fa-share">{{-- $photo['updated_at'] --}}</i>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row hide">
        <div class="col-md-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i>Photo
                    </div>
                </div>
                <div class="portlet-body">

                </div>
            </div>
        </div>
    </div>
    <div class="row hide">
        <div class="col-md-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-comments"></i>Chats
                    </div>
                </div>
                <div class="portlet-body" id="chats">
                    <div class="scroller" style="height: 352px;" data-always-visible="1" data-rail-visible1="1">
                        <ul class="chats">
                            <li class="in">
                                <img class="avatar" alt="" src="/img/avatar1.jpg"/>
                                <div class="message">
											<span class="arrow">
											</span>
                                    <a href="#" class="name">
                                        Bob Nilson </a>
                                    <span class="datetime">
											at 20:09 </span>
                                    <span class="body">
											Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                </div>
                            </li>
                            <li class="out">
                                <img class="avatar" alt="" src="/img/avatar2.jpg"/>
                                <div class="message">
											<span class="arrow">
											</span>
                                    <a href="#" class="name">
                                        Lisa Wong </a>
                                    <span class="datetime">
											at 20:11 </span>
                                    <span class="body">
											Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                </div>
                            </li>
                            <li class="in">
                                <img class="avatar" alt="" src="/img/avatar1.jpg"/>
                                <div class="message">
											<span class="arrow">
											</span>
                                    <a href="#" class="name">
                                        Bob Nilson </a>
                                    <span class="datetime">
											at 20:30 </span>
                                    <span class="body">
											Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                </div>
                            </li>
                            <li class="out">
                                <img class="avatar" alt="" src="/img/avatar3.jpg"/>
                                <div class="message">
											<span class="arrow">
											</span>
                                    <a href="#" class="name">
                                        Richard Doe </a>
                                    <span class="datetime">
											at 20:33 </span>
                                    <span class="body">
											Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                </div>
                            </li>
                            <li class="in">
                                <img class="avatar" alt="" src="/img/avatar3.jpg"/>
                                <div class="message">
											<span class="arrow">
											</span>
                                    <a href="#" class="name">
                                        Richard Doe </a>
                                    <span class="datetime">
											at 20:35 </span>
                                    <span class="body">
											Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                </div>
                            </li>
                            <li class="out">
                                <img class="avatar" alt="" src="/img/avatar1.jpg"/>
                                <div class="message">
											<span class="arrow">
											</span>
                                    <a href="#" class="name">
                                        Bob Nilson </a>
                                    <span class="datetime">
											at 20:40 </span>
                                    <span class="body">
											Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                </div>
                            </li>
                            <li class="in">
                                <img class="avatar" alt="" src="/img/avatar3.jpg"/>
                                <div class="message">
											<span class="arrow">
											</span>
                                    <a href="#" class="name">
                                        Richard Doe </a>
                                    <span class="datetime">
											at 20:40 </span>
                                    <span class="body">
											Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                </div>
                            </li>
                            <li class="out">
                                <img class="avatar" alt="" src="/img/avatar1.jpg"/>
                                <div class="message">
											<span class="arrow">
											</span>
                                    <a href="#" class="name">
                                        Bob Nilson </a>
                                    <span class="datetime">
											at 20:54 </span>
                                    <span class="body">
											Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. sed diam nonummy nibh euismod tincidunt ut laoreet. </span>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="chat-form">
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection