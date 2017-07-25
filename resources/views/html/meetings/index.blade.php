@extends('layouts.app')
@section('style')
    <link rel="stylesheet" href="{!! asset('css/style.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/plugins/clock/css/style.css') !!}">
    <style>

    </style>
@stop
@section('content')
    <div class="col s12 m12 l12">
        <div class="card">
            <div class="card-content">
                <div class="col s3 m3 l3">
                    <div class="right">
                        <img src="{!! asset('assets/images/mef.png') !!}" class="responsive-img" width="125">
                    </div>
                </div>
                <div class="col s6 m6 l6 center">
                    <div class="main">
                        <h5 class="color-374CF3 line-height-15">អគ្គនាយកដ្ឋានរតនាគាជាតិ</h5>
                    </div>
                    {{--<div class="takteng">--}}
                    {{--<img src="{!! asset('assets/images/takteng.png') !!}" class="responsive-img" width="180">--}}
                    {{--</div>--}}
                    <div class="mains">
                        <h5 class="color-374CF3 line-height-15">កម្មវិធីប្រជុំថ្នាក់ដឹកនាំនិងមន្ត្រី អគ្គ.រតន</h5>
                    </div>
                </div>
                <div class="col s3 m3 l3">
                    <div class="dates center">
                        <h5 class="color-374CF3">
                            ថ្ងៃ<span id="day_of_week">loading ...</span>
                            ទី<span id="day">loading ...</span>
                            ខែ<span id="month">loading ...</span>
                            ឆ្នាំ<span id="year">loading ...</span>
                        </h5>
                        {{--<div id="clock" class="clock">loading ...</div>--}}
                        <div id="clocks" class="light">
                            <div class="ampm"></div>
                            <div class="alarm"></div>
                            <div class="digits"></div>
                        </div>
                    </div>
                </div>
                <table class="responsive-table bordered striped" id="meeting-data-reload">
                    <thead class="back_color">
                    <tr class="border header-topic">
                        <th data-field="date" class="table-header">កាលបរិច្ឆេទ</th>
                        <th data-field="time" class="table-header">ម៉ោង</th>
                        <th data-field="subject" class="table-header">កម្មវត្ថុ</th>
                        <th data-field="related_org" class="table-header">មន្រ្តីអម/អង្គភាពពាក់ព័ន្ធ</th>
                        <th data-field="location" class="table-header">ទីកន្លែង</th>
                    </tr>
                    </thead>
                    @include('html.meetings.table')
                </table>
                {{--<meetings></meetings>--}}
                <div class="center">
                    {{--<p class="heart">TH <span>♥</span> HT</p>--}}
                    {{--<div class="countdown"></div>--}}
                </div>

            </div>
            <div class="ajax-load text-center" style="display:none">
                <p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading More post</p>
            </div>
        </div>
        {{--<div id="countdown"></div>--}}
        {{--<div id="newcountdown"></div>--}}
    </div>
@endsection
@section('script')
    <script src="{!! asset('js/socket.io.js') !!}"></script>
    <script src="{!! asset('js/meeting.js') !!}"></script>
    <script src="{!! asset('assets/plugins/clock/js/script.js') !!}"></script>
    <script>

        function CountDownTimer(dt, id) {
            var end = new Date(dt);
            var _second = 1000;
            var _minute = _second * 60;
            var _hour = _minute * 60;
            var _day = _hour * 24;
            var timer;

            function showRemaining() {
                var now = new Date();
                var distance = end - now;
                if (distance < 0) {
                    clearInterval(timer);
                    document.getElementById(id).innerHTML = 'EXPIRED!';
                    return;
                }
                var days = Math.floor(distance / _day);
                var hours = Math.floor((distance % _day) / _hour);
                var minutes = Math.floor((distance % _hour) / _minute);
                var seconds = Math.floor((distance % _minute) / _second);
                document.getElementById(id).innerHTML = days + 'days ';
                document.getElementById(id).innerHTML += hours + 'hrs ';
                document.getElementById(id).innerHTML += minutes + 'mins ';
                document.getElementById(id).innerHTML += seconds + 'secs';
            }

            timer = setInterval(showRemaining, 1000);
        }
    </script>
@stop
