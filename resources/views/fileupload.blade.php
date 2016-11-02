@extends('layouts.app')

@section('css-depends')
    @include('components.css.core')
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="/vendor/jquery-file-upload/blueimp-gallery/blueimp-gallery.min.css" rel="stylesheet"/>
    <link href="/vendor/jquery-file-upload/css/jquery.fileupload.css" rel="stylesheet"/>
    <link href="/vendor/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet"/>
    <!-- END PAGE LEVEL STYLES -->
    <link href="/vendor/dropzone/css/dropzone.css" rel="stylesheet"/>
    <!-- END PAGE LEVEL STYLES -->
@endsection

@section('js-depends')
    @include('components.js.core')
    <!-- BEGIN PAGE LEVEL PLUGINS -->

    <!-- BEGIN:File Upload Plugin JS files-->
    <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
    <script src="/vendor/jquery-file-upload/js/vendor/jquery.ui.widget.js"></script>
    <!-- The Templates plugin is included to render the upload/download listings -->
    <script src="/vendor/jquery-file-upload/js/vendor/tmpl.min.js"></script>
    <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
    <script src="/vendor/jquery-file-upload/js/vendor/load-image.min.js"></script>
    <!-- The Canvas to Blob plugin is included for image resizing functionality -->
    <script src="/vendor/jquery-file-upload/js/vendor/canvas-to-blob.min.js"></script>
    <!-- blueimp Gallery script -->
    <script src="/vendor/jquery-file-upload/blueimp-gallery/jquery.blueimp-gallery.min.js"></script>
    <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
    <script src="/vendor/jquery-file-upload/js/jquery.iframe-transport.js"></script>
    <!-- The basic File Upload plugin -->
    <script src="/vendor/jquery-file-upload/js/jquery.fileupload.js"></script>
    <!-- The File Upload processing plugin -->
    <script src="/vendor/jquery-file-upload/js/jquery.fileupload-process.js"></script>
    <!-- The File Upload image preview & resize plugin -->
    <script src="/vendor/jquery-file-upload/js/jquery.fileupload-image.js"></script>
    <!-- The File Upload audio preview plugin -->
    <script src="/vendor/jquery-file-upload/js/jquery.fileupload-audio.js"></script>
    <!-- The File Upload video preview plugin -->
    <script src="/vendor/jquery-file-upload/js/jquery.fileupload-video.js"></script>
    <!-- The File Upload validation plugin -->
    <script src="/vendor/jquery-file-upload/js/jquery.fileupload-validate.js"></script>
    <!-- The File Upload user interface plugin -->
    <script src="/vendor/jquery-file-upload/js/jquery.fileupload-ui.js"></script>
    <!-- The main application script -->
    <!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
    <!--[if (gte IE 8)&(lt IE 10)]>
    <script src="/vendor/jquery-file-upload/js/cors/jquery.xdr-transport.js"></script>
    <![endif]-->
    <!-- END:File Upload Plugin JS files-->
    
    <script src="/js/pages/form-fileupload.js"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <script src="/js/pages/form-dropzone.js"></script>
    <script>
        jQuery(document).ready(function() {
            // initiate layout and plugins
//            Layout.init(); // init current layout
            FormFileUpload.init();
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
        <form id="fileupload" action="../../assets/global/plugins/jquery-file-upload/server/php/" method="POST" enctype="multipart/form-data">
            <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
            <div class="row fileupload-buttonbar">
                <div class="col-lg-7">
                    <!-- The fileinput-button span is used to style the file input field as button -->
                    <span class="btn green fileinput-button">
								<i class="fa fa-plus"></i>
								<span>
								Add files... </span>
								<input type="file" name="files[]" multiple="">
								</span>
                    <button type="submit" class="btn blue start">
                        <i class="fa fa-upload"></i>
                        <span>
								Start upload </span>
                    </button>
                    <button type="reset" class="btn warning cancel">
                        <i class="fa fa-ban-circle"></i>
                        <span>
								Cancel upload </span>
                    </button>
                    <button type="button" class="btn red delete">
                        <i class="fa fa-trash"></i>
                        <span>
								Delete </span>
                    </button>
                    {{--<input type="checkbox" class="toggle">--}}
                    <!-- The global file processing state -->
                    <span class="fileupload-process">
								</span>
                </div>
                <!-- The global progress information -->
                <div class="col-lg-5 fileupload-progress fade">
                    <!-- The global progress bar -->
                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar progress-bar-success" style="width:0%;">
                        </div>
                    </div>
                    <!-- The extended global progress information -->
                    <div class="progress-extended">
                        &nbsp;
                    </div>
                </div>
            </div>
            <!-- The table listing the files available for upload/download -->
            <table role="presentation" class="table table-striped clearfix">
                <tbody class="files">
                </tbody>
            </table>
        </form>
    </div>
</div>
<!-- END PAGE CONTENT-->
@endsection