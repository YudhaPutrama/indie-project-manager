@extends('layouts.app')

@section('css-depends')
    @include('components.css.core')
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="/vendor/jquery-file-upload/blueimp-gallery/blueimp-gallery.min.css" rel="stylesheet"/>
    <link href="/vendor/jquery-file-upload/css/jquery.fileupload.css" rel="stylesheet"/>
    <link href="/vendor/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet"/>
    <!-- END PAGE LEVEL STYLES -->
    <script src="/js/metronic.js" type="text/javascript"></script>
    <script src="/js/layout.js" type="text/javascript"></script>
    <script src="/js/pages/index.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="/vendor/bootstrap-fileinput/bootstrap-fileinput.css"/>
    <!-- END PAGE LEVEL STYLES -->
@endsection

@section('js-depends')
    @include('components.js.core')
    <!-- BEGIN PAGE LEVEL PLUGINS -->

    <!-- END:File Upload Plugin JS files-->
    <script type="text/javascript" src="/vendor/bootstrap-fileinput/bootstrap-fileinput.js"></script>

    <!-- END PAGE LEVEL PLUGINS -->

    <script>
        jQuery(document).ready(function() {
            Metronic.init(); // init metronic core componets
            Layout.init(); // init layout
            Index.init();
            // initiate layout and plugins
//            Layout.init(); // init current layout
            $("form#newPhoto").submit(function() {
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
                            toastr['success']("Post successfully created", "Add Post");
                        } else {
                            if (data.detail!=null)
                                toastr['error'](data.detail, "Add Post");
                            else
                                toastr['error']("Something error", "Add Post")
                        }
                        console.log(data);
                    },
                    error: function (data) {
                        toastr['error']("Can't connect to server", "Add Post");
                        Metronic.unblockUI(_this);
                    },
                    complete: function(){
                        Metronic.unblockUI(_this);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
                return false;
            });
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
            <a href="{{ url('/projects') }}">Project</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="{{ route('project-detail',['project'=>$project]) }}">Detail</a>
        </li>
    </ul>
</div>
<h3 class="page-title">
    Upload Project Photos <small>just drop it</small>
</h3>
<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <form role="form" method="post" id="newPhoto" class="form-horizontal">
            <input type="hidden" name="action" value="post">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption"><i class="icon-speech"></i>New Photo</div>
                    <div class="actions inline"></div>
                </div>

                <div class="portlet-body">
                <!-- BEGIN FORM-->
                <div class="form-body">
                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button>
                        You have some form errors. Please check below.
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Title <span class="required">* </span></label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <i class="fa"></i>
                                <input type="text" class="form-control" name="title" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Location <span class="required">* </span></label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <i class="fa"></i>
                                <input type="text" class="form-control" name="location" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Photo <span class="required">* </span></label>
                        <div class="col-md-8">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
                                <div>
                                    <span class="btn default btn-file">
                                        <span class="fileinput-new">Select image </span>
                                        <span class="fileinput-exists">Change </span>
                                        <input type="file" name="image" required>
                                    </span>
                                    <a href="#" class="btn red fileinput-exists" data-dismiss="fileinput">Remove </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END FORM-->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn green">Create</button>
            </div>
        </form>
    </div>
</div>
<!-- END PAGE CONTENT-->
@endsection