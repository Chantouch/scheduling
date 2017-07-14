@extends('layouts.app')
@section('style')
    <style>
        .card {
            /*height: 95.8 vh;*/
        }

        @-webkit-keyframes invalid {
            from {
                background-color: red;
            }
            to {
                background-color: inherit;
            }
        }

        @-moz-keyframes invalid {
            from {
                background-color: red;
            }
            to {
                background-color: inherit;
            }
        }

        @-o-keyframes invalid {
            from {
                background-color: red;
            }
            to {
                background-color: inherit;
            }
        }

        @keyframes invalid {
            from {
                background-color: red;
            }
            to {
                background-color: inherit;
            }
        }

        @-webkit-keyframes valid {
            from {
                background-color: green;
            }
            to {
                background-color: inherit;
            }
        }

        @-moz-keyframes valid {
            from {
                background-color: green;
            }
            to {
                background-color: inherit;
            }
        }

        @-o-keyframes valid {
            from {
                background-color: green;
            }
            to {
                background-color: inherit;
            }
        }

        @keyframes valid {
            from {
                background-color: green;
            }
            to {
                background-color: inherit;
            }
        }

        .invalid {
            -webkit-animation: invalid 1s infinite; /* Safari 4+ */
            -moz-animation: invalid 1s infinite; /* Fx 5+ */
            -o-animation: invalid 1s infinite; /* Opera 12+ */
            animation: invalid 1s infinite; /* IE 10+ */
        }

        .valid {
            background-color: #248001;
            color: #fff;
        }

        td {
            padding: 1em;
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
            // var socket = io('192.168.101.115:3000'); // Server or Domain IP Address // For HTTP
            // let socket = io.connect('https://cambodianmatch.com:45621', {secure: true}); // For HTTPS
            // Message Notification real Time
            let d = new Date();
            let month = d.getMonth() + 1;
            let day = d.getDate();
            let time = d.getHours() + ":" + d.getMinutes();
            let time_10 = addMinutes(time, '10');
            let date = d.getFullYear() + '-' + month + '-' + day;
            socket.on('create-meeting-channel:create-meeting', function (message) {
                let meeting_data = message.meeting_data;
                console.log(message);
                let html = '<tr id="' + meeting_data.hashid + '"><td>' + meeting_data.date + '</td>'
                    + '<td>' + meeting_data.start_time + ' - ' + meeting_data.end_time + '</td>'
                    + '<td>' + meeting_data.subject + '</td>'
                    + '<td>' + meeting_data.related_org + '</td>'
                    + '<td>' + meeting_data.location + '</td></tr>';
                setTimeout(function () {
                    $('table.bordered').append(html);
                }, 1000);
            });

            function addMinutes(time/*"hh:mm"*/, minsToAdd/*"N"*/) {
                function z(n) {
                    return (n < 10 ? '0' : '') + n;
                }

                let bits = time.split(':');
                let mins = bits[0] * 60 + (+bits[1]) + (+minsToAdd);
                return z(mins % (24 * 60) / 60 | 0) + ':' + z(mins % 60);
            }

            socket.on('update-meeting-channel:update-meeting', function (message) {
                let meeting_data = message.meeting_data;
                console.log(message);
                let html = '<tr id="' + meeting_data.hashid + '"><td>' + meeting_data.date + '</td>'
                    + '<td>' + meeting_data.start_time + ' - ' + meeting_data.end_time + '</td>'
                    + '<td>' + meeting_data.subject + '</td>'
                    + '<td>' + meeting_data.related_org + '</td>'
                    + '<td>' + meeting_data.location + '</td></tr>';
                setTimeout(function () {
                    $('table.bordered').find('tr#' + meeting_data.hashid).replaceWith(html);
                    if (meeting_data.start_time <= time && meeting_data.end_time >= time) {
                        console.log(meeting_data.start_time);
                        $("#ND").addClass('meeting-now valid');
                    }
                    if (meeting_data.start_time <= time && meeting_data.end_time >= time) {
                        console.log(time_10);
                        $("#ND").removeClass('meeting-now valid');
                        $("#Je").addClass('meeting-now valid');
                    }
                }, 1000);
            });

            socket.on('delete-meeting-channel:delete-meeting', function (message) {
                let meeting_data = message.meeting_data;
                //console.log(message);
                setTimeout(function () {
                    $('table.bordered').find('tr#' + meeting_data.hashid).fadeOut('slow');
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

        $(function animateHeart() {
            $('.heart span').animate({
                fontSize: $('.heart span').css('fontSize') === '75px' ? '50px' : '75px'
            }, 500, animateHeart);
        });

        $(function () {
            (function invalid() {
                $('tr.almost-meeting').delay(200).addClass('invalid', invalid).delay(50).fadeIn('slow', invalid);
            })();
            (function valid() {
                $('.meeting-now').delay(200).addClass('valid', valid).delay(50).fadeIn('slow', valid);
            })();

            (function getMeetingData() {
                $("#meeting_data").load('/api/v1/meetings');
            })();

            let d = new Date();
            let month = d.getMonth() + 1;
            let day = d.getDate();
            let time = d.getHours() + ":" + d.getMinutes();
            let date = d.getFullYear() + '-' + month + '-' + day;
            //console.log(time);
        });

        function get_fb_success() {
            $('#log_success').append('<li>get_fb() ran</li>');
            var feedback = $.ajax({
                type: "GET",
                url: "/api/v1/meetings",
                async: false
            }).success(function () {
                setTimeout(function () {
                    get_fb_success();
                }, 1000);
            }).responseText;

            $('div.feedback-box-success').html('success feedback');
        }

        function get_meeting_complete() {
            $('#log_complete').append('<li>get_fb() ran</li>');
            let feedback = $.ajax({
                type: "GET",
                url: "/api/v1/meetings",
                async: false
            }).complete(function (data) {
                setTimeout(function () {
                    get_meeting_complete();
                }, 10000);
                //console.log(data);
            }).responseText;
            $('div.feedback-box-complete').html('complete feedback');
        }

        $(function () {
            //get_fb_success();
            //get_meeting_complete();
        });

        var reservations = [
            {
                "id": 1,
                "date": "12-07-2017",
                "start_time": "09:45",
                "end_time": "09:50",
                "ampm": "AM",
                "subject": "Have meeting for good news",
                "related_org": "ITD",
                "location": "Phnom Penh",
                "user_id": 1,
                "created_at": "2017-07-12 09:29:08",
                "updated_at": "2017-07-12 09:44:48",
                "deleted_at": null,
                "hashid": "ND",
                "user": {
                    "id": 1,
                    "name": "Chantouch Sek",
                    "email": "chantouchsek.cs83@gmail.com",
                    "created_at": "2017-07-07 11:41:24",
                    "updated_at": "2017-07-07 11:41:24"
                }
            },
            {
                "id": 2,
                "date": "12-07-2017",
                "start_time": "09:50",
                "end_time": "10:10",
                "ampm": "AM",
                "subject": "Nice sfat",
                "related_org": ".skdl",
                "location": "lsdklfsdfs",
                "user_id": 1,
                "created_at": "2017-07-12 09:29:47",
                "updated_at": "2017-07-12 09:29:47",
                "deleted_at": null,
                "hashid": "Je",
                "user": {
                    "id": 1,
                    "name": "Chantouch Sek",
                    "email": "chantouchsek.cs83@gmail.com",
                    "created_at": "2017-07-07 11:41:24",
                    "updated_at": "2017-07-07 11:41:24"
                }
            }
        ];

        var tbody = $('#reservations tbody'),
            props = ["date", "start_time", "subject", "related_org", 'location'];
        $.each(reservations, function (i, reservation) {
            var tr = $('<tr>');
            $.each(props, function (i, prop) {
                $('<td>').html(reservation[prop]).appendTo(tr);
                //console.log(prop);
            });
            tbody.append(tr);
        });


    </script>
@stop
