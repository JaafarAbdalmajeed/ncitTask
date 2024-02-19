<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Interface</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src='//production-assets.codepen.io/assets/editor/live/console_runner-079c09a0e3b9ff743e39ee2d5637b9216b3545af0de366d4b9aad9dc87e26bfd.js'></script><script src='//production-assets.codepen.io/assets/editor/live/events_runner-73716630c22bbc8cff4bd0f07b135f00a0bdc5d14629260c3ec49e5606f98fdd.js'></script><script src='//production-assets.codepen.io/assets/editor/live/css_live_reload_init-2c0dc5167d60a5af3ee189d570b1835129687ea2a61bee3513dee3a50c115a77.js'></script><meta charset='UTF-8'><meta name="robots" content="noindex"><link rel="shortcut icon" type="image/x-icon" href="//production-assets.codepen.io/assets/favicon/favicon-8ea04875e70c4b0bb41da869e81236e54394d63638a1ef12fa558a4a835f1164.ico" /><link rel="mask-icon" type="" href="//production-assets.codepen.io/assets/favicon/logo-pin-f2d2b6d2c61838f7e76325261b7195c27224080bc099486ddd6dccb469b8e8e6.svg" color="#111" /><link rel="canonical" href="https://codepen.io/emilcarlsson/pen/ZOQZaV?limit=all&page=74&q=contact+" />
<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,300' rel='stylesheet' type='text/css'>


    {{-- <style>
        /* Chat Container */
        .chat-container {
            max-width: 600px;
            margin: 50px auto;
        }

        /* Chat Messages */
        .chat-messages {
            list-style-type: none;
            padding: 0;
        }

        .chat-message {
            margin-bottom: 15px;
        }

        .chat-message .message {
            padding: 10px;
            border-radius: 10px;
        }

        .sender-message {
            background-color: #007bff;
            color: #fff;
        }

        .receiver-message {
            background-color: #f0f0f0;
            color: #333;
        }

        /* Message Input */
        .message-input {
            margin-top: 20px;
        }
    </style> --}}
</head>
<body>

    @include('chat.chat2')
{{-- <div class="container">
    <div class="chat-container">
        <h2>Chat {{$receiver->name}}</h2>

        <div class="chat-area" id="chat_area">
            <div class="chat-messages">
                <div class="chat-message sender-message">
                    <p  class="message senderMessage">Hello, how are you?</p>
                </div>
                <div class="chat-message receiver-message">
                    <p class="message receiverMessage">I'm doing great, thanks!</p>
                </div>
            </div>
        </div>

        <div class="message-input">
            <form>
                <div class="form-group">
                    <textarea class="form-control" id="message" rows="3" placeholder="Type your message..."></textarea>
                </div>
                <button type="button" class="btn btn-primary my-2" id="send">Send</button>
            </form>
        </div>
    </div>
</div> --}}

{{-- <script>
    $("#send").click(function() {
        $.post("/chat/{{$receiver->id}}",
        {
            message: $("#message").val()
        },
        function(data, status){
            console.log("Data: " + data + "\nStatus: " + status);
            let senderMessage = '' +
            '<div class= "chat-message sender-message">'+
            '<div class="message chat ml-2 p-3">'+$("#message").val()+'</div></div>';
            $("#chat_area").append(senderMessage);
            $("#message").val("")
        })
    })
    Pusher.logToConsole = true;
    var pusher = new Pusher('ed836ac0a42d86eec82c', {
        cluster: 'ap2'
    });
    var channel = pusher.subscribe('chat{{auth()->user()->id}}');
    channel.bind('chatMessage', function(data) {
        let receiverMessage = '' +
        '<div class= "chat-message receiver-message">'+
            '<div class="message chat ml-2 p-3">'+data.message+'</div></div>';
            $("#chat_area").append(receiverMessage);
            $("#message").val("")
    });

</script> --}}

</body>
</html>
