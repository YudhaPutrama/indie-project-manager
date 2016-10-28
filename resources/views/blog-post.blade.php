@extends('layouts.app')
@section('css-depends')
    @include('components.css.core')
    @include('components.css.dashboard')
    <link rel="stylesheet" type="text/css" href="/vendor/bootstrap-fileinput/bootstrap-fileinput.css"/>
    <link rel="stylesheet" type="text/css" href="/vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"/>
    <link rel="stylesheet" type="text/css" href="/vendor/bootstrap-datepicker/css/datepicker.css"/>
@endsection

@section('js-depends')
    @include('components.js.core')
    <script src="/vendor/flot/jquery.flot.min.js" type="text/javascript"></script>
    <script src="/vendor/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
    <script src="/vendor/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
    <script src="/vendor/jquery.pulsate.min.js" type="text/javascript"></script>

    <script src="/js/metronic.js" type="text/javascript"></script>
    <script src="/js/layout.js" type="text/javascript"></script>
    <script src="/js/pages/index.js" type="text/javascript"></script>
    <script type="text/javascript" src="/vendor/jquery-validation/js/jquery.validate.min.js"></script>
    <script src="/js/pages/form-validation.js"></script>
    <script type="text/javascript" src="/vendor/jquery-validation/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/vendor/jquery-validation/js/additional-methods.min.js"></script>
    <script type="text/javascript" src="/vendor/select2/select2.min.js"></script>
    <script type="text/javascript" src="/vendor/bootstrap-markdown/js/bootstrap-markdown.js"></script>

    <script type="text/javascript" src="/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="/vendor/bootstrap-fileinput/bootstrap-fileinput.js"></script>

    <script>
        jQuery(document).ready(function() {
            Metronic.init(); // init metronic core componets
            Layout.init(); // init layout
            Index.init();
            Index.initCalendar(); // init index page's custom scripts
            Index.initCharts(); // init index page's custom scripts
            Index.initChat();
            Index.initMiniCharts();
            FormValidation.init();

            $("form#editPost").submit(function() {

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
                            toastr['success']("Post updated", "Update Project");
                            window.location.reload();
                        } else {
                            toastr['error']("Something error", "Update Project")
                        }
//                        console.log(data);

                    },
                    error: function (data) {
                        toastr['error']("Can't connect to server", "Update Project")
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
    @can('update', $post)
        <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <div class="modal fade" id="editPost" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" method="post" id="editPost" class="form-horizontal">
                        <input type="hidden" name="action" value="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Edit Post</h4>
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
                                    <label class="control-label col-md-3">Title <span class="required">* </span></label>
                                    <div class="col-md-8">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input type="text" class="form-control" name="title" value="{{ $post['title'] }}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Summary<span class="required">* </span></label>
                                    <div class="col-md-8">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <textarea class="form-control" rows="2" name="summary">{{ $post['summary'] }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Content<span class="required">* </span></label>
                                    <div class="col-md-8">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <textarea class="form-control" rows="4" name="body">{{ $post['body'] }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Post Picture</label>
                                    <div class="col-md-9">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
                                            <div>
                                            <span class="btn default btn-file">
                                            <span class="fileinput-new">
                                            Select image </span>
                                            <span class="fileinput-exists">
                                            Change </span>
                                            <input type="file" name="image">
                                            </span>
                                                <a href="#" class="btn red fileinput-exists" data-dismiss="fileinput">
                                                    Remove </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- END FORM-->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn green">Update</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    @endcan
        <!-- BEGIN PAGE HEADER-->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="/">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="{{ route('blogs') }}">Blog</a>

                </li>

            </ul>
            <div class="page-toolbar">
                <div class="btn-group pull-right">
                    <a href="#editPost" class="btn green" data-toggle="modal">
                        Edit <i class="icon-pencil"></i>
                    </a>
                    <a href="{{ route('removePost',['post'=>$post]) }}" class="btn red" id="delete">
                        Remove <i class="icon-trash"></i>
                    </a>
                </div>
            </div>
        </div>
        <h3 class="page-title">
            Blog Post <small></small>
        </h3>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-12 blog-page">
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN Portlet PORTLET-->
                        <div class="portlet light">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="icon-speech"></i>
                                    <span class="caption-subject bold uppercase"> {{ $post['title'] }}</span>
                                    {{--<span class="caption-helper">subtitle</span>--}}
                                </div>
                                <div class="actions inline">
                                    <a class="btn btn-circle btn-default"><i class="fa fa-calendar"></i> {{ (new \Carbon\Carbon($post['created_at']))->diffForHumans() }} </a>

                                    <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="#" data-original-title="" title=""></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                @if(isset($post['image']))<img src="{{ Config::get('image.dir.post').$post['image'] }}" alt="" class="img-responsive">@endif
                                    <blockquote>
                                        <p>
                                            {{ $post['summary'] }}
                                        </p>
                                    </blockquote>
                                <p>
                                    {{ $post['body'] }}
                                </p>
                            </div>
                        </div>
                        <!-- END Portlet PORTLET-->
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT-->
@endsection