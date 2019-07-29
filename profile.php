

   <!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
include('./classes/DB.php');
include('./classes/Login.php');
include('./classes/comment.php');
include('./classes/Post.php');
include('./classes/Notify.php');


if (!Login::isLoggedIn()) {


        header("location: create-account.php");            
}
 
$username = "";
$verified = False;
$isFollowing = False;
if (isset($_GET['username'])) {
        if (DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$_GET['username']))) {
$username = DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$_GET['username']))[0]['username'];
                $userid = DB::query('SELECT id FROM users WHERE username=:username', array(':username'=>$_GET['username']))[0]['id'];
                $verified = DB::query('SELECT verified FROM users WHERE username=:username', array(':username'=>$_GET['username']))[0]['verified'];
                $user_message = DB::query('SELECT id FROM users WHERE username=:username', array(':username'=>$_GET['username']))[0]['id'];
                $aboutme = DB::query('SELECT aboutme FROM users WHERE username=:username', array(':username'=>$_GET['username']))[0]['aboutme'];
                $operatingsystem = DB::query('SELECT operating_system FROM users WHERE username=:username', array(':username'=>$_GET['username']))[0]['operating_system'];
                $web = DB::query('SELECT website FROM users WHERE username=:username', array(':username'=>$_GET['username']))[0]['website'];
                $follower = DB::query('SELECT followers FROM users WHERE username=:username', array(':username'=>$_GET['username']))[0]['followers'];
                $following = DB::query('SELECT following FROM users WHERE username=:username', array(':username'=>$_GET['username']))[0]['following'];
                $followingapps = DB::query('SELECT appupload.id, appupload.postbody, appupload.image, appupload.operatingsystem, appupload.appbody, appupload.likes, users.`username` FROM appupload, users
                WHERE users.id = appupload.user_id
              AND users.id = :userid;', array(':userid'=>$userid));
foreach($followingapps as $appfile) {
                
                }
               $followerid = Login::isLoggedIn();

                if (isset($_POST['follow'])) {


                        if ($userid != $followerid) {

                                if (!DB::query('SELECT follower_id FROM followers WHERE user_id=:userid AND follower_id=:followerid', array(':userid'=>$userid, ':followerid'=>$followerid))) {
                                        if ($followerid == 2) {
                                                DB::query('UPDATE users SET verified=1 WHERE id=:userid', array(':userid'=>$userid));
                                        }
                                        DB::query('INSERT INTO followers VALUES (\'\', :userid, :followerid)', array(':userid'=>$userid, ':followerid'=>$followerid));
                                        DB::query('UPDATE users SET followers=followers+1 WHERE id=:userid', array(':userid'=>$userid));
                                        DB::query('UPDATE users SET following=following+1 WHERE id=:followerid', array(':followerid'=>$followerid));
                                          //Notify::createNotify("", $followerid);
                                        header("location: ./$username");
                                } else {
                                        //echo 'Already following!';
                                }
                                $isFollowing = True;
                        }
                }
                if (isset($_POST['unfollow'])) {

                        if ($userid != $followerid) {

                                if (DB::query('SELECT follower_id FROM followers WHERE user_id=:userid AND follower_id=:followerid', array(':userid'=>$userid, ':followerid'=>$followerid))) {
                                        if ($followerid == 2) {
                                                DB::query('UPDATE users SET verified=0 WHERE id=:userid', array(':userid'=>$userid));
                                        }
                                        DB::query('DELETE FROM followers WHERE user_id=:userid AND follower_id=:followerid', array(':userid'=>$userid, ':followerid'=>$followerid));
                                        DB::query('UPDATE users SET followers=followers-1 WHERE id=:userid', array(':userid'=>$userid));
                                        DB::query('UPDATE users SET following=following-1 WHERE id=:followerid', array(':followerid'=>$followerid));
                                        header("location: ./$username");
                                }
                                $isFollowing = False;
                        }
                }
                if (DB::query('SELECT follower_id FROM followers WHERE user_id=:userid AND follower_id=:followerid', array(':userid'=>$userid, ':followerid'=>$followerid))) {
                        //echo 'Already following!';
                        $isFollowing = True;
                }

                
                if (isset($_POST['deletepost'])) {
                        if (DB::query('SELECT id FROM posts WHERE id=:postid AND user_id=:userid', array(':postid'=>$_GET['postid'], ':userid'=>$followerid))) {
                                DB::query('DELETE FROM posts WHERE id=:postid and user_id=:userid', array(':postid'=>$_GET['postid'], ':userid'=>$followerid));
                                DB::query('DELETE FROM post_likes WHERE post_id=:postid', array(':postid'=>$_GET['postid']));
                                echo 'Post deleted!';
                        }
                }


                if (isset($_POST['post'])) {
                        if ($_FILES['upload']['size'] == 0) {
                                Post::createPost($_POST['postbody'], Login::isLoggedIn(), $userid);
                        } 
                        
                }
            

                if (isset($_GET['postid']) && !isset($_POST['deletepost'])) {
                        Post::likePost($_GET['postid'], $followerid);
                }
if (isset($_GET['imageid'])) {
        Post::likePostimg($_GET['imageid'], $userid);
}

if (isset($_GET['appid'])) {
        Post::likePostapp($_GET['appid'], $userid);
}
                $posts = Post::displayPosts($userid, $username, $followerid);
$image = Post::displayImg($userid, $username, $followerid);

        } else {
                header("location: ./");
        }
}
?>
    <title><?php echo $username; ?></title>
    <link href='./img/akcappia.png' rel='icon' type='image/x-icon'/>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/Footer-Dark.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="assets/css/Navigation-Clean1.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/untitled.css">
