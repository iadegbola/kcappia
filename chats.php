<?php
include('./classes/DB.php');
include('./classes/Login.php');
if (Login::isLoggedIn()) {
        $userid = Login::isLoggedIn();
} else {
        die('Not logged in');
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kcappia</title>
    <link href='./img/Kcappia.png' rel='icon' type='image/x-icon'/>
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
                        <li role="presentation"><a href="home.html">Home </a></li>
                        <li role="presentation"><a href="senddirectchat.php">Messages </a></li>
                        <li role="presentation"><a href="notifications.php">Notifications </a></li>
                        <li role="presentation"><a href="change-pass.php">My Account</a></li>
                        <li role="presentation"><a href="logout.php">Logout </a></li>
                    </ul>
                   <ul class="nav navbar-nav hidden-xs hidden-sm navbar-right">
                        <li class="active" role="presentation"><a href="home.html">Home</a></li>
                        <li role="presentation"><a href="profile.php?username=<?php echo $username; ?>">Profile</a></li>
                        <li role="presentation"><a href="trends.php">Trends</a></li>
                        <li role="presentation"><a href="notifications.php">Notifications</a></li>
                        <li role="presentation"><a href="senddirectchat.php">Direct Chats</a></li>
                        <li role="presentation"><a href="search.php">Search</a></li>
                        <li role="presentation"><a href="installs.php">Installs</a></li> 
            </form>
        <hr>
    </header>
    <div>
        <nav class="navbar navbar-default hidden-xs navigation-clean">
            <div class="container">
                <div class="navbar-header"><a class="navbar-brand navbar-link" href="#"><i class="icon ion-ios-navigate"></i></a>
                    <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
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
                                <li role="presentation"><a href="profile.php">My Profile</a></li>
                                <li class="divider" role="presentation"></li>
                                <li role="presentation"><a href="home.html">Home </a></li>
                                <li role="presentation"><a href="senddirectchat.php">Messages </a></li>
                                <li role="presentation"><a href="notifications.php">Notifications </a></li>
                                <li role="presentation"><a href="change-pass.php">My Account</a></li>
                                <li role="presentation"><a href="logout.php">Logout </a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav hidden-xs hidden-sm navbar-right">
                        <li class="active" role="presentation"><a href="#"><b>Kcappia</b></a></li>
                        <li role="presentation"><a href="home.html">Home</a></li>
                        <li role="presentation"><a href="profile.php?username=<?php echo $username; ?>">Profile</a></li>
                        <li role="presentation"><a href="trends.php">Trends</a></li>
                        <li role="presentation"><a href="notifications.php">Notifications</a></li>
                        <li role="presentation"><a href="senddirectchat.php">Direct Chats</a></li>
                        <li role="presentation"><a href="search.php">Search</a></li>
                        <li role="presentation"><a href="installs.php">Installs</a></li>
                        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="#">Settings <span class="caret"></span></a>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li role="presentation"><a href="logout.php">Logout</a></li>
                                <li class="divider" role="presentation"></li>
                                <li role="presentation"><a href="account-settings.php">Account Settings </a></li>
                                <li role="presentation"><a href="feedback.html">Feedback </a></li>
                                <li role="presentation"><a href="aboutus.html">About Kcappia </a></li>
                                <li role="presentation"><a href="privacypolicy.html">Privacy Policy</a></li>
                                <li role="presentation"><a href="help.html">Help </a></li>
                                <li role="presentation"><a href="invitefreinds.php">Invite Friends </a></li>
                                <li role="presentation"><a href="termofuse.html">Term of Use </a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
<?php
if (isset($_GET['mid'])) {
        $messages = DB::query('SELECT * FROM messages WHERE id=:mid AND (receiver=:receiver OR sender=:sender)', array(':mid'=>$_GET['mid'], ':receiver'=>$userid, ':sender'=>$userid))[0];
        echo '<h1>View Message</h1>';
        echo htmlspecialchars($messages['body']);
        echo '<hr />';

        if ($messages['sender'] == $userid) {
                $id = $messages['receiver'];
        } else {
                $id = $messages['sender'];
        }
        DB::query('UPDATE messages SET `open`=1 WHERE id=:mid', array (':mid'=>$_GET['mid']));

        
    
        ?>
       
        <h1>Send a Direct Message</h1>
<form action="senddirectchat.php?receiver=<?php echo $id; ?>" method="post">
        <textarea name="body" rows="1" cols="40"></textarea>
        <input type="hidden" name="nocsrf" value="<?php echo $_SESSION['token']; ?>">
        <input type="submit" name="send" value="Send Message">
</form>
       <?php
} else {

?>
<h1>My Messages</h1>
<?php

$messages = DB::query('SELECT messages.*, users.username FROM messages, users WHERE receiver=:receiver OR sender=:sender AND users.id = messages.sender', array(':receiver'=>$followerid, ':sender'=>$userid));

foreach ($messages as $message) {

        if (strlen($message['body']) > 10) {
                $m = substr($message['body'], 0, 10)." ...";
        } else {
                $m = $message['body'];
        }

        if ($message['open'] == 0) {
                echo "<a href='chats.php?mid=".$message['id']."'><strong>".$m."</strong></a> sent by ".$message['username'].'<hr />';
        } else {
                echo "<a href='chats.php?mid=".$message['id']."'>".$m."</a> sent by ".$message['username'].'<hr />';
        }

}

}
?>

        <?php

        ?>

<!DOCTYPE html>
<html>
<body>

<p>Click the button to display a string as a hyperlink.</p>

<button onclick="myFunction()">Try it</button>

<p id="demo"></p>

<script>
function myFunction() {
    var str = "Free Web Building Tutorials!";
    var result = str.link("https://www.w3schools.com");
    document.getElementById("demo").innerHTML = result;
}
</script>

</body>
</html>


