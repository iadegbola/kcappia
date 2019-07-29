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
$token = $_COOKIE['SNID'];
                $user_id = DB::query('SELECT user_id FROM login_token WHERE token=:token', array(':token'=>sha1($token)))[0]['user_id'];
                $username = DB::query('SELECT username FROM users WHERE id=:uid', array(':uid'=>$user_id))[0]['username'];

$getpic = DB::query('SELECT profileimg FROM users WHERE id=:uid', array(':uid'=>$user_id))[0]['profileimg'];

  if ($getpic == "") {
  $picture = "img/profilepic.jpg";
  }
  else
  {

  $picture = "userdata/profile_pics/".$getpic;
  }

if (isset($_POST['uploadprofileimg'])) {
 $target = "userdata/profile_pics/".basename($_FILES['profileimg']['name']);
    $uploadprofileimg = $_FILES['profileimg']['name'];
    $imageallowed = array('jpg', 'png', 'jpeg', 'gif');
$fileExt = explode('.', $uploadprofileimg);
$fileActualExt = strtolower(end($fileExt));

if (in_array($fileActualExt, $imageallowed)) {
    if ($uploadprofileimg < 1048576) {
        $imageNew = uniqid('', true) . '.' . $fileActualExt;
    } else {
       
    }
} else {
    die("<li class=list-group-item>You can not upload that image</li>");
}
    
   
    
  
  

   
        $uploadprofileimg = DB::query("UPDATE users SET profileimg = :profileimg WHERE id=:userid", array(':profileimg'=>$uploadprofileimg, ':userid'=>$userid));
        echo "<li class=list-group-item>Profile picture successfully Changed!</li>";
        header("location: myaccountos.php");
 if (move_uploaded_file($_FILES['profileimg']['tmp_name'], $target)) {
        $msg = "image uploaded successfully";
    } else {
        $msg = "there was a problem uploading your image";
    }
}

?>
<h1>Change Profile Picture</h1>
<form action="myaccount.php" method="post" enctype="multipart/form-data">
        Upload a profile image:
        <img src="<?php echo $picture; ?>" width="74" height="74"><br><br>
        <input type="file" name="profileimg" <button class="btn btn-default" type="button" style="background-image:url(&quot;none&quot;);background-color:#da052b;color:#fff;padding:16px 32px;margin:0px 0px 6px;border:none;box-shadow:none;text-shadow:none;opacity:0.9;text-transform:uppercase;font-weight:bold;font-size:13px;letter-spacing:0.4px;line-height:1;outline:none;" </button><br><br>
        <input type="submit" name="uploadprofileimg" value="Upload Image" <button class="btn btn-default" type="button" style="background-image:url(&quot;none&quot;);background-color:#da052b;color:#fff;padding:16px 32px;margin:0px 0px 6px;border:none;box-shadow:none;text-shadow:none;opacity:0.9;text-transform:uppercase;font-weight:bold;font-size:13px;letter-spacing:0.4px;line-height:1;outline:none;" </button>
</form>
<span style="margin-left: 20em;">
<a href="myaccountos.php" class="btn btn-default">Skip</a>
</span>



