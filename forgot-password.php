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

                <h1 class="text-left">Kcappia</h1>
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
include('./classes/Mail.php');

if (isset($_POST['resetpassword'])) {

        $cstrong = True;
        $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
        if ($email = $_POST['email']) {
        if ($user_id = DB::query('SELECT id FROM users WHERE email=:email', array(':email'=>$email))[0]['id']) {
        DB::query('INSERT INTO password_tokens VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$user_id));
        Mail::sendMail('Forgot password!', "<a href='http://https://goo.gl/LrmtDS/change-password.php?token=$token'>http://https://goo.gl/LrmtDS/change-password.php?token=$token</a>", $email);
echo '<li class="list-group-item">Email sent, Click on the link that was sent to you to change your password!</li>';

} else {
    echo "<li class=list-group-item>Wrong Email address Check your email and try again!</li>";
}
} else {
    echo "<li class=list-group-item>Input your Email address please!</li>";
}
}



    

?>
<h2>Forgot Password</h2><br><br>
<form action="forgot-password.php" method="post">
<input type="text" name="email" value="" placeholder="Email"><p /><br><br>
<input type="submit" name="resetpassword" value="Reset Password"<button class="btn btn-default" type="button" style="background-image:url(&quot;none&quot;);background-color:#da052b;color:#fff;padding:16px 32px;margin:0px 0px 6px;border:none;box-shadow:none;text-shadow:none;opacity:0.9;text-transform:uppercase;font-weight:bold;font-size:13px;letter-spacing:0.4px;line-height:1;outline:none;" </button>
</form>