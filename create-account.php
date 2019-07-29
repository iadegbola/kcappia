  <!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create an Account!</title>
    <link href='./img/akcappia.png' rel='icon' type='image/x-icon'/>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
<?php
include('./classes/DB.php');
include ('./classes/mail.php');
require_once('./api/PHPMailer/PHPMailerAutoload.php');

 ?>
<?php




 ?>

<?php

               

if (isset($_POST['createaccount'])) {
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];

if (!DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$username))) {
  if (strlen($username) >= 3 && strlen($username) <= 32) {
if (preg_match('/[a-zA-Z0-9_]+/', $username)) {

   if (strlen($password) >= 6 && strlen($password) <= 60) {
$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';


if(preg_match($email_exp,$email)) {
  if (!DB::query('SELECT email FROM users WHERE email=:email', array(':email'=>$email))) {


       DB::query('INSERT INTO users VALUES (\'\', :username, :password, :email, \'0\', \'profilepic.jpg\', \'\', \'\', \'\', \'\', \'\')', array(':username'=>$username, ':email'=>$email, ':password'=>password_hash($password, PASSWORD_BCRYPT)));
       header("refresh: 1; myaccount.php");
       Mail::sendmail('Welcome to Kcappia', 'now you can start sharing the things you have always imagined <a href="https://goo.gl/LrmtDS/login.php">login</a> now to begin!', $email);
        
$cstrong = True;
$token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong)); 
$user_id = DB::query('SELECT id FROM users WHERE username=:username', array(':username'=>$username))[0]['id'];

DB::query('INSERT INTO login_token VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$user_id));

setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
setcookie("SNID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);
      
       
                                          } else {
                                        echo '<li class="list-group-item">Email has been used by another user!</li>';
                                }
       
      } else {
        echo '<li class="list-group-item">This is not a valid email address!</li>';
      }
  } else {
    echo '<li class="list-group-item">Invalid password, password must not be less than six characters!</li>';
  }
   } else {
    echo '<li class="list-group-item">Invalid Username</li>';
   }
} else {
    echo '<li class="list-group-item">invalid Username</li>';
  }
} else {
    echo '<li class="list-group-item">Username already taken by another user!</li>';
}
}

?>

 
 
                
    <div class="login-clean">
        <form method="post">
            <h2 class="sr-only">Create Account</h2>
            <div class="illustration"><i class=""><img src="./img/akcappia.png"></i></div>
            <h2 style="font-weight: 600;line-height: 20px;font-size: 17px;margin: 0 40px 10px;text-align: center;"> Sign up to see apps and games from your friends! </h2>
            <div class="form-group">
                <input class="form-control" id="username" type="text" name="username" placeholder="Username">
            </div>
            <div class="form-group">
                <input class="form-control" id="password" type="password" name="password" placeholder="Password">
            </div>
            <div class="form-group">
                <input class="form-control" id="email" type="text" name="email" placeholder="Email">
            </div>
            <div class="form-group">
                <input type="submit" name="createaccount" value="Sign up" <button class="btn btn-default" type="button" style="background-image:url(&quot;none&quot;);background-color:#da052b;color:#fff;padding:16px 32px;margin:0px 0px 6px;border:none;box-shadow:none;text-shadow:none;opacity:0.9;text-transform:uppercase;font-weight:bold;font-size:13px;letter-spacing:0.4px;line-height:1;outline:none;display: block;position: relative;margin: 8px 40px;cursor: pointer;" </button>
                  <p style="color: #999; text-align: center; margin: 10px 60px;font-size: 14px;line-height: 18px;">By signing up you agree to our <a style="color: #999;font-weight: 600;" href="termofuse.html" target="_blank">terms</a>  & <a style="color: #999;font-weight: 600;" href="privacypolicy.html" target="_blank">privacy policy</a>.</p>
            </div><a href="login.php" class="forgot">Already got an account? Login here ...</a></form>
     <footer>
            <div class="container">
                <p class="copyright">kcappia© 2018 <a href="aboutus.html">About Us</a> <a href="help.html">Help</a> <a href="feedback.php">Feedback</a> </p>
            </div>
        </footer>

      





       
        		
       
</body>

</html>
