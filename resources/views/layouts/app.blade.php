<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <!-- Title -->
    <title>{{ config('app.name', 'Admin Scheduling') }}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">
    <meta name="description" content="Responsive Admin Dashboard Template"/>
    <meta name="keywords" content="admin,dashboard"/>
    <meta name="author" content="Chantouch SEK"/>

    <!-- Styles -->
    <link type="text/css" rel="stylesheet" href="{!! asset('assets/plugins/materialize/css/materialize.min.css') !!}"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{!! asset('assets/plugins/material-preloader/css/materialPreloader.min.css') !!}" rel="stylesheet">

    <!-- Theme Styles -->
    <link href="{!! asset('assets/css/alpha.min.css') !!}" rel="stylesheet" type="text/css"/>
    <link href="{!! asset('assets/css/custom.css') !!}" rel="stylesheet" type="text/css"/>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="http://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="http://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .clocks {
            height: 100px;
            width: 70%;
            line-height: 100px;
            margin: 150px auto 0;
            padding: 0 50px;
            //background: #222;
            color: #000000;
            text-align: center;
            border-radius: 15px;
            box-shadow: 0 0 7px #222;
            text-shadow: 0 0 3px #fff;
        }
    </style>
    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    <!-- Styles -->
    @yield('style')
</head>
<body>
<div class="loader-bg"></div>
<div class="loader">
    <div class="preloader-wrapper big active">
        <div class="spinner-layer spinner-blue">
            <div class="circle-clipper left">
                <div class="circle"></div>
            </div>
            <div class="gap-patch">
                <div class="circle"></div>
            </div>
            <div class="circle-clipper right">
                <div class="circle"></div>
            </div>
        </div>
        <div class="spinner-layer spinner-spinner-teal lighten-1">
            <div class="circle-clipper left">
                <div class="circle"></div>
            </div>
            <div class="gap-patch">
                <div class="circle"></div>
            </div>
            <div class="circle-clipper right">
                <div class="circle"></div>
            </div>
        </div>
        <div class="spinner-layer spinner-yellow">
            <div class="circle-clipper left">
                <div class="circle"></div>
            </div>
            <div class="gap-patch">
                <div class="circle"></div>
            </div>
            <div class="circle-clipper right">
                <div class="circle"></div>
            </div>
        </div>
        <div class="spinner-layer spinner-green">
            <div class="circle-clipper left">
                <div class="circle"></div>
            </div>
            <div class="gap-patch">
                <div class="circle"></div>
            </div>
            <div class="circle-clipper right">
                <div class="circle"></div>
            </div>
        </div>
    </div>
</div>
<div class="mn-content fixed-sidebar">
    <main class="">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            @yield('content')
        </div>
    </main>
</div>
<div class="left-sidebar-hover"></div>

<!-- Javascripts -->
<script src="{!! asset('assets/plugins/jquery/jquery-2.2.0.min.js') !!}"></script>
<script src="{!! asset('assets/plugins/materialize/js/materialize.min.js') !!}"></script>
<script src="{!! asset('assets/plugins/material-preloader/js/materialPreloader.min.js') !!}"></script>
<script src="{!! asset('assets/plugins/jquery-blockui/jquery.blockui.js') !!}"></script>
<script src="{!! asset('assets/js/alpha.min.js') !!}"></script>
<script src="{!! asset('assets/plugins/moment/moment.min.js') !!}"></script>
<script src="{!! asset('assets/plugins/moment/jquery.fittext.min.js') !!}"></script>
<!-- Scripts -->
@yield('script')
</body>
</html>