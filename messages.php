<?php 
include('./classes/header.php');
?>
    <div class="container">
        <h1>My Messages</h1></div>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <ul class="list-group" id="users">
                    </ul>
                </div>
                <div class="col-md-9" style="position:relative;">
                    <ul class="list-group">
                        <li class="list-group-item" id="m" style="overflow:auto;height:500px;margin-bottom:55px;">
                        </li>
                    </ul>
                    <button class="btn btn-default msg-button-send" id="sendmessage" value="Post" name="post" type="submit">SEND </button>
                    <div class="message-input-div">
                        <input id="messagecontent" type="text" style="width:100%;height:45px;outline:none;font-size:16px;">
                    </div>
                </div>
                        
    
            </div>
        </div>
    </div>
    
    
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-animation.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.js"></script>
    <script type="text/javascript">
        function update() {
 
                            $.ajax({

                    type: "GET",
                    url: "api/messages?sender="+SENDER,
                    processData: false,
                    contentType: "application/json",
                    data: '',
                    success: function(r) {
                            r = JSON.parse(r)
                        }
})
       }
             




    
    SENDER = window.location.hash.split('#')[1];
    USERNAME = "";
    function getUsername() {
            $.ajax({

                    type: "GET",
                    url: "api/users",
                    processData: false,
                    contentType: "application/json",
                    data: '',
                    success: function(r) {
                            USERNAME = r;
                    }
            })
    }

    $(document).ready(function() {

            $(window).on('hashchange', function() {
                    location.reload()
            })

            $('#sendmessage').click(function() {
                    $.ajax({

                            type: "POST",
                            url: "api/message",
                            processData: false,
                            contentType: "application/json",
                            data: '{ "body": "'+ $("#messagecontent").val() +'", "receiver": "'+ SENDER +'" }',
                            success: function(r) {
                                    location.reload()
                            },
                            error: function(r) {

                            }
                    })
            })

            $.ajax({

                    type: "GET",
                    url: "api/musers",
                    processData: false,
                    contentType: "application/json",
                    data: '',
                    success: function(r) {
                            r = JSON.parse(r)
                            for (var i = 0; i < r.length; i++) {
                                    $('#users').append('<li id="user'+i+'" data-id='+r[i].id+' class="list-group-item" style="background-color:#FFF;"><span style="font-size:16px;"><img class="img-circle" src="userdata/profile_pics/'+r[i].profileimg+'" style="width:20px;margin-right:5px;"><strong>'+r[i].username+'</strong></span></li>')
                                    $('#user'+i).click(function() {
                                            window.location = 'messages.php#' + $(this).attr('data-id')
                                    })
                            }
                    }
            })
           
           

            $.ajax({

                    type: "GET",
                    url: "api/messages?sender="+SENDER,
                    processData: false,
                    contentType: "application/json",
                    data: '',
                    success: function(r) {
                            r = JSON.parse(r)
                            $.ajax({

                                    type: "GET",
                                    url: "api/users",
                                    processData: false,
                                    contentType: "application/json",
                                    data: '',
                                    success: function(u) {
                                            USERNAME = u;
                                            for (var i = 0; i < r.length; i++) {
                                                    if (r[i].Sender == USERNAME) {
                                                            $('#m').append('<div class="message-from-me message"><p style="color:#FFF;padding:10px;">'+r[i].body+'</p></div><div class="message-spacer message"><p>'+r[i].body+'</p>sent by'+r[i].username+'</div>')
                                                    } else {
                                                            $('#m').append('<div class="message-from-other message"><p style="color:#738;padding:10px;">'+r[i].body+'</p></div><div class="message-spacer message"><p>'+r[i].body+'</p>sent by '+r[i].username+'</div>')
                                                    }
                                            }
                                    }
                            })
                    },
                    error: function(r) {
                            console.log(r)
                    }
             })
    })
setInterval(function(){ update() }, 2500);
    </script>
</body>

</html>
