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
    <script type="text/javascript" src="/vendor/flot/jquery.flot.min.js"></script>
    <script type="text/javascript" src="/vendor/flot/jquery.flot.resize.min.js"></script>
    <script type="text/javascript" src="/vendor/flot/jquery.flot.categories.min.js"></script>
    <script type="text/javascript" src="/vendor/jquery.pulsate.min.js"></script>

    <script type="text/javascript" src="/js/metronic.js"></script>
    <script type="text/javascript" src="/js/layout.js"></script>
    <script type="text/javascript" src="/js/pages/index.js"></script>
    <script type="text/javascript" src="/vendor/jquery-validation/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/js/pages/form-validation.js"></script>
    <script type="text/javascript" src="/vendor/jquery-validation/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/vendor/jquery-validation/js/additional-methods.min.js"></script>
    <script type="text/javascript" src="/vendor/select2/select2.min.js"></script>
    <script type="text/javascript" src="/vendor/bootstrap-markdown/js/bootstrap-markdown.js"></script>
    <script type="text/javascript" src="/vendor/bootstrap-confirmation/bootstrap-confirmation.min.js"></script>
    <script type="text/javascript" src="/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="/vendor/bootstrap-fileinput/bootstrap-fileinput.js"></script>
    <script>
        jQuery(document).ready(function() {
            Metronic.init(); // init metronic core componets
            Layout.init(); // init layout
            Index.init();
            Index.initChat();
            FormValidation.init();

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
                            window.location.reload();
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
                                    <label class="control-label col-md-3">Summary<span class="required">* </span></label>
                                    <div class="col-md-8">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <textarea class="form-control" rows="2" name="summary" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="body" class="control-label col-md-3">Content<span class="required">* </span></label>
                                    <div class="col-md-8">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <textarea id="body" class="form-control" rows="4" name="body" required></textarea>
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
                                            <span class="fileinput-new">Select image </span>
                                            <span class="fileinput-exists">Change </span>
                                            <input type="file" name="image" required>
                                        </span>
                                                <a href="#" class="btn red fileinput-exists" data-dismiss="fileinput">Remove </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tags" class="control-label col-md-3">Tags</label>
                                    <div class="col-md-8">
                                        <div class="input-group select2-bootstrap-append">
                                            <select id="tags" class="form-control select2" multiple name="tags[]">
                                                @foreach($tags as $tag)
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
                                            @foreach($categories as $category)
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
        <div class="modal fade" id="newTag" tabindex="posts-1" role="basic" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" method="post" id="tag" class="form-horizontal">
                        <input type="hidden" name="action" value="tag">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">New Tag</h4>
                        </div>
                        <div class="modal-body">
                            <!-- BEGIN FORM-->
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Name <span class="required">* </span></label>
                                    <div class="col-md-8">
                                        <div class="input-icon right">
                                            <input type="text" class="form-control" name="name" required/>
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
        <div class="modal fade" id="newCategory" tabindex="posts-1" role="basic" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" method="post" id="category" class="form-horizontal">
                        <input type="hidden" name="action" value="category">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">New Category</h4>
                        </div>
                        <div class="modal-body">
                            <!-- BEGIN FORM-->
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Name <span class="required">*</span></label>
                                    <div class="col-md-8">
                                        <div class="input-icon right">
                                            <input type="text" class="form-control" name="name" required/>
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
                        <li class="divider"></li>
                        <li>
                            <a href="#newTag" data-toggle="modal" role="button">Tag</a>
                        </li>
                        <li>
                            <a href="#newCategory" data-toggle="modal" role="button">Category</a>
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
        <div class="col-md-12">
            @if(session('message'))
                <div class="note note-success">
                    <p>{{ session('message') }}</p>
                </div>
            @endif
            <div class="portlet light">

                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-book"></i>Post
                    </div>
                    <div class="actions">
                        <a href="#newPost" data-toggle="modal" role="button" class="btn btn-circle btn-default" id="new-user-btn">
                            <i class="fa fa-book"></i> New Post </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-advance table-hover">
                            <thead>
                            <tr>
                                <th><i class="fa fa-user"></i> Title</th>
                                <th><i class="fa fa-briefcase"></i> Category</th>
                                <th class="hidden-xs"><i class="fa fa-tags"></i> Tags</th>
                                <th><i class="fa fa-calendar"></i> Date</th>
                                <th><i class="fa fa-user"></i> Author</th>
                                <th><i class="fa fa-pencil"></i> Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($posts as $post)
                                <tr class="user-item">
                                    <td>{{ $post['title'] }}</td>
                                    <td>{{ $post->category['name'] }}</td>
                                    <td class="hidden-xs">
                                        <div class="btn-group-horizontal">
                                            @foreach($post['tags'] as $tag)
                                                <a href="{{ route('blog-tag-item',['tag'=>$tag]) }}" class="btn default btn-sm">
                                                    <i class="fa fa-tags icon-black"></i> {{ $tag['name'] }} </a>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>{{ (new \Carbon\Carbon($post['updated_at']))->toFormattedDateString() }}</td>
                                    <td>{{ $post->user->nickname }}</td>
                                    <td>
                                        @can('update', $post)
                                            <a href="{{ route('remove-post',['post'=>$post]) }}" class="btn default btn-xs red-stripe" data-toggle="confirmation" data-original-title="Are you sure?" id="remove-user">Remove Post </a>
                                            <a href="{{ route('update-post',['post'=>$post]) }}" class="btn default btn-xs green-stripe">Edit Post </a>
                                            <a href="{{ route('blog-view',['post'=>$post]) }}" class="btn default btn-xs blue-stripe">View Post </a>
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
    <div class="row">
        <div class="col-md-6">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-tags"></i>Tags
                    </div>
                    <div class="actions">
                        <a href="#newTag" data-role="client" data-toggle="modal" role="button" class="btn btn-circle btn-default" id="new-user-btn">
                            <i class="fa fa-tag"></i> New Tag </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-advance table-hover">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Slug</th>
                                <th><i class="fa fa-pencil"></i> Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tags as $tag)
                                <tr class="user-item">
                                    <td>
                                        {{ $tag['name'] }}
                                    </td>
                                    <td>
                                        {{ $tag['slug'] }}
                                    </td>
                                    <td>
                                        <a href="{{ route('blog-tag-remove',['tag'=>$tag]) }}" class="btn default btn-xs red-stripe" id="remove-user"><i class="fa fa-trash"></i> </a>
                                        <a href="{{ route('blog-tag-edit',['tag'=>$tag]) }}" class="btn default btn-xs green-stripe"><i class="fa fa-pencil"></i> </a>
                                        <a href="{{ route('blog-tag-item',['tag'=>$tag]) }}" class="btn default btn-xs blue-stripe"><i class="fa fa-angle-right"></i> </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-briefcase"></i>Categories
                    </div>
                    <div class="actions">
                        <a href="#newCategory" data-toggle="modal" role="button" class="btn btn-circle btn-default" id="new-user-btn">
                            <i class="fa fa-tag"></i> New Category</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-advance table-hover">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Slug</th>
                                <th><i class="fa fa-pencil"></i> Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                                <tr class="user-item">
                                    <td>{{ $category['name'] }}</td>
                                    <td>{{ $category['slug'] }}</td>
                                    <td>
                                        <a href="{{ route('blog-category-remove',['category'=>$category]) }}" class="btn default btn-xs red-stripe" id="remove-user"><i class="fa fa-trash"></i> </a>
                                        <a href="{{ route('blog-category-edit',['category'=>$category]) }}" class="btn default btn-xs green-stripe"><i class="fa fa-pencil"></i> </a>
                                        <a href="{{ route('blog-category-item',['category'=>$category]) }}" class="btn default btn-xs blue-stripe"><i class="fa fa-angle-right"></i> </a>
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
    <!-- END PAGE CONTENT-->
@endsection