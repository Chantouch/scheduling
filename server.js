/**
 * Created by Chantouch on 7/9/2017.
 */
let server = require('http').Server();
let io = require('socket.io')(server);
server.listen(3000);
let Redis = require('ioredis');
let redis = new Redis();
redis.on("error", function (err) {
    console.log(err);
});

redis.subscribe([
    'create-meeting-channel',
    'update-meeting-channel',
    'delete-meeting-channel',
    'create-mission-channel',
    'update-mission-channel',
    'delete-mission-channel',
]);

redis.on('message', function (channel, message) {
    console.log('Message Received: ' + message);
    message = JSON.parse(message);
    io.emit(channel + ':' + message.event, message.data);
});

server.listen(3000, function () {
    console.log('Listening on Port 3000');
});

server.on('disconnect', function () {
    redis.quit();
});