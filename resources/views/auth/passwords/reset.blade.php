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
        / / background: #222;
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

<body class="signin-page">
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
        <div class="spinner-layer spinner-red">
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
<div class="mn-content valign-wrapper">
    <main class="mn-inner container ">
        <div class="valign">
            <div class="row">
                <div class="col s12 m6 l4 offset-l4 offset-m3">
                    <div class="card white darken-1">
                        <div class="card-content ">
                            <span class="card-title">ភ្លេច លេខសម្ងាត់</span>
                            <div class="row">
                                @if (session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                <form class="form-horizontal col s12" role="form" method="POST"
                                      action="{{ route('password.request') }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label for="email" class="col-md-4 control-label">អ៊ីម៉ែល</label>
                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control" name="email"
                                                   value="{{ $email or old('email') }}" required autofocus>
                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <label for="password" class="col-md-4 control-label">លេខសម្ងាត់</label>
                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control" name="password"
                                                   required>
                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                        <label for="password-confirm" class="col-md-4 control-label">
                                            បញ្ចាក់លេខសម្ងាត់
                                        </label>
                                        <div class="col-md-6">
                                            <input id="password-confirm" type="password" class="form-control"
                                                   name="password_confirmation" required>
                                            @if ($errors->has('password_confirmation'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-4">
                                            <button type="submit" class="btn btn-primary">
                                                Reset Password
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

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