/**
 * Created by Chantouch on 7/17/2017.
 */
let socket = io('127.0.0.1:3000');
$(function () {
    // let socket = io('127.0.0.1:3000');
    // let socket = io('192.168.101.115:3000'); // Server or Domain IP Address // For HTTP
    // let socket = io.connect('https://cambodianmatch.com:45621', {secure: true}); // For HTTPS
    // Message Notification real Time
    socket.on('create-meeting-channel:create-meeting', function (message) {
        let meeting_data = message.meeting_data;
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
        let html = '<tr id="' + meeting_data.hashid + '"><td>' + meeting_data.date + '</td>'
            + '<td>' + meeting_data.start_time + ' - ' + meeting_data.end_time + '</td>'
            + '<td>' + meeting_data.subject + '</td>'
            + '<td>' + meeting_data.related_org + '</td>'
            + '<td>' + meeting_data.location + '</td></tr>';
        setTimeout(function () {
            $('table.bordered').find('tr#' + meeting_data.hashid).replaceWith(html);
        }, 1000);
    });

    socket.on('delete-meeting-channel:delete-meeting', function (message) {
        let meeting_data = message.meeting_data;
        setTimeout(function () {
            $('table.bordered').find('tr#' + meeting_data.hashid).fadeOut('slow');
        }, 1500);
    });
});


let today = moment();
today.locale('km');
console.log(today.calendar());
console.log(moment().calendar());

$('#clock').fitText(1.3);

function update() {
    $('#clock').html(moment().format('H:mm:ss'));
    $('#day_of_week').html(today.format('dddd'));
    $('#day').html(today.format('DD'));
    $('#month').html(today.format('MMMM'));
    $('#year').html(today.format('YYYY'));
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
});

$(function () {
    loadMoreMeetingData();
    trackTime('10:01', ".countdown");
});

function loadMoreMeetingData() {
    $.ajax({
        url: '/meetings',
        type: "GET",
        beforeSend: function () {
            //$('.ajax-load').show();
        }
    }).done(function (data) {
        if (data.html === "") {
            $('.ajax-load').html("No more records found");
            return;
        }
        setTimeout(function () {
            loadMoreMeetingData();
        }, 1000);
        //$('.ajax-load').hide();
        $("table#meeting-data-reload tbody").replaceWith(data.html);
    }).fail(function (jqXHR, ajaxOptions, thrownError) {
        alert('server not responding...');
    });
}

function trackTime(time, counter) {
    let interval = setInterval(function () {
        let timer = time.split(':');
        //by parsing integer, I avoid all extra string processing
        let minutes = parseInt(timer[0], 10);
        let seconds = parseInt(timer[1], 10);
        --seconds;
        minutes = (seconds < 0) ? --minutes : minutes;
        if (minutes < 0) clearInterval(interval);
        seconds = (seconds < 0) ? 59 : seconds;
        seconds = (seconds < 10) ? '0' + seconds : seconds;
        //minutes = (minutes < 10) ?  minutes : minutes;
        $(counter).html(minutes + ':' + seconds);
        time = minutes + ':' + seconds;
    }, 1000);
}

//------------Paginate on scroll------------//
let page = 1;
$(window).scroll(function () {
    if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
        page++;
        loadMoreData(page);
    }
});

function loadMoreData(page) {
    $.ajax({
        url: '?page=' + page,
        type: "GET",
        beforeSend: function () {
            $('.ajax-load').show();
        }
    }).done(function (data) {
        if (data.html === "") {
            $('.ajax-load').html("No more records found");
            return;
        }
        $('.ajax-load').hide();
        $("#meeting-data").append(data.html);
    }).fail(function (jqXHR, ajaxOptions, thrownError) {
        alert('server not responding...');
    });
}