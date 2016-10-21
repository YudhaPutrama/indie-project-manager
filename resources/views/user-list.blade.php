@extends('layouts.app')

@section('css-depends')
    @include('components.css.core')
    @include('components.css.dashboard')
@endsection

@section('js-depends')
    @include('components.js.core')
    <script src="/vendor/flot/jquery.flot.min.js" type="text/javascript"></script>
    <script src="/vendor/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
    <script src="/vendor/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
    <script src="/vendor/jquery.pulsate.min.js" type="text/javascript"></script>
    <script src="/vendor/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>

    <script src="/vendor/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
    <script src="/vendor/jquery.sparkline.min.js" type="text/javascript"></script>

    <script src="/js/metronic.js" type="text/javascript"></script>
    <script src="/js/layout.js" type="text/javascript"></script>
    <script src="/js/pages/index.js" type="text/javascript"></script>

    <script>
        jQuery(document).ready(function() {
            Metronic.init(); // init metronic core componets
            Layout.init(); // init layout
            Index.init();
            Index.initCalendar(); // init index page's custom scripts
            Index.initCharts(); // init index page's custom scripts
            Index.initChat();
            Index.initMiniCharts();

            $("form#addMember").submit(function() {

                var formData = new FormData($(this)[0]);

                $.ajax({
                    url: window.location.pathname,
                    type: 'POST',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    success: function (data) {
                        if (data.status=='success'){
                            toastr['success']("Success add user", "Add User");
                            window.location.reload();
                        } else {
                            toastr['error'](data.error, "Add User")
                        }
                        console.log(data);
                    },
                    error: function (data) {
                        toastr['error']("Can't connect to server", "Add User")
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
                return false;
            });

            var input = $("#username_input");
            $("#username_checker").click(function (e) {
                $.post("{{ route('checkUsername') }}")
                        .success(function (data) {
                            if (data.status=='success'){
                                toastr['success']("Username Available", "User Check");
                            } else {
                                toastr['error']("Something error", "User Check")
                            }
                            console.log(data);
                        })
                        .error(function (data) {
                            toastr['error']("Can't connect to server", "User check")
                        });

                e.preventDefault();
            });
            $("a#new-user-btn").click(function (e) {
                //alert("tes");
                var role = $(this).data("role");
                //alert(role);
                $('input[name="role"]').val(role);
            });
            $("button#remove-user").click(function (e) {
                var url = $(this).data('url');
                $.post(url, function (data) {
                    if (data.status=='success'){
                        toastr['success']("User Removed", "User Remove");
                        $(this).closest('.user-item').remove();
                    } else {
                        toastr['error']("Something error", "User Remove")
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

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
    <div class="modal fade event" id="new-user" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form role="form" method="post" id="addMember" class="form-horizontal">
                    <input name="role" value="" required id="role" type="hidden">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Add Member</h4>
                    </div>
                    <div class="modal-body">
                        <!-- BEGIN FORM-->
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">Email <span class="required">* </span></label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <input type="email" class="form-control" name="email" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Username <span class="required">* </span></label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <input type="text" class="form-control" name="username" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Password<span class="required">* </span></label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <input type="password" class="form-control" name="password" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Fullname<span class="required">* </span></label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <input type="text" class="form-control" name="fullname" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Institution<span class="required">* </span></label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <input type="text" class="form-control" name="institution" required/>
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
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{ url('/dashboard') }}">Dashboard</a>
            </li>
        </ul>
    </div>

    <h3 class="page-title">
        Project Members <small></small>
    </h3>
    <div class="row">
        <div class="col-md-12">
            @if(session('message'))
                <div class="note note-success">
                    <h4 class="block">Message</h4>
                    <p>{{ session('message') }}</p>
                </div>
            @endif
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-users"></i>Users
                    </div>
                    <div class="actions">
                        <a href="#new-user" data-role="admin" data-toggle="modal" role="button" class="btn btn-circle btn-default" id="new-user-btn">
                            <i class="fa fa-user"></i> New Admin </a>
                        <a href="#new-user" data-role="staff" data-toggle="modal" role="button" class="btn btn-circle btn-default" id="new-user-btn">
                            <i class="fa fa-user"></i> New Staff </a>
                        <a href="#new-user" data-role="client" data-toggle="modal" role="button" class="btn btn-circle btn-default" id="new-user-btn">
                            <i class="fa fa-user"></i> New Client </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-advance table-hover">
                            <thead>
                            <tr>
                                <th>
                                    <i class="fa fa-user"></i> Username
                                </th>
                                <th>
                                    <i class="fa fa-user"></i> Name
                                </th>
                                <th class="hidden-xs">
                                    <i class="fa fa-building"></i> Organization
                                </th>
                                <th>
                                    <i class="fa fa-bookmark"></i> Project
                                </th>
                                <th>
                                    <i class="fa fa-bookmark"></i> Action
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)

                                <tr class="user-item">
                                    <td>
                                        {{ $user['username'] }}
                                    </td>
                                    <td>
                                        {{ $user['fullname'] }}
                                    </td>
                                    <td class="hidden-xs">
                                        {{ $user['institution'] }}
                                    </td>
                                    <td>
                                        <div class="btn-group-vertical">
                                            @foreach($user['projects'] as $project)
                                                <a href="{{ route('project-detail',['project'=>$project]) }}" class="btn default btn-sm">
                                                    <i class="fa fa-briefcase icon-black"></i> {{ $project['name'] }} </a>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>
                                        @can('update', $user)
                                            @if($user['id']!=Auth::user()->id)<button type="button" data-url="{{ Request::url().'/'.$user['id'].'/remove' }}" data-user-id="{{ $user['id'] }}" class="btn default btn-xs green-stripe" id="remove-user">Remove User </button>@endif
                                            {{--<a href="#" class="btn default btn-xs green-stripe">Edit User </a>--}}
                                            <a href="{{ route('view-user',['user'=>$user]) }}" class="btn default btn-xs green-stripe">View User </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection