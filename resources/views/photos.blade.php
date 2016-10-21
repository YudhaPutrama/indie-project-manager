@extends('layouts.app')

@section('css-depends')
    @include('components.css.core')
    @include('components.css.dashboard')
    <link href="/vendor/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css">
@endsection

@section('js-depends')
    @include('components.js.core')
    <script type="text/javascript" src="/vendor/bootstrap-fileinput/bootstrap-fileinput.js"></script>
    <script src="/js/metronic.js" type="text/javascript"></script>
    <script src="/js/layout.js" type="text/javascript"></script>
    <script src="/js/pages/photos.js" type="text/javascript"></script>

    <script>
        jQuery(document).ready(function() {
            Metronic.init(); // init metronic core componets
            Layout.init(); // init layout
            //Photos.initComments();
            var cont = $('#chats');
            var list = $('.chats', cont);
            var form = $('.chat-form', cont);
            var input = $('input', form);
            var btn = $('.btn', form);
            var avatar = $('#avatar-img').attr('src');

            var handleClick = function (e) {
                e.preventDefault();

                var text = input.val();
                if (text.length == 0) {
                    return;
                }

                var time = new Date();
                var time_str = (time.getHours() + ':' + time.getMinutes());
                var tpl = '';
                tpl += '<li class="out">';
                tpl += '<img class="avatar" alt="" src="' + avatar + '"/>';
                tpl += '<div class="message">';
                tpl += '<span class="arrow"></span>';
                tpl += '<a href="#" class="name">You</a>&nbsp;';
                tpl += '<span class="datetime">at ' + time_str + '</span>';
                tpl += '<span class="body">';
                tpl += text;
                tpl += '</span>';
                tpl += '</div>';
                tpl += '</li>';

                var msg = list.append(tpl);
                input.val("");

                var getLastPostPos = function () {
                    var height = 0;
                    cont.find("li.out, li.in").each(function () {
                        height = height + $(this).outerHeight();
                    });

                    return height;
                };

                cont.find('.scroller').slimScroll({
                    scrollTo: getLastPostPos()
                });

                var formData = new FormData();
                formData.append('message',text);

                $.ajax({
                    url: window.location.pathname+'/comments',
                    type: 'POST',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    success: function (data) {
                        if (data.status=='success'){
                            toastr['success']("Comment successfully posted", "Post Comment");
                            window.location.reload();
                        } else {
                            toastr['error'](data.error, "Post Comment")
                        }
                        console.log(data);
                    },
                    error: function (data) {
                        toastr['error']("Can't connect to server", "Post Comment");;
                        //
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            };

            $('body').on('click', '.message .name', function (e) {
                e.preventDefault(); // prevent click event

                var name = $(this).text(); // get clicked user's full name
                input.val('@' + name + ':'); // set it into the input field
                Metronic.scrollTo(input); // scroll to input if needed
            });

            btn.click(handleClick);

            input.keypress(function (e) {
                if (e.which == 13) {
                    handleClick(e);
                    return false; //<---- Add this line
                }
            });

            $("form#editPhoto").submit(function() {

                var formData = new FormData($(this)[0]);

                $.ajax({
                    url: window.location.pathname,
                    type: 'POST',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    success: function (data) {
                        if (data.status=='success'){
                            toastr['success']("Photo successfully update", "Edit Photo");
                            var newphoto = "{{ Config::get('image.dir.projects.photos') }}"+data.photo.url;
                            $('#photo-canvas').attr('src',newphoto);
                            $('#photo-title').html(data.photo.title);
                            $('#photo-location').html(data.photo.location);
                        } else {
                            toastr['error']("Something error", "Edit Photo")
                        }
                        console.log(data);
                    },
                    error: function (data) {
                        toastr['error']("Can't connect to server", "Edit Photo")
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


@section('content')
    <div class="modal fade project" id="edit-photo" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form role="form" method="post" id="editPhoto" class="form-horizontal">
                    <input type="hidden" name="update" value="1">
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
                                <label class="control-label col-md-3">Photo Title <span class="required">* </span></label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <input type="text" class="form-control" name="title" value="{{ $photo['title'] }}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Location<span class="required">* </span></label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <input type="text" class="form-control" name="location" value="{{ $photo['location'] }}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Project Picture</label>
                                <div class="col-md-9">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
                                            <img src="{{ Config::get('image.dir.projects.photos').$photo['url'] }}" alt="">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
                                        </div>
                                        <div>
                                            <span class="btn default btn-file">
                                            <span class="fileinput-new">
                                            Select image </span>
                                            <span class="fileinput-exists">
                                            Change </span>
                                            <input type="file" name="photo">
                                            </span>
                                            <a href="#" class="btn red fileinput-exists" data-dismiss="fileinput">
                                                Remove </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Status</label>
                                <div class="col-md-8">
                                    <select class="form-control" name="status">
                                        <option value="uploaded" {{ ($photo['status']=='uploaded')?'selected':'' }}>Uploaded</option>
                                        <option value="reviewed" {{ ($photo['status']=='reviewed')?'reviewed':'' }}>Reviewed</option>
                                        <option value="done" {{ ($photo['status']=='done')?'done':'' }}>Done</option>
                                    </select>
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
    <!-- BEGIN PAGE HEADER-->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{ url('/') }}">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="{{ route('project') }}">Project</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="{{ route('project-detail',['project'=>$photo['project']]) }}">{{ $photo['project']->name }}</a>
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
                    @can('update', $photo)
                    <div class="actions">
                        {{--<span href="{{ Request::url().'/upload' }}" class="btn btn-circle red-sunglo btn-file">--}}
                            {{--<i class="fa fa-plus"></i> Update <input type="file" name="avatar" accept="image/*" id="avatar"></span>--}}
                        <a href="#edit-photo" class="btn btn-sm btn-circle btn-default" data-toggle="modal" role="button">
                            <i class="fa fa-pencil"></i> Edit Photo </a>
                        <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="#" data-original-title="" title="">
                        </a>
                    </div>
                    @endcan
                </div>
                <div class="portlet-body">
                    <img src="{{ Config::get('image.dir.projects.photos').$photo['url'] }}" class="img-responsive" id="photo-canvas">
                    <blockquote class="hero">
                        <p id="photo-title">
                            {{ $photo['title'] }}
                        </p>
                        <small id="photo-location">{{ $photo['location'] }}</small>
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
                            <img class="avatar" alt="" src="{{ Config::get('image.dir.avatar').(($comment['user']->avatar!=null)?$comment['user']->avatar:"default.jpg") }}"/>
                            <div class="message">
                                <span class="arrow"></span>
                                <a href="#" class="name"> {{ $comment['user']->fullname }} </a>
                                <span class="datetime"> at {{ (new Carbon\Carbon($comment['created_at']))->diffForHumans() }} </span>
                                <span class="body">
                                    {{ $comment['body'] }}
                                </span>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    <div class="chat-form">
                        <div class="input-cont">
                            <input class="form-control" type="text" placeholder="Type a message here..." name="message-body"/>
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