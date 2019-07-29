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
if (Login::isLoggedIn()) {
        $userid = Login::isLoggedIn();
} else {
        header("location: create-account.php");
}


if(isset($_POST['submit'])) {
	$operating_system = $_POST['operating_system'];

  
$operating_system = DB::query("UPDATE users SET operating_system=:operating_system WHERE id=:userid", array(':operating_system'=>$operating_system, ':userid'=>$userid));
echo "<li class=list-group-item>Your prefered operatingsystem has been successfully changed!</li>";
header("location: myaccountwebsite.php");
    }
?>
<form action="myaccountos.php" method="post">
<h2>Your preferred Operating system:</h2>
<br><br><br><br><br><select name="operating_system" class=btn btn-default>
  <option value="All">All</option>
<option value="Android">Android</option>
 <option value="IOS">IOS</option>
<option value="Windows Mobile">Windows Mobile</option>
<option value="Windows PC">Windows</option>
<option value="Blackberry">Blackberry</option>
</select><br /><br /><br />
<input type="submit" name="submit" value="Submit" <button class="btn btn-default" type="button" style="background-image:url(&quot;none&quot;);background-color:#da052b;color:#fff;padding:16px 32px;margin:0px 0px 6px;border:none;box-shadow:none;text-shadow:none;opacity:0.9;text-transform:uppercase;font-weight:bold;font-size:13px;letter-spacing:0.4px;line-height:1;outline:none;" </button>
</form>
<span style="margin-left: 20em;">
<a href="myaccountwebsite.php" class="btn btn-default">Skip</a>
</span>

   
