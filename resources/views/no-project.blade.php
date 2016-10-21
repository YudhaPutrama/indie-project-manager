<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title>{{ Config::get('app.name') }} | Project Not Found</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta content="" name="description"/>
    <meta content="YudhaPutrama" name="author"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
    {{--<link href="/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>--}}
    {{--<link href="/vendor/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>--}}
    <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="/css/pages/lock.css" rel="stylesheet" type="text/css"/>
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME STYLES -->
    <link href="/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
    <link href="/css/plugins.css" rel="stylesheet" type="text/css"/>
    {{--<link href="/css/layout.css" rel="stylesheet" type="text/css"/>--}}
    {{--<link href="/css/themes/darkblue.css" rel="stylesheet" type="text/css" id="style_color"/>--}}
    <link href="/css/custom.css" rel="stylesheet" type="text/css"/>
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
<!-- BEGIN LOGO -->
<div class="page-lock">
    <div class="page-logo">
        <a class="brand" href="/">
            <img src="/img/indie.png" alt="logo">
        </a>
    </div>
    <div class="page-body">
        <div class="lock-head">
            Your project has not been set
        </div>

        <div class="lock-bottom">
            <div class="form-actions">
                <button type="submit" class="btn btn-success uppercase" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</button>
            </div>
        </div>
        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
        </form>
    </div>
    <div class="page-footer-custom">
        2016 © {{ Config::get('app.name') }}
    </div>
</div>
</body>
<!-- END BODY -->
</html>