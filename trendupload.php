<?php 
include('./classes/DB.php');
include('./classes/Login.php');
 include('./classes/notify.php');
  if (Login::isLoggedIn()) {
        $userid = Login::isLoggedIn();
} else {
         header("location: create-account.php");
}
$token = $_COOKIE['SNID'];
                $user_id = DB::query('SELECT user_id FROM login_token WHERE token=:token', array(':token'=>sha1($token)))[0]['user_id'];
                $username = DB::query('SELECT username FROM users WHERE id=:uid', array(':uid'=>$user_id))[0]['username'];
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kcappia</title>
    <link href='//localhost/kcappia./img/Kcappia.png' rel='icon' type='image/x-icon'/>
    <link rel="stylesheet" href="//localhost/kcappia/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="//localhost/kcappia/assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="//localhost/kcappia/assets/css/Footer-Dark.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.css">
    <link rel="stylesheet" href="//localhost/kcappia/assets/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="//localhost/kcappia/assets/css/Navigation-Clean1.css">
    <link rel="stylesheet" href="//localhost/kcappia/assets/css/styles.css">
    <link rel="stylesheet" href="//localhost/kcappia/assets/css/untitled.css">
</head>


<body>
<?php

  $msg = "";
if (isset($_POST['post'])) {
   
    $target = "trends/androidapps/".basename($_FILES['appfile']['name']);
    $name = $_POST['postbody'];
 $version = $_POST['appbody'];
$appfile = $_FILES['appfile']['name'];


$userid = Login::isLoggedIn();


$fileExt = explode('.', $appfile);
$fileActualExt = strtolower(end($fileExt));
$appallowed = array('apk');

if (in_array($fileActualExt, $appallowed)) {
    if ($appfile <= 5000000) {
        $AppNew = uniqid('', true) . '.' . $fileActualExt;
    } else {
      
    }
} else {
    die("You can not upload that app");
}
 $appupload = DB::query('INSERT INTO android VALUES (\'\', :name, :version, :appfile, \'\', NOW(), 0)', array(':name'=>$name, ':version'=>$version, ':appfile'=>$appfile));

 echo "Your App Has Been Shared To The World. Check it out on trends page!";
 header("location: trends.php");
 

    if (move_uploaded_file($_FILES['appfile']['tmp_name'], $target)) {
    $msg = "app uploaded successfully";
    } else {
        $msg = "there was a problem uploading your app";
    }
}
?>
    <header class="hidden-sm hidden-md hidden-lg">
            <form>

                <h1 class="text-left">Kcappia</h1>
                    <ul class="list-group autocomplete" style="position:absolute;width:100%; z-index: 100">
                    </ul>
                </div>
                <div class="dropdown">
                    <button class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button">MENU <span class="caret"></span></button>
                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        <li role="presentation"><a href="profile.php?username=<?php echo $username; ?>">My Profile</a></li>
                        <li class="divider" role="presentation"></li>
                        <li role="presentation"><a href="index.php">Home </a></li>
                        <li role="presentation"><a href="messages.php">Messages </a></li>
                        <li role="presentation"><a href="notifications.php">Notifications </a></li>
                        <li role="presentation"><a href="change-password.php">My Account</a></li>
                        <li role="presentation"><a href="logout.php">Logout </a></li>
                    </ul>
                   <ul class="nav navbar-nav hidden-xs hidden-sm navbar-right">
                        <li class="active" role="presentation"><a href="index.php">Home</a></li>
                        <li role="presentation"><a href="profile.php?username=<?php echo $username; ?>">Profile</a></li>
                        <li role="presentation"><a href="trends.php">Trends</a></li>
                        <li role="presentation"><a href="notifications.php">Notifications</a></li>
                        <li role="presentation"><a href="messages.php">Direct Chats</a></li>
                        <li role="presentation"><a href="search.php">Search</a></li>
                        <li role="presentation"><a href="installs.php">Installs</a></li> 
            </form>
        <hr>
    </header>
    <div>
        <nav class="navbar navbar-default hidden-xs navigation-clean">
            <div class="container">
               <div class="illustration"><i class=""><img src="//localhost/kcappia./img/photo.jpg"></i></div>
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
                                <li role="presentation"><a href="profile.php?username=<?php echo $username; ?>">My Profile</a></li>
                                <li class="divider" role="presentation"></li>
                                <li role="presentation"><a href="index.php">Home </a></li>
                                <li role="presentation"><a href="messages.php">Direct Chats </a></li>
                                <li role="presentation"><a href="notifications.php">Notifications </a></li>
                                <li role="presentation"><a href="account-settings.php">My Account</a></li>
                                <li role="presentation"><a href="search.php">Search</a></li>
                                <li role="presentation"><a href="logout.php">Logout </a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav hidden-xs hidden-sm navbar-right">
                        <li class="active" role="presentation"><a href="#"><b>Kcappia</b></a></li>
                        <li role="presentation"><a href="index.php">Home</a></li>
                        <li role="presentation"><a href="profile.php?username=<?php echo $username; ?>">Profile</a></li>
                        <li role="presentation"><a href="trends.php">Trends</a></li>
                        <li role="presentation"><a href="notifications.php">Notifications</a></li>
                        <li role="presentation"><a href="messages.php">Direct Chats</a></li>
                        <li role="presentation"><a href="search.php">Search</a></li>
                        <li role="presentation"><a href="installs.php">Installs</a></li>
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

<h2>Add Your Own App and get more Downloads!</h2>
<h2>Name</h2>
<form action="trendupload.php" method="post" enctype="multipart/form-data">
<p>Note: Please make sure the app you are uploading is yours otherwise it will be deleted!</p>
    <textarea name="postbody" rows="1" cols="35" placeholder="Name"></textarea><br />
    <h2>Version</h2>
    <textarea name="appbody" rows="1" cols="35" placeholder="Version"></textarea><br /><br /><br />
    <p>Kcappia trends only supports android files for now other os are coming soon!!</p>
    <h2>Android App File(apk)</h2>
    <input type="file" name="appfile"<button class="btn btn-default" type="button" style="background-image:url(&quot;none&quot;);background-color:#da052b;color:#fff;padding:16px 32px;margin:0px 0px 6px;border:none;box-shadow:none;text-shadow:none;opacity:0.9;text-transform:uppercase;font-weight:bold;font-size:13px;letter-spacing:0.4px;line-height:1;outline:none;" </button><br /><br /><br />

<input type="submit" name="post" value="Post" <button class="btn btn-default" type="button" style="background-image:url(&quot;none&quot;);background-color:#da052b;color:#fff;padding:16px 32px;margin:0px 0px 6px;border:none;box-shadow:none;text-shadow:none;opacity:0.9;text-transform:uppercase;font-weight:bold;font-size:13px;letter-spacing:0.4px;line-height:1;outline:none;" </button><br />
</form>
