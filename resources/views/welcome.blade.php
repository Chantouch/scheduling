<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Leader's Schedules</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>

        @import url(https://fonts.googleapis.com/css?family=Hanuman:400,700&subset=khmer);
        @import url(https://fonts.googleapis.com/css?family=Moul);

        html, body {
            font-family: 'Hanuman', 'Helvetica Neue', Helvetica, Arial, sans-serif !important;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Moul', 'Helvetica Neue', Helvetica, Arial, sans-serif !important;
        }

        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 20px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: underline;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @if (Auth::check())
                <a href="{{ url('/home') }}">ទំព័រដើម</a>
            @else
                <a href="{{ url('/login') }}">ចូលប្រព័ន្ធ</a>
            @endif
        </div>
    @endif

    <div class="content">
        <div class="title m-b-md">
            កិច្ចប្រជុំ និង បេសកកម្ម នៃថ្នាកដឹកនាំ
        </div>

        <div class="links">
            <a href="{!! route('front.meetings.index') !!}" target="_blank">កិច្ចប្រជុំ</a>
            <a href="{!! route('front.missions.index') !!}" target="_blank">បេសកកម្ម</a>
        </div>
    </div>
</div>
</body>
</html>
