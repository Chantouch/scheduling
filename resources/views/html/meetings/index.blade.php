@extends('layouts.app')
@section('style')
    <style>
        .card {
        / / height: 95.8 vh;
        }
    </style>
@stop
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
                        <h5>កម្មវិធីប្រជុំរបស់ឯកឧត្តមបណ្ឌិតអគ្គនាយក</h5>
                    </div>
                </div>
                <div class="col s3 m3 l3">
                    <div class="dates center">
                        <h5>
                            ថ្ងៃ<span id="day_of_week">loading ...</span> ទី
                            <span id="day">loading ...</span> ខែ
                            <span id="month">loading ...</span>
                            ឆ្នាំ<span id="year">loading ...</span>
                        </h5>
                        <div id="clock" class="clock">loading ...</div>
                    </div>
                </div>
                @include('html.meetings.table')
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
            socket.on('alert-channel:alert', function (message) {
                let meeting_data = message.meeting_data;
                console.log(message);
                let html = '<tr><td>' + meeting_data.date + '</td>'
                    + '<td>' + meeting_data.time + '</td>'
                    + '<td>' + meeting_data.subject + '</td>'
                    + '<td>' + meeting_data.related_org + '</td>'
                    + '<td>' + meeting_data.location + '</td></tr>';
                $('table.bordered').append(html);
            });
        });

        $(".delete").click(function () {
            let id = $(this).val();
            let $con = confirm('Are you sure to delete this image');
            if ($con) {
                $.ajax({
                    url: "/app/meetings/" + id,
                    data: {"_token": "{{ csrf_token() }}"},
                    type: 'DELETE',
                    success: function (result) {
                        console.log(result);
                    }
                });
                $(this).closest("tr").fadeOut(800);
                //$(this).closest("tr").remove();
            }
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
