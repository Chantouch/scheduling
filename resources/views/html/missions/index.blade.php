@extends('layouts.app')

@section('content')
    <div class="col s12 m12 l12">
        <div class="card">
            <div class="card-content">
                <div class="col s3 m3 l3">
                    <div class="right">
                        <img src="{!! asset('assets/images/mef.png') !!}" class="responsive-img" width="100">
                    </div>
                </div>
                <div class="col s6 m6 l6 center">
                    <div class="main">
                        <h5>លេខាធិការដ្ឋាន នៃអគ្គនាយកដ្ឋានរតនាគាជាតិ</h5>
                    </div>
                    <div class="takteng">
                        <img src="{!! asset('assets/images/takteng.png') !!}" class="responsive-img" width="180">
                    </div>
                    <div class="mains">
                        <h5>បេសកកម្ម របស់ឯកឧត្តមបណ្ឌិតអគ្គនាយក</h5>
                    </div>
                </div>
                <div class="col s3 m3 l3">
                    <div class="dates center">
                        <h5>
                            ថ្ងៃ<span id="day_of_week">loading ...</span>
                            ទី<span id="day">loading ...</span> ខែ
                            <span id="month">loading ...</span>
                            ឆ្នាំ<span id="year">loading ...</span>
                        </h5>
                        <div id="clock" class="clock">loading ...</div>
                    </div>
                </div>
                @include('html.missions.table')
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{!! asset('js/socket.io.js') !!}"></script>
    <script>
        let socket = io('127.0.0.1:3000');
        $(function () {
            // var socket = io('127.0.0.1:3000');
            // var socket = io('192.241.170.241:3000'); // Server or Domain IP Address // For HTTP
            // let socket = io.connect('https://cambodianmatch.com:45621', {secure: true}); // For HTTPS
            // Message Notification real Time
            socket.on('create-mission-channel:create-mission', function (message) {
                let data = message.mission_data;
                console.log(message);
                let html = '<tr id="' + data.hashid + '">'
                    + '<td>' + data.start_date + ' to ' + data.end_date + '</td>'
                    + '<td>' + data.leader + '</td>'
                    + '<td>' + data.mission + '</td>'
                    + '<td>' + data.offer_to + '</td></tr>';
                setTimeout(function () {
                    $('table.bordered').append(html);
                }, 500);
            });

            socket.on('update-mission-channel:update-mission', function (message) {
                let data = message.mission_data;
                console.log(message);
                let html = '<tr id="' + data.hashid + '">'
                    + '<td>' + data.start_date + 'to' + data.end_date + '</td>'
                    + '<td>' + data.leader + '</td>'
                    + '<td>' + data.mission + '</td>'
                    + '<td>' + data.offer_to + '</td></tr>';
                setTimeout(function () {
                    $('table.bordered').find('tr#' + data.hashid).replaceWith(html);
                }, 1000);
            });

            socket.on('delete-mission-channel:delete-mission', function (message) {
                let data = message.mission_data;
                console.log(message);
                setTimeout(function () {
                    $('table.bordered').find('tr#' + data.hashid).fadeOut('slow');
                }, 1500);
            });

        });

        $('#clock').fitText(1.3);
        function update() {
            $('#clock').html(moment().format('H:mm:ss'));
            $('#day_of_week').html(moment().format('dddd'));
            $('#day').html(moment().format('DD'));
            $('#month').html(moment().format('MMMM'));
            $('#year').html(moment().format('YYYY'));
        }
        setInterval(update, 1000);
    </script>
@stop
