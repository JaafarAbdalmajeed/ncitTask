<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <link rel="stylesheet" href="{{asset('assets/css/chat.css')}}">
    <title>Document</title>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

</head>
<body>
<div class="container app">
  <div class="row app-one">
    <div class="col-sm-4 side">
      <div class="side-one">
        <div class="row heading">
          <div class="col-sm-3 col-xs-3 heading-avatar">
            <p>{{auth()->user()->name}}</p>

            {{-- <div class="heading-avatar-icon">
              <img src="https://bootdey.com/img/Content/avatar/avatar1.png">

            </div> --}}

          </div>
          {{-- <div class="col-sm-1 col-xs-1  heading-dot  pull-right">
            <i class="fa fa-ellipsis-v fa-2x  pull-right" aria-hidden="true"></i>
          </div>
          <div class="col-sm-2 col-xs-2 heading-compose  pull-right">
            <i class="fa fa-comments fa-2x  pull-right" aria-hidden="true"></i>
          </div> --}}

        </div>

        {{-- <div class="row searchBox">
          <div class="col-sm-12 searchBox-inner">
            <div class="form-group has-feedback">
              <input id="searchText" type="text" class="form-control" name="searchText" placeholder="Search">
              <span class="glyphicon glyphicon-search form-control-feedback"></span>
            </div>
          </div>
        </div> --}}

        <div class="row sideBar">

        @foreach ($users as $user)
        <div class="row sideBar-body user" data-user-id="{{ $user->id }} " data-user-name="{{ $user->name }}">
            <div class="col-sm-3 col-xs-3 sideBar-avatar">
                <div class="avatar-icon">
                    <img src="https://bootdey.com/img/Content/avatar/avatar1.png">
                  </div>

            </div>
            <div class="col-sm-9 col-xs-9 sideBar-main ">
                <div class="row">
                    <div class="col-sm-8 col-xs-8 sideBar-name">
                        <span class="name-meta">{{ $user->name }}</span>
                    </div>
                    <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                        <!-- Display user's last activity time or status -->
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        </div>


      </div>

      <div class="side-two">
        <div class="row newMessage-heading">
          <div class="row newMessage-main">
            <div class="col-sm-2 col-xs-2 newMessage-back">
              <i class="fa fa-arrow-left" aria-hidden="true"></i>
            </div>
            <div class="col-sm-10 col-xs-10 newMessage-title">
              New Chat
            </div>
          </div>
        </div>

        <div class="row composeBox">
            <div class="col-sm-12 composeBox-inner">
              <div class="form-group has-feedback">
                <input id="composeText" type="text" class="form-control" name="searchText" placeholder="Search People">
                <span class="glyphicon glyphicon-search form-control-feedback"></span>
              </div>
            </div>
          </div>


      </div>
    </div>

    <div class="col-sm-8 conversation">
      <div class="row heading">
        <div class="col-sm-2 col-md-1 col-xs-3 heading-avatar">
          <div class="heading-avatar-icon">
            <img src="https://bootdey.com/img/Content/avatar/avatar6.png">
          </div>
        </div>
        <div class="col-sm-8 col-xs-7 heading-name">
            <span class="heading-name-meta" id="receiverName">
            </span>
            <span class="heading-online">Online</span>
        </div>
                <div class="col-sm-1 col-xs-1  heading-dot pull-right">
          <i class="fa fa-ellipsis-v fa-2x  pull-right" aria-hidden="true"></i>
        </div>
      </div>



      <div class="row message" id="conversation">
      </div>

      <div class="row reply">
        <div class="col-sm-1 col-xs-1 reply-emojis">
          <i class="fa fa-smile-o fa-2x"></i>
        </div>
        <div class="col-sm-9 col-xs-9 reply-main">
          <textarea class="form-control" rows="1" id="message"></textarea>

        </div>
        <div class="col-sm-1 col-xs-1 reply-recording">
          <i class="fa fa-microphone fa-2x" aria-hidden="true"></i>
        </div>
        <div class="col-sm-1 col-xs-1 reply-send" id="send">
          <i class="fa fa-send fa-2x" aria-hidden="true"></i>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="{{asset('assets/js/chat.js')}}"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>


