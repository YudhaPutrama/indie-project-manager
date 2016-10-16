@extends('layouts.app')

@section('css-depends')
    @include('components.css.core')
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="/vendor/dropzone/css/dropzone.css" rel="stylesheet"/>
    <!-- END PAGE LEVEL STYLES -->
@endsection

@section('js-depends')
    @include('components.js.core')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="/vendor/dropzone/dropzone.js"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <script src="/js/pages/form-dropzone.js"></script>
    <script>
        jQuery(document).ready(function() {
            // initiate layout and plugins
//            Layout.init(); // init current layout
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