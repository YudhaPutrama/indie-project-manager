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

            $("form#newProject").submit(function() {
                var _this = $(this);
                Metronic.blockUI({
                    target: _this,
                    animate: true
                });
                var formData = new FormData($(this)[0]);

                $.ajax({
                    url: window.location.pathname,
                    type: 'POST',
                    data: formData,
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
                    complete: function (data){
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
    <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
    <div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Modal title</h4>
                </div>
                <div class="modal-body">
                    Widget settings form goes here
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn blue">Save changes</button>
                    <button type="button" class="btn default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
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
                <button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
                    Actions <i class="fa fa-angle-down"></i>
                </button>
                <ul class="dropdown-menu pull-right" role="menu">
                    <li>
                        <a href="#">Action</a>
                    </li>
                    <li>
                        <a href="#">Another action</a>
                    </li>
                    <li>
                        <a href="#">Something else here</a>
                    </li>
                    <li class="divider">
                    </li>
                    <li>
                        <a href="#">Separated link</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <h3 class="page-title">
        Blog Post
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
                                <i class="fa fa-gift"></i> New Post
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form class="form-horizontal" role="form">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Block Help</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" placeholder="Enter text">
                                            <span class="help-block">
											A block of help text. </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Inline Help</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control input-inline input-medium" placeholder="Enter text">
                                            <span class="help-inline">
											Inline help. </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Input Group</label>
                                        <div class="col-md-9">
                                            <div class="input-inline input-medium">
                                                <div class="input-group">
													<span class="input-group-addon">
													<i class="fa fa-user"></i>
													</span>
                                                    <input type="email" class="form-control" placeholder="Email Address">
                                                </div>
                                            </div>
                                            <span class="help-inline">
											Inline help. </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Email Address</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
												<span class="input-group-addon">
												<i class="fa fa-envelope"></i>
												</span>
                                                <input type="email" class="form-control" placeholder="Email Address">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Password</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <input type="password" class="form-control" placeholder="Password">
                                                <span class="input-group-addon">
												<i class="fa fa-user"></i>
												</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Left Icon</label>
                                        <div class="col-md-9">
                                            <div class="input-icon">
                                                <i class="fa fa-bell-o"></i>
                                                <input type="text" class="form-control" placeholder="Left icon">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Right Icon</label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <i class="fa fa-microphone"></i>
                                                <input type="text" class="form-control" placeholder="Right icon">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Icon Input in Group Input</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <div class="input-icon">
                                                    <i class="fa fa-lock fa-fw"></i>
                                                    <input id="newpassword" class="form-control" type="text" name="password" placeholder="password">
                                                </div>
                                                <span class="input-group-btn">
												<button id="genpassword" class="btn btn-success" type="button"><i class="fa fa-arrow-left fa-fw"></i> Random</button>
												</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Input With Spinner</label>
                                        <div class="col-md-9">
                                            <input type="password" class="form-control spinner" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Static Control</label>
                                        <div class="col-md-9">
                                            <p class="form-control-static">
                                                email@example.com
                                            </p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Disabled</label>
                                        <div class="col-md-9">
                                            <input type="password" class="form-control" placeholder="Disabled" disabled="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Readonly</label>
                                        <div class="col-md-9">
                                            <input type="password" class="form-control" placeholder="Readonly" readonly="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Dropdown</label>
                                        <div class="col-md-9">
                                            <select class="form-control">
                                                <option>Option 1</option>
                                                <option>Option 2</option>
                                                <option>Option 3</option>
                                                <option>Option 4</option>
                                                <option>Option 5</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Multiple Select</label>
                                        <div class="col-md-9">
                                            <select multiple="" class="form-control">
                                                <option>Option 1</option>
                                                <option>Option 2</option>
                                                <option>Option 3</option>
                                                <option>Option 4</option>
                                                <option>Option 5</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Textarea</label>
                                        <div class="col-md-9">
                                            <textarea class="form-control" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile" class="col-md-3 control-label">File input</label>
                                        <div class="col-md-9">
                                            <input type="file" id="exampleInputFile">
                                            <p class="help-block">
                                                some help text here.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Checkboxes</label>
                                        <div class="col-md-9">
                                            <div class="checkbox-list">
                                                <label>
                                                    <div class="checker"><span><input type="checkbox"></span></div> Checkbox 1 </label>
                                                <label>
                                                    <div class="checker"><span><input type="checkbox"></span></div> Checkbox 1 </label>
                                                <label>
                                                    <div class="checker disabled"><span><input type="checkbox" disabled=""></span></div> Disabled </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Inline Checkboxes</label>
                                        <div class="col-md-9">
                                            <div class="checkbox-list">
                                                <label class="checkbox-inline">
                                                    <div class="checker" id="uniform-inlineCheckbox21"><span><input type="checkbox" id="inlineCheckbox21" value="option1"></span></div> Checkbox 1 </label>
                                                <label class="checkbox-inline">
                                                    <div class="checker" id="uniform-inlineCheckbox22"><span><input type="checkbox" id="inlineCheckbox22" value="option2"></span></div> Checkbox 2 </label>
                                                <label class="checkbox-inline">
                                                    <div class="checker disabled" id="uniform-inlineCheckbox23"><span><input type="checkbox" id="inlineCheckbox23" value="option3" disabled=""></span></div> Disabled </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Radio</label>
                                        <div class="col-md-9">
                                            <div class="radio-list">
                                                <label>
                                                    <div class="radio" id="uniform-optionsRadios22"><span><input type="radio" name="optionsRadios" id="optionsRadios22" value="option1" checked=""></span></div> Option 1 </label>
                                                <label>
                                                    <div class="radio" id="uniform-optionsRadios23"><span><input type="radio" name="optionsRadios" id="optionsRadios23" value="option2" checked=""></span></div> Option 2 </label>
                                                <label>
                                                    <div class="radio disabled" id="uniform-optionsRadios24"><span><input type="radio" name="optionsRadios" id="optionsRadios24" value="option2" disabled=""></span></div> Disabled </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Inline Radio</label>
                                        <div class="col-md-9">
                                            <div class="radio-list">
                                                <label class="radio-inline">
                                                    <div class="radio" id="uniform-optionsRadios25"><span><input type="radio" name="optionsRadios" id="optionsRadios25" value="option1" checked=""></span></div> Option 1 </label>
                                                <label class="radio-inline">
                                                    <div class="radio" id="uniform-optionsRadios26"><span class="checked"><input type="radio" name="optionsRadios" id="optionsRadios26" value="option2" checked=""></span></div> Option 2 </label>
                                                <label class="radio-inline">
                                                    <div class="radio disabled" id="uniform-optionsRadios27"><span><input type="radio" name="optionsRadios" id="optionsRadios27" value="option3" disabled=""></span></div> Disabled </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn green">Submit</button>
                                            <button type="button" class="btn default">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- END Portlet PORTLET-->
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
@endsection