<script>
        $(document).ready(function() {
            // Handle clicks on user elements
            let selectedStudentId = null;

            $('.user').click(function() {
                let userId = $(this).data('user-id');
                let userName = $(this).data('user-name');
                $('#receiverName').text('');
                $('#receiverName').append(userName);
                selectedStudentId = userId;
                retrieveMessages(userId);
            });

            function retrieveMessages(recipientId) {
                $('#receiverName').val('');

                $.ajax({
                    url: '/retrieve-messages/' + recipientId,
                    type: 'GET',
                    success: function(response) {
                        // Clear previous messages
                        $('#conversation').empty();

                        // Append new messages to the conversation
                        response.messages.forEach(function(message) {
                            var messageHtml = '';

                            // Determine the message sender
                            if (message.sender == {{ auth()->user()->id }}) {
                                // Message sent by the authenticated user
                                messageHtml = '<div class="row message-body">' +
                                                '<div class="col-sm-12 message-main-sender">' +
                                                    '<div class="sender">' +
                                                        '<div class="message-text">' + message.message + '</div>' +
                                                        '<span class="message-time pull-right">' + message.created_at + '</span>' +
                                                    '</div>' +
                                                '</div>' +
                                            '</div>';
                            } else {
                                // Message received from another user
                                messageHtml = '<div class="row message-body">' +
                                                '<div class="col-sm-12 message-main-receiver">' +
                                                    '<div class="receiver">' +
                                                        '<div class="message-text">' + message.message + '</div>' +
                                                        '<span class="message-time pull-right">' + message.created_at + '</span>' +
                                                    '</div>' +
                                                '</div>' +
                                            '</div>';
                            }
                            $('#conversation').append(messageHtml);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error retrieving messages:', error);
                    }
                });
            }

            $("#send").click(function() {
                // Get the message text
                let messageText = $("#message").val().trim(); // Remove leading and trailing spaces
                if (messageText !== "") {
                    personSender = {{auth()->user()->id}}
                    // Send the message to the receiver
                    $.post("/chat/" + selectedStudentId, {
                        message: messageText,
                        sender: personSender,
                    }, function(data, status) {
                        console.log("Data: " + data + "\nStatus: " + status);
                                            senderMessage = '<div class="row message-body">' +
                                                '<div class="col-sm-12 message-main-sender">' +
                                                    '<div class="sender">' +
                                                        '<div class="message-text">' + messageText + '</div>' +
                                                        // '<span class="message-time pull-right">' + message.created_at + '</span>' +
                                                    '</div>' +
                                                '</div>' +
                                            '</div>';

                        $("#conversation").append(senderMessage);
                        $("#message").val("");
                    });
                }
            });



            Pusher.logToConsole = true;

            var pusher = new Pusher('4bc6d3b0eecfbe72e4ee', {
            cluster: 'ap2'
            });

            var channel = pusher.subscribe('chat{{auth()->user()->id}}');
            channel.bind('chatMessage', function(data) {
                // alert(data.sender.id)
                // alert(selectedStudentId)
                // alert(data.sender.id == selectedStudentId)
                if( data.sender.id == selectedStudentId) {
                    messageHtml = '<div class="row message-body">' +
                                                '<div class="col-sm-12 message-main-receiver">' +
                                                    '<div class="receiver">' +
                                                        '<div class="message-text">' + data.message + '</div>' +
                                                        // '<span class="message-time pull-right">' + message.created_at + '</span>' +
                                                    '</div>' +
                                                '</div>' +
                                            '</div>';

                    $("#conversation").append(messageHtml);
                    $("#message").val("")
                }


            });
        });

</script>
</body>
</html>
