@extends('layouts.app')

@section('css-depends')
    @include('components.css.core')
    @include('components.css.dashboard')
    <link rel="stylesheet" type="text/css" href="/vendor/select2/select2.css"/>
    <link rel="stylesheet" type="text/css" href="/vendor/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
    <link rel="stylesheet" type="text/css" href="/vendor/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css"/>
    <link rel="stylesheet" type="text/css" href="/vendor/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>

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

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script type="text/javascript" src="/vendor/select2/select2.min.js"></script>
    <script type="text/javascript" src="/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/vendor/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
    <script type="text/javascript" src="/vendor/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>
    <script type="text/javascript" src="/vendor/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
    <script type="text/javascript" src="/vendor/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="/js/pages/table-advanced.js"></script>

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
                var _this = $(this);
                Metronic.blockUI({
                    target: _this,
                    animate: true
                });
                $.ajax({
                    url: window.location.pathname,
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (data) {
                        if (data.status=='success'){
                            toastr['success']("Project successfully created", "Add Member");
                            window.location.reload();
                        } else {
                            toastr['error'](data.error, "Add Member")
                        }
                        console.log(data);
                    },
                    error: function (data) {
                        toastr['error']("Can't connect to server", "Add Member")
                    },
                    complete: function (data) {
                        Metronic.unblockUI(_this)
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
                return false;
            });

            $("form#fromList").submit(function() {

                var formData = new FormData($(this)[0]);
                var _this = $(this);
                Metronic.blockUI({
                    target: _this,
                    animate: true
                });
                $.ajax({
                    url: window.location.pathname,
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (data) {
                        if (data.status=='success'){
                            toastr['success']("User successful added", "Add Member");
                            window.location.reload();
                        } else {
                            toastr['error'](data.error, "Add Member")
                        }
                        console.log(data);
                    },
                    error: function (data) {
                        toastr['error']("Can't connect to server", "Add Member")
                    },
                    complete: function (data) {
                        Metronic.unblockUI(_this)
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
    <div class="modal fade event" id="new-member" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form role="form" method="post" id="addMember" class="form-horizontal">
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
                                <label class="control-label col-md-3">Username</label>
                                <div class="col-md-8">
                                    <div class="input-group" style="text-align:left">
                                        <input type="text" class="form-control" name="username" id="username_input">
                                        <span class="input-group-btn">
                                            <a href="#" class="btn green" id="username_checker">
                                                <i class="fa fa-check"></i> Check </a>
                                        </span>
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
    <div class="modal fade event" id="from-list" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form role="form" method="post" id="fromList" class="form-horizontal">
                    <input name="fromId" value="1" type="hidden">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Add Member</h4>
                    </div>
                    <div class="modal-body">
                        <!-- BEGIN FORM-->
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">Username</label>
                                <div class="col-md-8">
                                    <div class="input-group" style="text-align:left">
                                        <input type="text" class="form-control" name="username" id="username_input">
                                        <span class="input-group-btn">
                                            <a href="#" class="btn green" id="username_checker">
                                                <i class="fa fa-check"></i> Check </a>
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
                    {{--<h4 class="block">Message</h4>--}}
                    <p>{{ session('message') }}</p>
                </div>
            @endif
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                            <i class="fa fa-users"></i>Members
                    </div>
                    <div class="actions">
                        <a href="#new-member" data-toggle="modal" role="button" class="btn btn-circle btn-default">
                            <i class="fa fa-users"></i> Add New Client </a>
                        <a href="#from-list" data-toggle="modal" role="button" class="btn btn-circle btn-default">
                            <i class="fa fa-users"></i> Add From List </a>
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
                                    <i class="fa fa-bookmark"></i> Phone
                                </th>
                                <th>
                                    <i class="fa fa-bookmark"></i> Action
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($members as $member)

                            <tr>
                                <td>
                                    {{ $member['username'] }}
                                </td>
                                <td>
                                    {{ $member['fullname'] }}
                                </td>
                                <td class="hidden-xs">
                                    {{ $member['organization'] }}
                                </td>
                                <td>
                                    {{ $member['phone'] }}
                                </td>
                                <td>
                                    @can('update', $member)
                                    @if($member['id']!=Auth::user()->id)<a href="{{ Request::url().'/'.$member['id'].'/remove' }}" class="btn default btn-xs green-stripe">Remove User </a>@endif
                                    {{--<a href="#" class="btn default btn-xs green-stripe">Edit User </a>--}}
                                    <a href="{{ route('view-user',['user'=>$member]) }}" class="btn default btn-xs green-stripe">View User </a>
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