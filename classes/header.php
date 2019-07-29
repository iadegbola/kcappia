<?php
include('./classes/DB.php');
include('./classes/Login.php');
 include('./classes/Notify.php');
 
  if (Login::isLoggedIn()) {
        $userid = Login::isLoggedIn();
} else {
        header("location: create-account.php");
}


$token = $_COOKIE['SNID'];
                $user_id = DB::query('SELECT user_id FROM login_token WHERE token=:token', array(':token'=>sha1($token)))[0]['user_id'];
                $username = DB::query('SELECT username FROM users WHERE id=:uid', array(':uid'=>$user_id))[0]['username'];
            $followingapps = DB::query('SELECT * FROM appupload WHERE user_id=:userid', array(':userid'=>$userid));
$apps = "";


     $getpic = DB::query('SELECT profileimg FROM users WHERE id=:uid', array(':uid'=>$user_id))[0]['profileimg'];

  if ($getpic == "") {
  $picture = "img/profilepic.jpg";
  }
  else
  {

  $picture = "userdata/profile_pics/".$getpic;
  }
                ?>
            
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kcappia</title>
    <link href='./img/akcappia.png' rel='icon' type='image/x-icon'/>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/Footer-Dark.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="assets/css/Navigation-Clean1.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/styles1.css">
    <link rel="stylesheet" href="assets/css/untitled.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
</head>

<body>
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
                        <li role="presentation"><a href="./">Kcappia</a></li>
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