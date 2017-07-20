/**
 * Created by Chantouch on 7/18/2017.
 */
let socket = io('127.0.0.1:3000');
$(function () {
    // var socket = io('127.0.0.1:3000');
    // var socket = io('192.241.170.241:3000'); // Server or Domain IP Address // For HTTP
    // let socket = io.connect('https://cambodianmatch.com:45621', {secure: true}); // For HTTPS
    // Message Notification real Time
    socket.on('create-mission-channel:create-mission', function (message) {
        let data = message.mission_data;
        let html = '<tr id="' + data.hashid + '">'
            + '<td>' + data.start_date + ' - ' + data.end_date + '</td>'
            + '<td>' + data.leader + '</td>'
            + '<td>' + data.mission + '</td>'
            + '<td>' + data.offer_to + '</td></tr>';
        setTimeout(function () {
            $('table.bordered').append(html);
        }, 500);
    });

    socket.on('update-mission-channel:update-mission', function (message) {
        let data = message.mission_data;
        let html = '<tr id="' + data.hashid + '">'
            + '<td>' + data.start_date + ' - ' + data.end_date + '</td>'
            + '<td>' + data.leader + '</td>'
            + '<td>' + data.mission + '</td>'
            + '<td>' + data.offer_to + '</td></tr>';
        setTimeout(function () {
            $('table.bordered').find('tr#' + data.hashid).replaceWith(html);
        }, 1000);
    });

    socket.on('delete-mission-channel:delete-mission', function (message) {
        let data = message.mission_data;
        setTimeout(function () {
            $('table.bordered').find('tr#' + data.hashid).fadeOut('slow');
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

$(function () {
    loadMoreMissionData();
});

function loadMoreMissionData() {
    $.ajax({
        url: '/missions',
        type: "GET",
        beforeSend: function () {
            //$('.ajax-load').show();
        }
    }).done(function (data) {
        let $data = '<tbody><tr><td colspan="12"><div class="center"><p>មិនទាន់មានបេសកកម្មនៅឡើយទេ។</p></div></td></tr></tbody>';
        if (data.html === $data) {
            $('.ajax-load').html("No more records found");
            return;
        }
        setTimeout(function () {
            loadMoreMissionData();
        }, 10000);
        //$('.ajax-load').hide();
        $("table#mission-data-reload tbody").replaceWith(data.html);
    }).fail(function (jqXHR, ajaxOptions, thrownError) {
        alert('server not responding...');
    });
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
        let $data = '<tbody><tr><td colspan="12"><div class="center"><p>មិនទាន់មានបេសកកម្មនៅឡើយទេ។</p></div></td></tr></tbody>';
        if (data.html === "") {
            $('.ajax-load').html("No more records found");
            return;
        }
        $('.ajax-load').hide();
        $("#mission-data").append(data.html);
    }).fail(function (jqXHR, ajaxOptions, thrownError) {
        alert('server not responding...');
    });
}