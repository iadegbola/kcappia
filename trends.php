<?php 
include('./classes/header.php');
?>


                    
                    <h1 style="color: orange; text-align: center;"><u><i>Trending Apps</i></u></h1><br>
                    <li class=list-group-item></li>
                    <div class="timelineposts">
 
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

        <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-animation.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.js"></script>
    <script type="text/javascript">

        (function timeAgo(selector) {

    var templates = {
        prefix: "",
        suffix: " ago",
        seconds: "less than a minute",
        minute: "about a minute",
        minutes: "%d minutes",
        hour: "about an hour",
        hours: "about %d hours",
        day: "a day",
        days: "%d days",
        month: "about a month",
        months: "%d months",
        year: "about a year",
        years: "%d years"
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

        var start = 10;
    var working = false;
    $(window).scroll(function() {
            if ($(this).scrollTop() + 1 >= $('body').height() - $(window).height()) {
                    if (working == false) {
                            working = true;
                            $.ajax({

                                    type: "GET",
                                    url: "api/trendandroidapps&start="+start,
                                    processData: false,
                                    contentType: "application/json",
                                    data: '',
                                    success: function(r) {
                                            var apps = JSON.parse(r)
                                            $.each(apps, function(index) {
                                                if (apps[index].PostAppbody == "") {

                                                }

                                                   else {
                                                            $('.timelineposts').html(
                                                                    $('.timelineposts').html() +

                                                                   ' <a href="./'+apps[index].PostedBy+'"><img class="img-circle1" src="userdata/profile_pics/'+apps[index].PostedPic+'" width="25" height="25"></a>  <strong><a href="./'+apps[index].PostedBy+'">'+apps[index].PostedBy+'</a></strong><li class="list-group-item" id="'+apps[index].PostId+'"><blockquote><p>'+apps[index].PostBody+'</p><img src="" data-tempsrc="post/apps/images/'+apps[index].PostImage+'" class="postimg" id="img'+apps[index].PostId+'"><footer>Operating System: '+apps[index].PostOperatingsystem+ ' , name: '+apps[index].PostAppbody+ ', <time class="timeago" title="'+apps[index].PostDate+'"></time><button class="btn btn-default" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;" data-id=\"'+apps[index].PostId+'\"> <i class="glyphicon glyphicon-heart" data-aos="flip-right"></i><span> '+apps[index].Likes+' Likes</span></button> <button id="myButton'+index+'" class="btn btn-default comment" data-aid=\"'+apps[index].PostId+'\" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;"><i class="d" style="color:#f9d1e5;"></i><span style="color:#6a6f75;"> Install</span></button><button class="btn btn-default comment" data-postid=\"'+apps[index].PostId+'\" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;"><i class="glyphicon glyphicon-flash" style="color:#f9d616;"></i><span style="color:#f9d616;"> Comments</span></button></footer></blockquote></li><br>'
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
                        url: "api/trendandroidapps&start=0",
                        processData: false,
                        contentType: "application/json",
                        data: '',
                        success: function(r) {
                                var apps = JSON.parse(r)
                                            $.each(apps, function(index) {
                                                if (apps[index].PostAppbody == "") {

                                                }

                                                   else {
                                                 
                                                            $('.timelineposts').html(
                                                                    $('.timelineposts').html() +

                                                                    ' <a href="./'+apps[index].PostedBy+'"><img class="img-circle1" src="userdata/profile_pics/'+apps[index].PostedPic+'" width="25" height="25"></a>  <strong><a href="./'+apps[index].PostedBy+'">'+apps[index].PostedBy+'</a></strong><li class="list-group-item" id="'+apps[index].PostId+'"><blockquote><p>'+apps[index].PostBody+'</p><img src="" data-tempsrc="post/apps/images/'+apps[index].PostImage+'" class="postimg" id="img'+apps[index].PostId+'"><footer>Operating System: '+apps[index].PostOperatingsystem+ ' , name: '+apps[index].PostAppbody+ ', <time class="timeago" title="'+apps[index].PostDate+'"></time><button class="btn btn-default" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;" data-id=\"'+apps[index].PostId+'\"> <i class="glyphicon glyphicon-heart" data-aos="flip-right"></i><span> '+apps[index].Likes+' Likes</span></button> <button id="myButton'+index+'" class="btn btn-default comment" data-aid=\"'+apps[index].PostId+'\" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;"><i class="d" style="color:#f9d1e5;"></i><span style="color:#6a6f75;"> Install</span></button><button class="btn btn-default comment" data-postid=\"'+apps[index].PostId+'\" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;"><i class="glyphicon glyphicon-flash" style="color:#f9d616;"></i><span style="color:#f9d616;"> Comments</span></button></footer></blockquote></li><br>'

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
