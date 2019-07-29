<?php 
include('./classes/header.php');

?>

    <div class="container">
    <li class=list-group-item><a href="myaccount.php"><h2>Please dear user update your profile info!CLICK HERE</h2></a></li>
        <h4>Share something about an app:</h4>
        <span style="margin-left: 0em;">
        <a href="news.php" class="btn btn-default"><b><h6>News</h6></b></a>
    </span>
    <span style="margin-left: 1.5em;">
        <a href="appsupload.php" class="btn btn-default"><b><h6>Apps</h6></b></a></span>
        <span style="margin-left: 1.5em;">
        <a href="videoupload.php" class="btn btn-default"><b><h6>Videos</h6></b></a></span>
        <span style="margin-left: 1.5em;">
        <a href="imageupload.php" class="btn btn-default"><b><h6>Images</h6></b></a>
    </span>
       
        <div class="timelineposts">
 
        </div>
    </div>

    <div class="modal fade" id="commentsmodal" role="dialog" tabindex="-1" style="padding-top:100px;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
                    <h4 class="modal-title">Comments</h4></div>
                <div class="modal-body" style="max-height: 400px; overflow-y: auto">
                    <p>The content of your modal.</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
   
    </div>
    
    </div>
    <h2><i>Follow your friends to see their shared stuffs and Like them!</i></h2>

    
    <script src="assets/js/jquery.min.js"></script>
    <script src="js/humanized_time_span.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-animation.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.js"></script>
    <script type="text/javascript">

        (function timeAgo(selector) {

    var templates = {
        prefix: "",
        suffix: " ago",
        seconds: "1 sec",
        minute: "1 min",
        minutes: "%d mins",
        hour: "1 hr",
        hours: " %d hrs",
        day: "1 day",
        days: "%d days",
        month: "about a month",
        months: "%d months",
        year: "1 yr",
        years: "%d yrs"
    };
    var template = function (t, n) {
        return templates[t] && templates[t].replace(/%d/i, Math.abs(Math.round(n)));
    };

    var timer = function (time) {
        if (!time) return;
        time = time.replace(/\.\d+/, ""); // remove milliseconds
        time = time.replace(/-/, "/").replace(/-/, "/");
        time = time.replace(/T/, " ").replace(/Z/, " UTC");
        time = time.replace(/([\+\-]\d\d)\:?(\d\d)/, " $1$2"); // -04:00 -> -0400
        time = new Date(time * 1000 || time);

        var now = new Date();
        var seconds = ((now.getTime() - time) * .001) >> 0;
        var minutes = seconds / 60;
        var hours = minutes / 60;
        var days = hours / 24;
        var years = days / 365;

        return templates.prefix + (
        seconds < 45 && template('seconds', seconds) || seconds < 90 && template('minute', 1) || minutes < 45 && template('minutes', minutes) || minutes < 90 && template('hour', 1) || hours < 24 && template('hours', hours) || hours < 42 && template('day', 1) || days < 30 && template('days', days) || days < 45 && template('month', 1) || days < 365 && template('months', days / 30) || years < 1.5 && template('year', 1) || template('years', years)) + templates.suffix;
    };

    var elements = document.getElementsByClassName('timeago');
    for (var i in elements) {
        var $this = elements[i];
        if (typeof $this === 'object') {
            $this.innerHTML = timer($this.getAttribute('title') || $this.getAttribute('datetime'));
        }
    }
    // update time every minute
    setTimeout(timeAgo, 100);

})();

        var start = 5;
    var working = false;
    $(window).scroll(function() {
            if ($(this).scrollTop() + 1 >= $('body').height() - $(window).height()) {
                    if (working == false) {
                            working = true;
                            $.ajax({

                                    type: "GET",
                                    url: "api/posts&start="+start,
                                    processData: false,
                                    contentType: "application/json",
                                    data: '',
                                    success: function(r) {
                                            var posts = JSON.parse(r)
                                            $.each(posts, function(index) {

                                                   if (posts[index].PostVideo == "") {
                                                if (posts[index].PostAppbody == "") {

                                                    if (posts[index].PostImage == "") {
                                                        

                                                            $('.timelineposts').html(
                                                                    $('.timelineposts').html() +

                                                                    ' <a href="./'+posts[index].PostedBy+'"><img class="img-circle1" src="userdata/profile_pics/'+posts[index].PostedPic+'" width="25" height="25"></a>  <strong><a href="./'+posts[index].PostedBy+'">'+posts[index].PostedBy+'</a></strong><li class="list-group-item" id="'+posts[index].PostId+'"><blockquote><p>'+posts[index].PostBody+'</p><footer> <time class="timeago" title="'+posts[index].PostDate+'"></time><button class="btn btn-default" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;" data-id=\"'+posts[index].PostId+'\"> <i class="glyphicon glyphicon-heart" data-aos="flip-right"></i><span> '+posts[index].Likes+' Likes</span></button><button class="btn btn-default comment" data-postid=\"'+posts[index].PostId+'\" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;"><i class="glyphicon glyphicon-flash" style="color:#f9d616;"></i><span style="color:#f9d616;"> Comments</span></button></footer></blockquote></li><br>'
                                                            )

                                                           

                                                    } else {
                                                            $('.timelineposts').html(
                                                                    $('.timelineposts').html() +

                                                                    ' <a href="./'+posts[index].PostedBy+'"><img class="img-circle1" src="userdata/profile_pics/'+posts[index].PostedPic+'" width="25" height="25"></a>  <strong><a href="./'+posts[index].PostedBy+'">'+posts[index].PostedBy+'</a></strong><li class="list-group-item" id="'+posts[index].PostId+'"><blockquote><p>'+posts[index].PostBody+'</p><img src="" data-tempsrc="post/images/'+posts[index].PostImage+'" class="postimg" id="img'+posts[index].postId+'"><footer> <time class="timeago" title="'+posts[index].PostDate+'"></time><button class="btn btn-default" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;" data-id=\"'+posts[index].PostId+'\"> <i class="glyphicon glyphicon-heart" data-aos="flip-right"></i><span> '+posts[index].Likes+' Likes</span></button><button class="btn btn-default comment" data-postid=\"'+posts[index].PostId+'\" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;"><i class="glyphicon glyphicon-flash" style="color:#f9d616;"></i><span style="color:#f9d616;"> Comments</span></button></footer></blockquote></li><br>'
                                                            )


                                                    }
                                                     } else {
                                                            $('.timelineposts').html(
                                                                    $('.timelineposts').html() +

                                                                    ' <a href="./'+posts[index].PostedBy+'"><img class="img-circle1" src="userdata/profile_pics/'+posts[index].PostedPic+'" width="25" height="25"></a>  <strong><a href="./'+posts[index].PostedBy+'">'+posts[index].PostedBy+'</a></strong><li class="list-group-item" id="'+posts[index].PostId+'"><blockquote><p>'+posts[index].PostBody+'</p><img src="" data-tempsrc="post/apps/images/'+posts[index].PostImage+'" class="postimg" id="img'+posts[index].postId+'"><footer>Operating System: '+posts[index].PostOperatingsystem+ ' , name: '+posts[index].PostAppbody+ ', <time class="timeago" title="'+posts[index].PostDate+'"></time><button class="btn btn-default" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;" data-id=\"'+posts[index].PostId+'\"> <i class="glyphicon glyphicon-heart" data-aos="flip-right"></i><span> '+posts[index].Likes+' Likes</span></button> <button id="myButton'+index+'" class="btn btn-default comment" data-aid=\"'+posts[index].PostId+'\" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;"><i class="d" style="color:#f9d1e5;"></i><span style="color:#6a6f75;"> Install</span></button><button class="btn btn-default comment" data-postid=\"'+posts[index].PostId+'\" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;"><i class="glyphicon glyphicon-flash" style="color:#f9d616;"></i><span style="color:#f9d616;"> Comments</span></button></footer></blockquote></li><br>'

                                                            )
                                                        }
                                                    
                                                    } else {
                                                            $('.timelineposts').html(
                                                                    $('.timelineposts').html() +

                                                                    ' <a href="./'+posts[index].PostedBy+'"><img class="img-circle1" src="userdata/profile_pics/'+posts[index].PostedPic+'" width="25" height="25"></a>  <strong><a href="./'+posts[index].PostedBy+'">'+posts[index].PostedBy+'</a></strong><li class="list-group-item" id="'+posts[index].PostId+'"><blockquote><p>'+posts[index].PostBody+'</p><video style="width: 100%;" controls loop="" poster="/img/photo.jpg"><source src="" data-tempsrc="post/Videos/'+posts[index].PostVideo+'" class="postimg" width="100%" id="img'+posts[index].PostId+'"> type="video/mp4" /></video><footer> <time class="timeago" title="'+posts[index].PostDate+'"></time><button class="btn btn-default" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;" data-id=\"'+posts[index].PostId+'\"> <i class="glyphicon glyphicon-heart" data-aos="flip-right"></i><span> '+posts[index].Likes+' Likes</span></button><button class="btn btn-default comment" data-postid=\"'+posts[index].PostId+'\" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;"><i class="glyphicon glyphicon-flash" style="color:#f9d616;"></i><span style="color:#f9d616;"> Comments</span></button></footer></blockquote></li><br>'

                                                            )
                                                        }
                                                         
                                                    
                                                    

                                                    $('[data-postid]').click(function() {
                                                            var buttonid = $(this).attr('data-postid');

                                                            

                                                            $.ajax({

                                                                    type: "GET",
                                                                    url: "api/comments?postid=" + $(this).attr('data-postid'),
                                                                    processData: false,
                                                                    contentType: "application/json",
                                                                    data: '',
                                                                    success: function(r) {
                                                                            var res = JSON.parse(r)
                                                                            showCommentsModal(res);
                                                                    },
                                                                    error: function(r) {
                                                                            console.log(r)
                                                                    }

                                                            });
                                                    });

                                                    $('[data-id]').click(function() {
                                                            var buttonid = $(this).attr('data-id');
                                                            $.ajax({

                                                                    type: "POST",
                                                                    url: "api/likes?id=" + $(this).attr('data-id'),
                                                                    processData: false,
                                                                    contentType: "application/json",
                                                                    data: '',
                                                                    success: function(r) {
                                                                            var res = JSON.parse(r)
                                                                            $("[data-id='"+buttonid+"']").html(' <i class="glyphicon glyphicon-heart" data-aos="flip-right"></i><span> '+res.Likes+' Likes</span>')
                                                                    },
                                                                    error: function(r) {
                                                                            console.log(r)
                                                                    }

                                                            });
                                                    })
                                            })

                                                 for (var i = 0; i < r.length; i++) {
                                                 $('#myButton'+i).click(function() {
                                                                
                                                         window.location = 'download.php?id=' + $(this).attr('data-aid')
                                                             
                                                       })
                                                     }


                                            $('.postimg').each(function() {
                                                    this.src=$(this).attr('data-tempsrc')
                                                    this.onload = function() {
                                                            this.style.opacity = '1';
                                                    }
                                            })

                                            scrollToAnchor(location.hash)

                                            start+=5;
                                            setTimeout(function() {
                                                    working = false;
                                            }, 4000)

                                    },
                                    error: function(r) {
                                            console.log(r)
                                    }

                            });
                    }
            }
    })


    function scrollToAnchor(aid){
    try {
    var aTag = $(aid);
        $('html,body').animate({scrollTop: aTag.offset().top},'slow');
        } catch (error) {
                console.log(error)
        }
    }


        $(document).ready(function() {



                $.ajax({

                        type: "GET",
                        url: "api/posts&start=0",
                        processData: false,
                        contentType: "application/json",
                        data: '',
                        success: function(r) {
                                var posts = JSON.parse(r)
                                            $.each(posts, function(index) {
                                                if (posts[index].PostVideo == "") {
                                                if (posts[index].PostAppbody == "") {

                                                    if (posts[index].PostImage == "") {
                                                        

                                                            $('.timelineposts').html(
                                                                    $('.timelineposts').html() +

                       ' <a href="./'+posts[index].PostedBy+'"><img class="img-circle1" src="userdata/profile_pics/'+posts[index].PostedPic+'" width="25" height="25"></a>  <strong><a href="./'+posts[index].PostedBy+'">'+posts[index].PostedBy+'</a></strong><li class="list-group-item" id="'+posts[index].PostId+'"><blockquote><p>'+posts[index].PostBody+'</p><footer> <time class="timeago" title="'+posts[index].PostDate+'"></time><button class="btn btn-default" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;" data-id=\"'+posts[index].PostId+'\"> <i class="glyphicon glyphicon-heart" data-aos="flip-right"></i><span> '+posts[index].Likes+' Likes</span></button><button class="btn btn-default comment" data-postid=\"'+posts[index].PostId+'\" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;"><i class="glyphicon glyphicon-flash" style="color:#f9d616;"></i><span style="color:#f9d616;"> Comments</span></button></footer></blockquote></li><br>'
                                                            )

                                                           

                                                    } else {
                                                            $('.timelineposts').html(
                                                                    $('.timelineposts').html() +

                                                                    ' <a href="./'+posts[index].PostedBy+'"><img class="img-circle1" src="userdata/profile_pics/'+posts[index].PostedPic+'" width="25" height="25"></a>  <strong><a href="./'+posts[index].PostedBy+'">'+posts[index].PostedBy+'</a></strong><li class="list-group-item" id="'+posts[index].PostId+'"><blockquote><p>'+posts[index].PostBody+'</p><img src="" data-tempsrc="post/images/'+posts[index].PostImage+'" class="postimg" id="img'+posts[index].postId+'"><footer> <time class="timeago" title="'+posts[index].PostDate+'"></time><button class="btn btn-default" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;" data-id=\"'+posts[index].PostId+'\"> <i class="glyphicon glyphicon-heart" data-aos="flip-right"></i><span> '+posts[index].Likes+' Likes</span></button><button class="btn btn-default comment" data-postid=\"'+posts[index].PostId+'\" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;"><i class="glyphicon glyphicon-flash" style="color:#f9d616;"></i><span style="color:#f9d616;"> Comments</span></button></footer></blockquote></li><br>'
                                                            )


                                                    }
                                                     } else {
                                                            $('.timelineposts').html(
                                                                    $('.timelineposts').html() +

                                                                    ' <a href="./'+posts[index].PostedBy+'"><img class="img-circle1" src="userdata/profile_pics/'+posts[index].PostedPic+'" width="25" height="25"></a>  <strong><a href="./'+posts[index].PostedBy+'">'+posts[index].PostedBy+'</a></strong><li class="list-group-item" id="'+posts[index].PostId+'"><blockquote><p>'+posts[index].PostBody+'</p><img src="" data-tempsrc="post/apps/images/'+posts[index].PostImage+'" class="postimg" id="img'+posts[index].postId+'"><footer>Operating System: '+posts[index].PostOperatingsystem+ ' , name: '+posts[index].PostAppbody+ ', <time class="timeago" title="'+posts[index].PostDate+'"></time><button class="btn btn-default" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;" data-id=\"'+posts[index].PostId+'\"> <i class="glyphicon glyphicon-heart" data-aos="flip-right"></i><span> '+posts[index].Likes+' Likes</span></button> <button id="myButton'+index+'" class="btn btn-default comment" data-aid=\"'+posts[index].PostId+'\" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;"><i class="d" style="color:#f9d1e5;"></i><span style="color:#6a6f75;"> Install</span></button><button class="btn btn-default comment" data-postid=\"'+posts[index].PostId+'\" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;"><i class="glyphicon glyphicon-flash" style="color:#f9d616;"></i><span style="color:#f9d616;"> Comments</span></button></footer></blockquote></li><br>'

                                                            )
                                                        }
                                                    
                                                    } else {
                                                            $('.timelineposts').html(
                                                                    $('.timelineposts').html() +

                                                                    ' <a href="./'+posts[index].PostedBy+'"><img class="img-circle1" src="userdata/profile_pics/'+posts[index].PostedPic+'" width="25" height="25"></a>  <strong><a href="./'+posts[index].PostedBy+'">'+posts[index].PostedBy+'</a></strong><li class="list-group-item" id="'+posts[index].PostId+'"><blockquote><p>'+posts[index].PostBody+'</p><video style="width: 100%;" controls loop="" poster="/img/photo.jpg"><source src="" data-tempsrc="post/Videos/'+posts[index].PostVideo+'" class="postimg" width="100%" id="img'+posts[index].PostId+'"> type="video/mp4" /></video><footer> <time class="timeago" title="'+posts[index].PostDate+'"></time><button class="btn btn-default" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;" data-id=\"'+posts[index].PostId+'\"> <i class="glyphicon glyphicon-heart" data-aos="flip-right"></i><span> '+posts[index].Likes+' Likes</span></button><button class="btn btn-default comment" data-postid=\"'+posts[index].PostId+'\" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;"><i class="glyphicon glyphicon-flash" style="color:#f9d616;"></i><span style="color:#f9d616;"> Comments</span></button></footer></blockquote></li><br>'

                                                            )
                                                        }

                                                    
                                         
                                        $('[data-postid]').click(function() {
                                                var buttonid = $(this).attr('data-postid');

                                                $.ajax({

                                                        type: "GET",
                                                        url: "api/comments?postid=" + $(this).attr('data-postid'),
                                                        processData: false,
                                                        contentType: "application/json",
                                                        data: '',
                                                        success: function(r) {
                                                                var res = JSON.parse(r)
                                                                showCommentsModal(res);
                                                        },
                                                        error: function(r) {
                                                                console.log(r)
                                                        }

                                                });
                                        });

                                        $('[data-id]').click(function() {
                                                var buttonid = $(this).attr('data-id');
                                                $.ajax({

                                                        type: "POST",
                                                        url: "api/likes?id=" + $(this).attr('data-id'),
                                                        processData: false,
                                                        contentType: "application/json",
                                                        data: '',
                                                        success: function(r) {
                                                                var res = JSON.parse(r)
                                                                $("[data-id='"+buttonid+"']").html(' <i class="glyphicon glyphicon-heart" data-aos="flip-right"></i><span> '+res.Likes+' Likes</span>')
                                                        },
                                                        error: function(r) {
                                                                console.log(r)
                                                        }

                                                });
                                        })
                                })

for (var i = 0; i < r.length; i++) {
 $('#myButton'+i).click(function() {
                                                                
                                                         window.location = 'download.php?id=' + $(this).attr('data-aid')
                                                             
                                                       })
}

                                $('.postimg').each(function() {
                                        this.src=$(this).attr('data-tempsrc')
                                        this.onload = function() {
                                                this.style.opacity = '1';
                                        }
                                })

                                scrollToAnchor(location.hash)

                        },
                        error: function(r) {
                                console.log(r)
                        }

                });

        });

        

        function showCommentsModal(res) {
                $('#commentsmodal').modal('show')
                var output = "";
                for (var i = 0; i < res.length; i++) {
                        output += res[i].Comment;
                        output += " ~ ";
                        output += res[i].CommentedBy;
                        output += "<hr />";
                }

                $('.modal-body').html(output)
        }

 
   
    
    </script>     
</body>

</html>
