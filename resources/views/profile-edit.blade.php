@extends('layouts.app')

@section('css-depends')
    @include('components.css.core')
    @include('components.css.profile')
@endsection

@section('js-depends')
    @include('components.js.core')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="/vendor/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="/vendor/jquery.sparkline.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="/js/metronic.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    {{--<script src="/js/toastr.js"></script>--}}
    <script src="/js/layout.js" type="text/javascript"></script>
    {{--<script src="/js/profile.js" type="text/javascript"></script>--}}
    <!-- END PAGE LEVEL SCRIPTS -->
    <script>
        jQuery(document).ready(function() {
            $("form#uploadAvatar").submit(function() {

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
                            toastr['success']("Avatar upload success", "Avatar Upload");
                            window.location.reload();
                        } else {
                            toastr['error']("Something error", "Avatar Upload")
                        }
                        console.log(data);
                    },
                    error: function (data) {
                        toastr['error']("Can't connect to server", "Avatar Upload")
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
            $("form#biodata").submit(function() {

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
                            toastr['success']("Biodata update success", "Biodata Update");
                        } else {
                            toastr['error']("Something error", "Biodata Update")
                        }
                        console.log(data);
                    },
                    error: function (data) {
                        toastr['error']("Can't connect to server", "Biodata Update")
                    },
                    complete: function (data){
                        Metronic.unblockUI(_this)
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
                return false;
            });
            $("form#changePassword").submit(function() {

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
                            toastr['success']("Cahnge password success", "Change Password");
                        } else {
                            toastr['error']("Something error", "Change Password")
                        }
                        console.log(data);
                    },
                    error: function (data) {
                        toastr['error']("Can't connect to server", "Change Password");
                        console.log(data);
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


@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="portlet-title tabbable-line">
                    <div class="caption caption-md">
                        <i class="icon-globe theme-font hide"></i>
                        <span class="caption-subject font-blue-madison bold uppercase">Profile Account</span>
                    </div>
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_1_1" data-toggle="tab">Personal Info</a>
                        </li>
                        <li>
                            <a href="#tab_1_2" data-toggle="tab">Change Avatar</a>
                        </li>
                        <li>
                            <a href="#tab_1_3" data-toggle="tab">Change Password</a>
                        </li>
                    </ul>
                </div>
                <div class="portlet-body">
                    <div class="tab-content">
                        <!-- PERSONAL INFO TAB -->
                        <div class="tab-pane active" id="tab_1_1">
                            <form role="form" id="biodata" method="post">
                                <div class="form-group">
                                    <label class="control-label">Fullname</label>
                                    <input type="text" name="fullname" placeholder="John Doe" class="form-control" value="{{ $user['fullname'] }}"/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Nickname</label>
                                    <input type="text" name="nickname" placeholder="Doe" class="form-control" value="{{ $user['nickname'] }}"/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Phone Number</label>
                                    <input type="text" name="phone" placeholder="+628511111111 " class="form-control" value="{{ $user['phone'] }}"/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Title</label>
                                    <input type="text" name="title" placeholder="Leader" class="form-control" value="{{ $user['title'] }}"/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Institution</label>
                                    <input type="text" name="institution" placeholder="Google" class="form-control" value="{{ $user['institution'] }}"/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">About</label>
                                    <textarea name="bio" class="form-control" rows="3" placeholder="About you">{{ $user['bio'] }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Facebook URL</label>
                                    <input type="text" name="facebook" placeholder="https://www.facebook.com/user" class="form-control" value="{{ $user['facebook'] }}"/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Twitter URL</label>
                                    <input type="text" name="twitter" placeholder="https://www.twitter.com/user" class="form-control" value="{{ $user['twitter'] }}"/>
                                </div>
                                <div class="margiv-top-10">
                                    <input type="hidden" name="update" value="1">
                                    <button type="submit" class="btn green-haze" id="update">
                                        Save Changes </button>
                                </div>
                            </form>
                        </div>
                        <!-- END PERSONAL INFO TAB -->
                        <!-- CHANGE AVATAR TAB -->
                        <div class="tab-pane" id="tab_1_2">
                            <form role="form" method="post" enctype="multipart/form-data" id="uploadAvatar">
                                <div class="form-group">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                            <img src="{{ ($user['avatar']==null)?"/img/profile/default.jpg":Config::get('image.dir.avatar').$user['avatar'] }}" alt=""/>
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
                                        </div>
                                        <div>
                                            <span class="btn default btn-file">
                                                <span class="fileinput-new">
                                                    Select image </span>
                                                <span class="fileinput-exists">
                                                    Change </span>
                                                <input type="file" name="avatar" accept="image/*" id="avatar">
                                            </span>
                                            <a href="#" class="btn default fileinput-exists" data-dismiss="fileinput">
                                                Remove </a>
                                        </div>
                                    </div>
                                    <div class="clearfix margin-top-10">
                                        <span class="label label-danger">NOTE! </span>
                                        <span>Attached image thumbnail is supported in Latest Firefox, Chrome, Opera, Safari and Internet Explorer 10 only </span>
                                    </div>
                                </div>
                                <div class="margin-top-10">
                                    <button type="submit" class="btn green-haze" id="upload_btn">
                                        Upload </button>
                                    {{--<a href="#" class="btn default">--}}
                                        {{--Cancel </a>--}}
                                </div>
                            </form>
                        </div>
                        <!-- END CHANGE AVATAR TAB -->
                        <!-- CHANGE PASSWORD TAB -->
                        <div class="tab-pane" id="tab_1_3">
                            <form role="form" id="changePassword" method="post">
                                <div class="form-group">
                                    <label class="control-label">Current Password</label>
                                    <input type="password" class="form-control" name="currentpassword"/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">New Password</label>
                                    <input type="password" class="form-control" name="newpassword"/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Re-type New Password</label>
                                    <input type="password" class="form-control" name="newpassword_confirmation"/>
                                </div>
                                <input type="hidden" name="change-password" value="1">
                                <div class="margin-top-10">
                                    <button type="submit" class="btn green-haze" name="change">
                                        Change Password </button>
                                </div>
                            </form>
                        </div>
                        <!-- END CHANGE PASSWORD TAB -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection