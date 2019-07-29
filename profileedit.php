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
    <title>Edit Profile</title>
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
    	<form style="-webkit-box-align: stretch;
    -webkit-align-items: stretch;
    -ms-flex-align: stretch;
    align-items: stretch;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -webkit-flex-direction: column;
    -ms-flex-direction: column;
    flex-direction: column;
    margin-bottom: 16px;
    margin-top: 32px;" action="./<?php echo $username; ?>" method="post">
    	<?php
if ($userid != $followerid) {

} else {
echo "<p><b>UPDATE YOUR PROFILE INFO:</b></p>";
echo "<a href=myaccountprofile.php><img class='img-circle1' src='" .$picture. "' width=200 height=200></a><br>";
echo "<a href=myaccountprofile.php>Change Picture</a><br>";
                             
echo " <b>Username: <input type=text style='background: 0 0;
    border: 1px solid #efefef;
    border-radius: 3px;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    color: #262626;
    -webkit-box-flex: 0;
    -webkit-flex: 0 1 355px;
    -ms-flex: 0 1 355px;
    flex: 0 1 355px;
    font-size: 16px;
    height: 32px;
    padding: 0 10px;' name=username id=username size=20 value= $username ></b>"; if ($verified) { echo '<i class="glyphicon glyphicon-ok-sign verified" data-toggle="tooltip" title="Verified User" style="font-size:28px;color:#da052b;"></i><br>'; }
echo "<br><b>Your operatingsystem: <select name=os style='background: 0 0;
    border: 1px solid #efefef;
    border-radius: 3px;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    color: #262626;
    -webkit-box-flex: 0;
    -webkit-flex: 0 1 355px;
    -ms-flex: 0 1 355px;
    flex: 0 1 355px;
    font-size: 16px;
    height: 32px;
    padding: 0 10px;'>
<option value= $operatingsystem>$operatingsystem</option>
  <option value=All>All</option>
<option value=Android>Android</option>
 <option value=IOS>IOS</option>
<option value=WindowsMobile>WindowsMobile</option>
<option value=WindowsPC>Windows</option>
<option value=Blackberry>Blackberry</option>
</select><br><br>
<b>Website: <input type=text  style='background: 0 0;
    border: 1px solid #efefef;
    border-radius: 3px;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    color: #262626;
    -webkit-box-flex: 0;
    -webkit-flex: 0 1 355px;
    -ms-flex: 0 1 355px;
    flex: 0 1 355px;
    font-size: 16px;
    height: 32px;
    padding: 0 10px;' name=web id=web size=40 value= $web></b><br /><br>";

echo '<div style="webkit-flex-basis: auto;
    -ms-flex-preferred-size: auto;
    flex-basis: auto;
    -webkit-box-orient: horizontal;
    -webkit-box-direction: normal;
    -webkit-flex-direction: row;
    -ms-flex-direction: row;
    flex-direction: row;
    padding: 0 20px;color: #262626;
    -webkit-box-flex: 1;
    -webkit-flex-grow: 1;
    -ms-flex-positive: 1;
    flex-grow: 1;
    font-size: 16px;
    -webkit-box-pack: start;
    -webkit-justify-content: flex-start;
    -ms-flex-pack: start;
    justify-content: flex-start;"><span><strong>About</strong></span>';
                          echo "<p><textarea name=bio style='background: 0 0;
    border: 1px solid #efefef;
    border-radius: 3px;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    color: #262626;
    -webkit-box-flex: 0;
    -webkit-flex: 0 1 355px;
    -ms-flex: 0 1 355px;
    flex: 0 1 355px;
    font-size: 16px;
    height: 32px;
    padding: 0 10px;' id=bio rows=50 cols=50> $aboutme</textarea></p></div>
<br>"; 
                          echo ' <input type="submit" name="update" id="update" value="Update" button class="btn btn-default" type="button" style="background-image:url(&quot;none&quot;);background-color:#da052b;color:#fff;padding:16px 32px;margin:0px 0px 6px;border:none;box-shadow:none;text-shadow:none;opacity:0.9;text-transform:uppercase;font-weight:bold;font-size:13px;letter-spacing:0.4px;line-height:1;outline:none;" </button>';
}


    	 ?>
    	</form>