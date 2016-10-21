@extends('layouts.app')

@section('css-depends')
    @include('components.css.core')
    @include('components.css.dashboard')
    <link rel="stylesheet" type="text/css" href="/vendor/bootstrap-fileinput/bootstrap-fileinput.css"/>
    <link rel="stylesheet" type="text/css" href="/vendor/bootstrap-datepicker/css/datepicker.css"/>

@endsection

@section('js-depends')
    @include('components.js.core')
    @include('components.js.dashboard')
    <script type="text/javascript" src="/vendor/jquery-validation/js/jquery.validate.min.js"></script>
    <script src="/js/pages/form-validation.js"></script>
    <script type="text/javascript" src="/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="/vendor/bootstrap-fileinput/bootstrap-fileinput.js"></script>
    <script>
        jQuery(document).ready(function() {
            Metronic.init(); // init metronic core componets
//            Layout.init(); // init layout
//            Index.init();
//            Index.initCalendar(); // init index page's custom scripts
//            Index.initCharts(); // init index page's custom scripts
//            Index.initChat();
//            Index.initMiniCharts();
            //FormValidation.init();

            $('.date-picker').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });

            $("form#editProject").submit(function() {

                var formData = new FormData($(this)[0]);

                $.ajax({
                    url: window.location.pathname,
                    type: 'POST',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    success: function (data) {
                        if (data.status=='success'){
                            toastr['success']("Project successfully created", "Add Project");
                        } else {
                            toastr['error']("Something error", "Add Project")
                        }
                        console.log(data);
                    },
                    error: function (data) {
                        toastr['error']("Can't connect to server", "Add Project")
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
                return false;
            });

            $("form#addEvent").submit(function() {

                var formData = new FormData($(this)[0]);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    success: function (data) {
                        if (data.status=='success'){
                            toastr['success']("Project successfully created", "Add Project");
                            window.location.reload();
                        } else {
                            toastr['error']("Something error", "Add Project")
                        }
                        console.log(data);
                    },
                    error: function (data) {
                        toastr['error']("Can't connect to server", "Add Project")
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
                return false;
            });

            $("form#editEvent").submit(function() {

                var formData = new FormData($(this)[0]);

                $.ajax({
                    url: window.location.pathname+'/event',
                    type: 'POST',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    success: function (data) {
                        if (data.status=='success'){
                            toastr['success']("Project successfully created", "Add Project");
                        } else {
                            toastr['error']("Something error", "Add Project")
                        }
                        console.log(data);
                    },
                    error: function (data) {
                        toastr['error']("Can't connect to server", "Add Project")
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
                return false;
            });

            $(".action").click(function (e) {
                var id = $(this).data('event');
                $.post($(this).attr('href'))
                        .success(function (data) {
                            if (data.status=='success'){
                                toastr['success'](data.detail, "Action");
                                window.location.reload();
                            } else {
                                toastr['error']("Something error", "Action")
                            }
                            console.log(data);
                        });

                e.preventDefault();
            });

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

@section('content')
    <div class="modal fade project" id="edit-project" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form role="form" method="post" id="editProject" class="form-horizontal">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Edit Project</h4>
                    </div>
                    <div class="modal-body">
                        <!-- BEGIN FORM-->
                        <div class="form-body">
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button>
                                You have some form errors. Please check below.
                            </div>
                            <div class="alert alert-success display-hide">
                                <button class="close" data-close="alert"></button>
                                Your form validation is successful!
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Project Name <span class="required">* </span></label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <input type="text" class="form-control" name="name" value="{{ $project['name'] }}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Description<span class="required">* </span></label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <textarea class="form-control" rows="3" name="description">{{ $project['description'] }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Project Picture</label>
                                <div class="col-md-9">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
                                            <img src="{{ Config::get('image.dir.projects.picture').$project['picture'] }}" alt="">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
                                        </div>
                                        <div>
                                            <span class="btn default btn-file">
                                            <span class="fileinput-new">
                                            Select image </span>
                                            <span class="fileinput-exists">
                                            Change </span>
                                            <input type="file" name="picture">
                                            </span>
                                            <a href="#" class="btn red fileinput-exists" data-dismiss="fileinput">
                                                Remove </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Start</label>
                                <div class="col-md-8">
                                    <div class="input-group date date-picker" data-date-format="dd-mm-yyyy">
                                        <input type="text" class="form-control" readonly="" name="start" value="{{ $project['start'] }}">
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Deadline</label>
                                <div class="col-md-8">
                                    <div class="input-group date date-picker" data-date-format="dd-mm-yyyy">
                                        <input type="text" class="form-control" readonly="" name="deadline" value="{{ $project['deadline'] }}">
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END FORM-->
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn green">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade event" id="add-event" tabindex="-1" role="basic" aria-hidden="true" style="display: none;" >
        <div class="modal-dialog">
            <div class="modal-content">
                <form role="form" method="post" id="addEvent" class="form-horizontal" action="{{ route('postEvent',['project'=>$project['id']]) }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Add Event</h4>
                    </div>
                    <div class="modal-body">
                        <!-- BEGIN FORM-->
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">Event Name <span class="required">* </span></label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <input type="text" class="form-control" name="name" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Location<span class="required">* </span></label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <input type="text" class="form-control" name="location" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Start</label>
                                <div class="col-md-8">
                                    <div class="input-group date date-picker" data-date-format="dd-mm-yyyy">
                                        <input type="text" class="form-control" readonly="" name="start" required>
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Deadline</label>
                                <div class="col-md-8">
                                    <div class="input-group date date-picker" data-date-format="dd-mm-yyyy">
                                        <input type="text" class="form-control" readonly="" name="deadline" required>
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END FORM-->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn green">Create</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade event" id="edit-event" tabindex="-1" role="basic" aria-hidden="true" style="display: none;" >
        <div class="modal-dialog">
            <div class="modal-content">
                <form role="form" method="post" id="addEvent" class="form-horizontal" action="{{ route('postEvent',['project'=>$project['id']]) }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Add Event</h4>
                    </div>
                    <div class="modal-body">
                        <!-- BEGIN FORM-->
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">Event Name <span class="required">* </span></label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <input type="text" class="form-control" name="name" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Location<span class="required">* </span></label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <input type="text" class="form-control" name="location" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Start</label>
                                <div class="col-md-8">
                                    <div class="input-group date date-picker" data-date-format="dd-mm-yyyy">
                                        <input type="text" class="form-control" readonly="" name="start" required>
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Deadline</label>
                                <div class="col-md-8">
                                    <div class="input-group date date-picker" data-date-format="dd-mm-yyyy">
                                        <input type="text" class="form-control" readonly="" name="deadline" required>
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END FORM-->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn green">Create</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
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
    @if($project!=null)
    <div class="row">
    <div class="col-md-12">
        @if(session('message'))
        <div class="note note-success">
            <h4 class="block">Message</h4>
            <p>{{ session('message') }}</p>
        </div>
        @endif
        <!-- BEGIN PORTLET-->
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>Overview
                </div>
                @can('update', $project)
                <div class="actions">

                    <a href="{{ Request::url().'/members' }}" class="btn btn-circle btn-default">
                        <i class="fa fa-users"></i> Members </a>

                    <a href="#edit-project" data-toggle="modal" role="button" class="btn btn-circle btn-default">
                        <i class="fa fa-pencil"></i> Edit Project </a>
                </div>
                @endcan
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-2">
                        <img class="project-picture img-responsive" src="{{ Config::get('image.dir.projects.picture').$project['picture'] }}" class="img-responsive" alt="">
                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 style="margin-top: 0px;">{{ $project['name'] }}</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <p>
                                    <span class="label label-primary tooltips" data-container="body" data-placement="bottom" data-original-title="Total Photos">
                                        <i class="fa fa-file-photo-o"></i> {{ $countAll = $project['photos']->count() }}
                                    </span>
                                    <span class="label label-success tooltips" data-container="body" data-placement="bottom" data-original-title="Complete Photos">
                                        <i class="fa fa-check"></i> {{ $countDone = $project['photos']->where('status','done')->count() }}
                                    </span>
                                    <span class="label label-warning tooltips"  data-container="body" data-placement="bottom" data-original-title="Incomplete Photos">
                                        <i class="fa fa-times"></i> {{ ($countAll-$countDone) }}
                                    </span>
                                </p>

                                <div class="progress">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{ $countDone }}" aria-valuemin="0" aria-valuemax="{{ $countAll }}" style="width: {{ $progressDone = $countDone/(($countAll>0)?$countAll:1)*100 }}%">
                                        <span class="sr-only">

                                        </span>
                                    </div>
                                </div>
                                <div class="note note-warning">
                                    <p>
                                        {{ $project['description'] }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h4>Shared</h4>
                                <ul class="list-inline">
                                    @foreach($project['members'] as $member)
                                        <li class="tooltips" data-container="body" data-placement="bottom" data-original-title="{{ $member['fullname'] }}">
                                            <span class="photo">
                                                <img  src="{{ "/uploads/avatar/".(($member['avatar']!=null)?$member['avatar']:"default.jpg") }}" class="img-circle" style="width: 45px; height: 45px;">
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
                        <a href="#add-event" class="btn btn-circle red-sunglo " data-toggle="modal"><i class="fa fa-plus"></i> Add </a>
                        <a href="{{ Request::url()."/calendar" }}" class="btn btn-circle blue "><i class="fa fa-calendar"></i> Calendar </a>
                        <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="#" data-original-title="" title="">
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-advance table-hover">
                            <thead>
                            <tr>
                                <th><i class="fa fa-briefcase"></i> Start Date</th>
                                <th class="hidden-xs"></i> Deadline</th>
                                <th><i class="fa fa-calendar-o"></i> Event</th>
                                <th><i class="fa fa-location"></i> Location</th>
                                <th><i class="fa fa-tag"></i> Status</th>
                                @can('update', $project)
                                    <th><i class="fa fa-pencil"></i> Action</th>
                                @endcan
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($project['schedule']->sortBy('start') as $event)
                                <tr class="event-item" id="{{ $event['id'] }}">
                                    <td class="highlight">{{ (new \Carbon\Carbon($event['start']))->toDateString() }}</td>
                                    <td class="hidden-xs">{{ (new \Carbon\Carbon($event['deadline']))->toDateString() }}</td>
                                    <td>{{ $event['event'] }}</td>
                                    <td>{{ $event['location'] }}</td>
                                    @if($event['status']=='done')
                                        <td>Complete</td>
                                    @elseif($event['status']=='pending')
                                        <td>Pending</td>
                                    @else
                                        <td>On Going</td>
                                    @endif
                                    @can('update', $project)
                                        <th>
                                            @if($event['status']=='pending')<a href="{{ Request::url().'/event/'.$event['id'].'/approve' }}" class="btn default btn-xs green action"><i class="fa fa-check"></i> Approve </a>
                                            @elseif($event['status']=='ongoing')<a href="{{ Request::url().'/event/'.$event['id'].'/done' }}" class="btn default btn-xs blue action"><i class="fa fa-check"></i> Done </a>
                                            @endif
                                            <a href="{{ Request::url().'/event/'.$event['id'].'/edit' }}" class="btn default btn-xs purple action"><i class="fa fa-edit"></i></a>
                                            <a href="{{ Request::url().'/event/'.$event['id'].'/remove' }}" class="btn default btn-xs red action" data-event="{{ $event['id'] }}"><i class="fa fa-trash-o"></i></a>
                                        </th>
                                    @endcan
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
                        @can('create', Photo::class)
                        <a href="{{ Request::url().'/upload' }}" class="btn btn-circle red-sunglo ">
                            <i class="fa fa-plus"></i> Add </a>
                        @endcan
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
    @endif
@endsection