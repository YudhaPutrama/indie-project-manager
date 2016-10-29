@extends('layouts.app')
@section('css-depends')
    @include('components.css.core')
    @include('components.css.dashboard')
    <link rel="stylesheet" type="text/css" href="/vendor/bootstrap-fileinput/bootstrap-fileinput.css"/>
    <link rel="stylesheet" type="text/css" href="/vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"/>
    <link rel="stylesheet" type="text/css" href="/vendor/bootstrap-datepicker/css/datepicker.css"/>
    <link rel="stylesheet" type="text/css" href="/vendor/select2/select2.css" />
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
//            FormValidation.init();

            $('.select2').select2();
            $("form").submit(function() {

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
    @can('create', \App\Post::class)
<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
<div class="modal fade" id="newPost" tabindex="posts-1" role="basic" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" method="post" id="newPost" class="form-horizontal">
                <input type="hidden" name="action" value="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">New Post</h4>
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
                                    <input type="text" class="form-control" name="title"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Summary<span class="required">* </span></label>
                            <div class="col-md-8">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <textarea class="form-control" rows="2" name="summary"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="body" class="control-label col-md-3">Content<span class="required">* </span></label>
                            <div class="col-md-8">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <textarea id="body" class="form-control" rows="4" name="body"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Post Picture</label>
                            <div class="col-md-8">
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
                        <div class="form-group">
                            <label for="tags" class="control-label col-md-3">Tags</label>
                            <div class="col-md-8">
                                <div class="input-group select2-bootstrap-append">
                                    <select id="tags" class="form-control select2" multiple name="tags">
                                        @foreach(\App\Tag::all() as $tag)
                                        <option value="{{ $tag['slug'] }}">{{ $tag['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button" data-select2-open="multi-append">
                                            <span class="glyphicon glyphicon-search"></span>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="category" class="control-label col-md-3">Category</label>
                            <div class="col-md-8">
                                <select id="category" class="form-control select2" name="category">
                                    @foreach(\App\Category::all() as $category)
                                        <option value="{{ $category['slug'] }}">{{ $category['name'] }}</option>
                                    @endforeach
                                </select>
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
<div class="modal fade" id="newSlug" tabindex="posts-1" role="basic" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" method="post" id="slug" class="form-horizontal">
                <input type="hidden" name="action" value="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">New Post</h4>
                </div>
                <div class="modal-body">
                    <!-- BEGIN FORM-->
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Title <span class="required">* </span></label>
                            <div class="col-md-8">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="title"/>
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
<!-- /.modal -->
<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
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
    @can('create', \App\Post::class)
    <div class="page-toolbar">
        <div class="btn-group pull-right">
            <button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
                New <i class="fa fa-angle-down"></i>
            </button>
            <ul class="dropdown-menu pull-right" role="menu">
                <li>
                    <a href="#newPost" data-toggle="modal" role="button">Post</a>
                </li>
                <li class="divider">
                </li>
                <li>
                    <a href="#" disabled="">Tag</a>
                </li>
                <li>
                    <a href="#" disabled="">Category</a>
                </li>
            </ul>
        </div>
    </div>
    @endcan
</div>
<h3 class="page-title">
    Blog <small></small>
</h3>
<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-9">
        @foreach($posts as $post)
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption"><i class="icon-speech"></i> <a href="{{ route('blog-view',['blog'=>$post])  }}">{{ $post['title'] }}</a></div>
                <div class="actions inline">
                    <a class="btn btn-circle btn-default"><i class="fa fa-calendar"></i> {{ (new \Carbon\Carbon($post['created_at']))->diffForHumans() }} </a>
                    </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-4 blog-img blog-tag-data">
                        <img src="{{ Config::get('image.dir.postThumb').(($post->image!=null)?$post->image:"default.jpg") }}" alt="" class="img-responsive">
                    </div>
                    <div class="col-md-8 blog-article">
                        <ul class="list-inline blog-tags">
                            <li>
                                @foreach($post['tags'] as $tag)
                                    <a href="{{ route('blog-tag-item',['tag'=>$tag]) }}" class="btn btn-default">
                                    <i class="fa fa-tags"></i>
                                    {{ $tag['name'] }}</a>
                                @endforeach
                            </li>
                        </ul>
                        <p>
                            {{ $post['summary'] }}
                        </p>
                        <a class="btn blue" href="{{ route('blog-view',['blog'=>$post]) }}">
                            Read more <i class="m-icon-swapright m-icon-white"></i>
                        </a>
                    </div>
                </div>
                <hr>
            </div>
        </div>
        @endforeach
        {{ $posts->links() }}
    </div>
    <div class="col-md-3 blog-sidebar">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>Categories
                </div>
            </div>
            <div class="portlet-body">
                <div class="top-news">
                    @foreach(\App\Category::all() as $category)
                        <a href="{{ route('blog-category-item', ['category'=>$category]) }}" class="btn red">
                            <em>{{ $category['name'] }}</em>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-tags"></i>Tags
                </div>
            </div>
            <div class="portlet-body">
                <ul class="list-inline sidebar-tags">
                    @foreach(\App\Tag::all() as $tag)
                        <li><a href="{{ route('blog-category-item',['tag'=>$tag]) }}"><i class="fa fa-tags"></i> {{ $tag['name'] }} </a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE CONTENT-->
@endsection