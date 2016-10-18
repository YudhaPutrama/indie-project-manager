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
    <script src="/vendor/dropzone/dropzone.js"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <script src="/js/pages/form-dropzone.js"></script>
    <script>
        jQuery(document).ready(function() {
            // initiate layout and plugins
//            Layout.init(); // init current layout
            FormFileUpload.init();
            FormDropzone.init();
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
        <p>
                    <span class="label label-danger">
                    NOTE: </span>
            &nbsp; This plugins works only on Latest Chrome, Firefox, Safari, Opera & Internet Explorer 10.
        </p>
        <form action="{{ Request::url() }}" class="dropzone" id="my-dropzone">
        </form>
    </div>
</div>
<!-- END PAGE CONTENT-->
@endsection