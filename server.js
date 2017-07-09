/**
 * Created by Chantouch on 7/9/2017.
 */
let server = require('http').Server();
let io = require('socket.io')(server);
server.listen(3000);
let Redis = require('ioredis');
let redis = new Redis();
redis.on("error", function(err){
    console.log(err);
});

redis.subscribe('alert-channel');
redis.on('message', function(channel, message){
    //console.log("Connected");
    message = JSON.parse(message);
    io.emit(channel + ':' + message.event, message.data);
});