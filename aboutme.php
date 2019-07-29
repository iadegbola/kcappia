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
    <link rel="stylesheet" href="assets/css/untitled.css">
</head>

<body>
    <header class="hidden-sm hidden-md hidden-lg">
            <form>

                <h1 class="text-left"><img src="./img/kc.png"></h1>
                    <ul class="list-group autocomplete" style="position:absolute;width:100%; z-index: 100">
                    </ul>
                </div>
               
            </form>
        <hr>
    </header>
    <div>
        
                    <div class="illustration"><i class=""><img src="./img/akcappia.png" style="float:middle;"></i></div><br>

 <?php 
include('./classes/DB.php');
include('./classes/Login.php');
 include('./classes/notify.php');
  if (Login::isLoggedIn()) {
        $userid = Login::isLoggedIn();
} else {
         header("location: create-account.php");
}

?>

<?php


if (isset($_POST['post'])) {
$postbody = $_POST['postbody'];
$userid = Login::isLoggedIn();



$aboutme = DB::query("UPDATE users SET aboutme=:post WHERE id=:userid", array(':post'=>$postbody, ':userid'=>$userid));
echo "<li class=list-group-item>Your profile about yourself has been updated!</li>"; 
header("location: firstpost.php");
}

$aboutwrite = DB::query('SELECT aboutme FROM users WHERE id=:userid;', array(':userid'=>$userid))[0]['aboutme'];
?>
<h2>Please describe yourself in a few words!</h2>

 <form action="aboutme.php" method="post">
 	<textarea name="postbody" rows="4" cols="38"><?php echo  $aboutwrite ?></textarea>
 	<input type="submit" name="post" value="Post" <button class="btn btn-default" type="button" style="background-image:url(&quot;none&quot;);background-color:#da052b;color:#fff;padding:16px 32px;margin:0px 0px 6px;border:none;box-shadow:none;text-shadow:none;opacity:0.9;text-transform:uppercase;font-weight:bold;font-size:13px;letter-spacing:0.4px;line-height:1;outline:none;" </button><br /><br><br>
 </form>
 <span style="margin-left: 20em;">
<a href="firstpost.php" class="btn btn-default">Skip</a>
</span>