</head>

<body>
 

 
 <?php

 $getpic = DB::query('SELECT profileimg FROM users WHERE id=:uid', array(':uid'=>$userid))[0]['profileimg'];

  if ($getpic == "") {
  $picture = "img/profilepic.jpg";
  }
  else
  {

  $picture = "userdata/profile_pics/".$getpic;
  }

  if (isset($_POST['update'])) {
$usernameedit = $_POST['username'];
$os = $_POST['os'];
$website = $_POST['web'];
$aboutus = $_POST['bio'];


DB::query('UPDATE users SET username = :username, operating_system = :os, website = :web, aboutme = :bio WHERE id=:userid', array(':username'=>$usernameedit, ':os'=>$os, ':web'=>$website, ':bio'=>$aboutus, ':userid'=>$userid));
echo "Updated!"; 
header("location: ./$username");
}
//<a href="signup-verification.php"><img src="./img/default_pic.jpg" height="250" width="200"></a>
//<h2>username: <?php echo $username; ?> <?php //if ($verified) { echo ' - verified'; } ?><!--</h2>-->

<form action="./<?php echo $username; ?>" method="post">
</form><br />
   
  

    <header class="hidden-sm hidden-md hidden-lg">
            <form>

                <h1 class="text-left"><img src="./img/kc.png"></h1>
                    <ul class="list-group autocomplete" style="position:absolute;width:100%; z-index: 100">
                    </ul>
                </div>
                <div class="dropdown">
                    <button class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button">MENU <span class="caret"></span></button>
                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        <li role="presentation"><a href="./<?php echo $username; ?>">My Profile</a></li>
                        <li class="divider" role="presentation"></li>
                        <li role="presentation"><a href="./">Home </a></li>                  
                        <li role="presentation"><a href="messages.php">Messages </a></li>
                        <li role="presentation"><a href="search.php">Search </a></li>
                        <li role="presentation"><a href="trends.php">Trends </a></li>
                        <li role="presentation"><a href="notifications.php">Notifications </a></li>
                        <li role="presentation"><a href="settings.php">Settings </a></li>
                        
                    </ul>
                   <ul class="nav navbar-nav hidden-xs hidden-sm navbar-right">
                        <li class="active" role="presentation"><a href="./">Home</a></li>
                        <li role="presentation"><a href="./<?php echo $username; ?>">Profile</a></li>
                        <li role="presentation"><a href="trends.php">Trends</a></li>
                        <li role="presentation"><a href="notifications.php">Notifications</a></li>
                        <li role="presentation"><a href="messages.php">Direct Chats</a></li>
                        <li role="presentation"><a href="search.php">Search</a></li> 
            </form>
        <hr>
    </header>
    <div>
        <nav class="navbar navbar-default hidden-xs navigation-clean">
            <div class="container">
                <div class="illustration"><i class=""><img src="./img/akcappia.png"></i></div>
                </div>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <form class="navbar-form navbar-left">
                            <ul class="list-group autocomplete" style="position:absolute;width:100%; z-index:100">
                            </ul>
                    </form>
                    <ul class="nav navbar-nav hidden-md hidden-lg navbar-right">
                        <li role="presentation"><a href="#">My Timeline</a></li>
                        <li class="dropdown open"><a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true" href="#">User <span class="caret"></span></a>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li role="presentation"><a href="./<?php echo $username; ?>">My Profile</a></li>
                        <li class="divider" role="presentation"></li>
                        <li role="presentation"><a href="./">Home </a></li>                  
                        <li role="presentation"><a href="messages.php">Messages </a></li>
                        <li role="presentation"><a href="search.php">Search </a></li>
                        <li role="presentation"><a href="trends.php">Trends </a></li>
                        <li role="presentation"><a href="notifications.php">Notifications </a></li>
                        <li role="presentation"><a href="settings.php">Settings </a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav hidden-xs hidden-sm navbar-right">
                        <li class="active" role="presentation"><a href="./"><b>Kcappia</b></a></li>
                        <li role="presentation"><a href="./">Home</a></li>
                        <li role="presentation"><a href="./<?php echo $username; ?>">Profile</a></li>
                        <li role="presentation"><a href="trends.php">Trends</a></li>
                        <li role="presentation"><a href="notifications.php">Notifications</a></li>
                        <li role="presentation"><a href="messages.php">Direct Chats</a></li>
                        <li role="presentation"><a href="search.php">Search</a></li>
                        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="#">Settings <span class="caret"></span></a>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li role="presentation"><a href="logout.php">Logout</a></li>
                                <li class="divider" role="presentation"></li>
                                <li role="presentation"><a href="account-settings.php">Account Settings </a></li>
                                <li role="presentation"><a href="feedback.php">Feedback </a></li>
                                <li role="presentation"><a href="aboutus.html">About Kcappia </a></li>
                                <li role="presentation"><a href="privacypolicy.html">Privacy Policy</a></li>
                                <li role="presentation"><a href="help.html">Help </a></li>
                                <li role="presentation"><a href="invitefriends.php">Invite Friends </a></li>
                                <li role="presentation"><a href="termofuse.html">Term of Use </a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
   
 
    <div class="container"><br><br>
    <form action="./profileedit.php?username=<?php echo $username; ?>" method="post">

    <?php
                    if ($userid != $followerid) {
                       echo "<img class='img-circle1' src='" .$picture. "' width=200 height=200> <br>";  
                       echo " <h4> <b> $username  </b>  "; if ($verified) { echo '<i class="glyphicon glyphicon-ok-sign verified" data-toggle="tooltip" title="Verified User" style="font-size:28px;color:#da052b;"></i><br><br>'; }
                        echo " <h4><b> $operatingsystem </b> user</h4>";
                        echo " <h1></h1> <h4><a href=http://$web target=_blank <b> $web</b></h1></a></h4>";
                         } else {
                            
                             echo "<img class='img-circle1' src='" .$picture. "' width=200 height=200> <br>";  
                             
                       echo " <h1>   $username    "; if ($verified) { echo '<i class="glyphicon glyphicon-ok-sign verified" data-toggle="tooltip" title="Verified User" style="font-size:28px;color:#da052b;"></i><br><br>'; }
                       echo ' <input type="submit" name="Edit Profile" id="update" value="Edit Profile" style="padding: 0 8px;cursor: pointer;    background: 0 0;
    border-color: #dbdbdb;
    color: #262626;-webkit-appearance: none;
    border-radius: 3px;
    border-style: solid;
    border-width: 1px;
    font-size: 14px;
    font-weight: 600;
    line-height: 26px;
    outline: none;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    width: 100%;" </button>';
                        echo " <h4> <b> $operatingsystem </b> user</h4>";
                        echo " <h1></h1> <h4><a href=http://$web target=_blank <b> $web</b></h1></a></h4>";


                        }
                        ?>
                        
     

    

        
        
        
        </div>

        
    <div>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <ul class="list-group">
                    <?php
                    if ($userid != $followerid) {
                        echo " <li class=list-group-item><span><strong>About $username </strong></span>
                        <p>  $aboutme </p>";
                         } else {
                            echo " <li class=list-group-item><span><strong>About $username </strong></span>
                        <p>  $aboutme </p>";
                        }
                        
                        ?>
                            </form>
                                                
                        
                        
                        
                    </ul><br />
                    <form action="./<?php echo $username; ?>" method="post">
                    <?php 
                    if ($userid != $followerid) {
                      if ($isFollowing) {
 echo '<input type="submit" name="unfollow" value="Unfollow" id="100" <button class="btn btn-default" type="button" style="background-image:url(&quot;none&quot;);background-color:#da052b;color:#fff;padding:16px 32px;margin:0px 0px 6px;border:none;box-shadow:none;text-shadow:none;opacity:0.9;text-transform:uppercase;font-weight:bold;font-size:13px;letter-spacing:0.4px;line-height:1;outline:none;" </button><br />';
                      } else {

echo '<input type="submit" name="follow" value="Follow" id="100" <button class="btn btn-default" type="button" style="background-image:url(&quot;none&quot;);background-color:#da052b;color:#fff;padding:16px 32px;margin:0px 0px 6px;border:none;box-shadow:none;text-shadow:none;opacity:0.9;text-transform:uppercase;font-weight:bold;font-size:13px;letter-spacing:0.4px;line-height:1;outline:none;" </button><br />'; 
                      }
                          }
                      ?>
                    </form>


                </div>
                <form action="messages.php#<?php echo $user_message;?>" method="post">
                <?php
                if ($user_message != $followerid) {
                echo '<input type="submit" name="message" value="Message" <button class="btn btn-default" type="button" style="background-image:url(&quot;none&quot;);background-color:#da052b;color:#fff;padding:16px 32px;margin:0px 0px 6px;border:none;box-shadow:none;text-shadow:none;opacity:0.9;text-transform:uppercase;font-weight:bold;font-size:13px;letter-spacing:0.4px;line-height:1;outline:none;float:right;" </button><br />';
                }
                ?>
                </form>
                <div class="col-md-6" style="justify-content: space-around;
    border-top: 1px solid #efefef;
    padding: 12px 0;">
                <span style="font-size: 14px; text-align: center; width: 33.3%;align-items: center;"><strong>Followers </strong></span><br><span style="font-size: 14px; text-align: center; width: 33.3%;align-items: center;"><?php echo $follower;?></span><span style="margin-left: 15em;font-size: 14px; text-align: center; width: 33.3%;margin-right: 0; width: 33.4%;align-items: center;"><strong>Following</strong></span><br><span style="margin-left: 15.5em;font-size: 14px; text-align: center; width: 33.3%;margin-right: 0; width: 33.4%;align-items: center;"><?php echo $following;?></span><br>
                
                
                <br /><h3 style="border-top: 1px solid #efefef;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: horizontal;
    -webkit-box-direction: normal;
    -webkit-flex-direction: row;
    -ms-flex-direction: row;
    flex-direction: row;
    font-size: 20px;
    font-weight: 600;
    -webkit-box-pack: center;
    -webkit-justify-content: center;
    -ms-flex-pack: center;
    justify-content: center;
    letter-spacing: 1px;
    text-align: center;"><u><strong>Shared Stuffs</strong></u></h3><br /><br/>
                    <ul class="list-group">
                        <div class="timelineposts">
 
        </div>
        
                    </ul>
                </div>
                
                    <ul class="list-group"></ul>
                    </div>
            </div>
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
        <script src="assets/js/jquery.min.js"></script>
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
                                    url: "api/profileposts?username=<?php echo $username; ?>&start="+start,
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

                                                                    '<img class="img-circle1" src="<?php echo $picture; ?>" width="25" height="25"><strong>'+posts[index].PostedBy+'</strong><li class="list-group-item" id="'+posts[index].PostId+'"><blockquote><p>'+posts[index].PostBody+'</p><footer> <time class="timeago" title="'+posts[index].PostDate+'"></time><button class="btn btn-default" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;" data-id=\"'+posts[index].PostId+'\"> <i class="glyphicon glyphicon-heart" data-aos="flip-right"></i><span> '+posts[index].Likes+' Likes</span></button><button class="btn btn-default comment" data-postid=\"'+posts[index].PostId+'\" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;"><i class="glyphicon glyphicon-flash" style="color:#f9d616;"></i><span style="color:#f9d616;"> Comments</span></button></footer></blockquote></li><br>'
                                                            )

                                                           

                                                    } else {
                                                            $('.timelineposts').html(
                                                                    $('.timelineposts').html() +

                                                                    '<img class="img-circle1" src="<?php echo $picture; ?>" width="25" height="25"><strong>'+posts[index].PostedBy+'</strong><li class="list-group-item" id="'+posts[index].PostId+'"><blockquote><p>'+posts[index].PostBody+'</p><img src="" data-tempsrc="post/images/'+posts[index].PostImage+'" class="postimg" id="img'+posts[index].postId+'"><footer><time class="timeago" title="'+posts[index].PostDate+'"></time><button class="btn btn-default" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;" data-id=\"'+posts[index].PostId+'\"> <i class="glyphicon glyphicon-heart" data-aos="flip-right"></i><span> '+posts[index].Likes+' Likes</span></button><button class="btn btn-default comment" data-postid=\"'+posts[index].PostId+'\" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;"><i class="glyphicon glyphicon-flash" style="color:#f9d616;"></i><span style="color:#f9d616;"> Comments</span></button></footer></blockquote></li><br>'
                                                            )


                                                    }
                                                     } else {
                                                            $('.timelineposts').html(
                                                                    $('.timelineposts').html() +

                                                                    '<img class="img-circle1" src="<?php echo $picture; ?>" width="25" height="25"><strong>'+posts[index].PostedBy+'</strong><li class="list-group-item" id="'+posts[index].PostId+'"><blockquote><p>'+posts[index].PostBody+'</p><img src="" data-tempsrc="post/apps/images/'+posts[index].PostImage+'" class="postimg" id="img'+posts[index].postId+'"><footer>Operating System: '+posts[index].PostOperatingsystem+ ' , name: '+posts[index].PostAppbody+ ', <time class="timeago" title="'+posts[index].PostDate+'"></time><button class="btn btn-default" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;" data-id=\"'+posts[index].PostId+'\"> <i class="glyphicon glyphicon-heart" data-aos="flip-right"></i><span> '+posts[index].Likes+' Likes</span></button> <button id="myButton'+index+'" class="btn btn-default comment" data-aid=\"'+posts[index].PostId+'\" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;"><i class="d" style="color:#f9d1e5;"></i><span style="color:#6a6f75;"> Install</span></button><button class="btn btn-default comment" data-postid=\"'+posts[index].PostId+'\" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;"><i class="glyphicon glyphicon-flash" style="color:#f9d616;"></i><span style="color:#f9d616;"> Comments</span></button></footer></blockquote></li><br>'

                                                            )
                                                        }
                                                    
                                                    } else {
                                                            $('.timelineposts').html(
                                                                    $('.timelineposts').html() +

                                                                    '<img class="img-circle1" src="<?php echo $picture; ?>" width="25" height="25"><strong>'+posts[index].PostedBy+'</strong><li class="list-group-item" id="'+posts[index].PostId+'"><blockquote><p>'+posts[index].PostBody+'</p><video style="width: 100%;" controls loop="" poster="/img/photo.jpg"><source src="" data-tempsrc="post/Videos/'+posts[index].PostVideo+'" class="postimg" width="100%" id="img'+posts[index].PostId+'"> type="video/mp4" /></video><footer><time class="timeago" title="'+posts[index].PostDate+'"></time><button class="btn btn-default" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;" data-id=\"'+posts[index].PostId+'\"> <i class="glyphicon glyphicon-heart" data-aos="flip-right"></i><span> '+posts[index].Likes+' Likes</span></button><button class="btn btn-default comment" data-postid=\"'+posts[index].PostId+'\" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;"><i class="glyphicon glyphicon-flash" style="color:#f9d616;"></i><span style="color:#f9d616;"> Comments</span></button></footer></blockquote></li><br>'

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
                        url: "api/profileposts?username=<?php echo $username; ?>&start=0",
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

                                                                    '<img class="img-circle1" src="<?php echo $picture; ?>" width="25" height="25"><strong>'+posts[index].PostedBy+'</strong><li class="list-group-item" id="'+posts[index].PostId+'"><blockquote><p>'+posts[index].PostBody+'</p><footer><time class="timeago" title="'+posts[index].PostDate+'"></time><button class="btn btn-default" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;" data-id=\"'+posts[index].PostId+'\"> <i class="glyphicon glyphicon-heart" data-aos="flip-right"></i><span> '+posts[index].Likes+' Likes</span></button><button class="btn btn-default comment" data-postid=\"'+posts[index].PostId+'\" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;"><i class="glyphicon glyphicon-flash" style="color:#f9d616;"></i><span style="color:#f9d616;"> Comments</span></button></footer></blockquote></li><br>'
                                                            )

                                                           

                                                    } else {
                                                            $('.timelineposts').html(
                                                                    $('.timelineposts').html() +

                                                                    '<img class="img-circle1" src="<?php echo $picture; ?>" width="25" height="25"><strong>'+posts[index].PostedBy+'</strong><li class="list-group-item" id="'+posts[index].PostId+'"><blockquote><p>'+posts[index].PostBody+'</p><img src="" data-tempsrc="post/images/'+posts[index].PostImage+'" class="postimg" id="img'+posts[index].postId+'"><footer><time class="timeago" title="'+posts[index].PostDate+'"></time><button class="btn btn-default" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;" data-id=\"'+posts[index].PostId+'\"> <i class="glyphicon glyphicon-heart" data-aos="flip-right"></i><span> '+posts[index].Likes+' Likes</span></button><button class="btn btn-default comment" data-postid=\"'+posts[index].PostId+'\" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;"><i class="glyphicon glyphicon-flash" style="color:#f9d616;"></i><span style="color:#f9d616;"> Comments</span></button></footer></blockquote></li><br>'
                                                            )


                                                    }
                                                     } else {
                                                            $('.timelineposts').html(
                                                                    $('.timelineposts').html() +

                                                                    '<img class="img-circle1" src="<?php echo $picture; ?>" width="25" height="25"><strong>'+posts[index].PostedBy+'</strong><li class="list-group-item" id="'+posts[index].PostId+'"><blockquote><p>'+posts[index].PostBody+'</p><img src="" data-tempsrc="post/apps/images/'+posts[index].PostImage+'" class="postimg" id="img'+posts[index].postId+'"><footer>Operating System: '+posts[index].PostOperatingsystem+ ' , name: '+posts[index].PostAppbody+ ', <time class="timeago" title="'+posts[index].PostDate+'"></time><button class="btn btn-default" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;" data-id=\"'+posts[index].PostId+'\"> <i class="glyphicon glyphicon-heart" data-aos="flip-right"></i><span> '+posts[index].Likes+' Likes</span></button> <button id="myButton'+index+'" class="btn btn-default comment" data-aid=\"'+posts[index].PostId+'\" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;"><i class="d" style="color:#f9d1e5;"></i><span style="color:#6a6f75;"> Install</span></button><button class="btn btn-default comment" data-postid=\"'+posts[index].PostId+'\" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;"><i class="glyphicon glyphicon-flash" style="color:#f9d616;"></i><span style="color:#f9d616;"> Comments</span></button></footer></blockquote></li><br>'

                                                            )
                                                        }
                                                    
                                                    } else {
                                                            $('.timelineposts').html(
                                                                    $('.timelineposts').html() +

                                                                    '<img class="img-circle1" src="<?php echo $picture; ?>" width="25" height="25"><strong>'+posts[index].PostedBy+'</strong><li class="list-group-item" id="'+posts[index].PostId+'"><blockquote><p>'+posts[index].PostBody+'</p><video style="width: 100%;" controls loop="" poster="/img/photo.jpg"><source src="" data-tempsrc="post/Videos/'+posts[index].PostVideo+'" class="postimg" width="100%" id="img'+posts[index].PostId+'"> type="video/mp4" /></video><footer><time class="timeago" title="'+posts[index].PostDate+'"></time><button class="btn btn-default" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;" data-id=\"'+posts[index].PostId+'\"> <i class="glyphicon glyphicon-heart" data-aos="flip-right"></i><span> '+posts[index].Likes+' Likes</span></button><button class="btn btn-default comment" data-postid=\"'+posts[index].PostId+'\" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;"><i class="glyphicon glyphicon-flash" style="color:#f9d616;"></i><span style="color:#f9d616;"> Comments</span></button></footer></blockquote></li><br>'

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
