var FCM = require('fcm-push');
var serverKey = 'AAAAocsFlMQ:APA91bG92-CCrBOYOk2LTLyffzFOIZf_k0dtS7vO4-G5c0oNXjggxp0gKRHwTHA4m4erWvV4TMh7GYqPgI-IKhu5boFpnYu5QeeGW8nHrcYme1fR02znhK2AW581qQRIzY5Fq7CwhFfJ';
var fcm = new FCM(serverKey);
var pushMessageBody = process.argv[2];


var message = {
    to: 'fHp8uiyij-s:APA91bElRwHb9YHIzzf8pcBLI93ReRTLihyLh6oDGI0nzoRBUcfMdIGxdUl6Fc4T22tUvK-p5keQmB6YLTLWNX5N7NNovuXSOh8YxxwdO1X5CJQdh4EbTraNUUwgM3k1_By6FQwXQczv',
    collapse_key: 'com.example.bon.project_7',

    notification: {
        title: "mimamorume",
        body: "まだ対象者が帰宅しませんでした"
    }
}

fcm.send(message, function(err, response) {
    if(err) {
      console.log("falied");
    } else {
            console.log("succeed");
    }
});
