<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login To Kcappia</title>
    <link href='./img/akcappia.png' rel='icon' type='image/x-icon'/>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>

<?php include('./classes/DB.php');

if (isset($_POST['login'])) {
$username = $_POST['username'];
$password = $_POST['password'];


if (DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$username))) {

if (password_verify($password, DB::query('SELECT password FROM users WHERE username=:username', array(':username'=>$username))[0]['password'])) {
    header("location: ./");
$cstrong = True;
$token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong)); 
$user_id = DB::query('SELECT id FROM users WHERE username=:username', array(':username'=>$username))[0]['id'];

DB::query('INSERT INTO login_token VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$user_id));

setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
setcookie("SNID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);
} else {
    echo '<li class="list-group-item">Incorrect Password!</li>';
}
   
} else {
   echo '<li class="list-group-item">User does not exist!</li>'; 
} 
}

?>

<h2><b>Log in To Your Account!</b></h2>
    <div class="login-clean">
        <form method="post">
            <h2 class="sr-only">Login Form</h2>
            <div class="illustration"><i class=""><img src="./img/akcappia.png"></i></div>
            <div class="form-group">
                <input class="form-control" type="text" id="username" name="username" placeholder="Username">
            </div>
            <div class="form-group">
                <input class="form-control" type="password" id="password" name="password" placeholder="Password">
            </div>
            <div class="form-group">
                <input type="submit" name="login" value="Login"<button class="btn btn-default" type="button" style="background-image:url(&quot;none&quot;);background-color:#da052b;color:#fff;padding:16px 32px;margin:0px 0px 6px;border:none;box-shadow:none;text-shadow:none;opacity:0.9;text-transform:uppercase;font-weight:bold;font-size:13px;letter-spacing:0.4px;line-height:1;outline:none;margin: 8px 40px;" </button>
            </div><a href="forgot-password.php" class="forgot">Forgot your password?</a></form>
            <footer>
            <div class="container">
                <p class="copyright">kcappia© 2018 <a href="aboutus.html">About Us</a> <a href="help.html">Help</a> <a href="feedback.php">Feedback</a> </p>
            </div>
        </footer>

                



                