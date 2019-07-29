<?php 
include('./classes/header.php');
?>
<?php

  $msg = "";
if (isset($_POST['post'])) {
   
    $target = "trends/androidapps/".basename($_FILES['appfile']['name']);
 $version = $_POST['appbody'];
$appfile = $_FILES['appfile']['name'];

if ( strlen($version) < 1) {
                        die('<li class="list-group-item">Please input app version!</li>');
                }


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
    die("<li class=list-group-item>You can not upload that app</li>");
}
$followingapps = DB::query('SELECT * FROM android WHERE user_id=:userid ORDER BY id DESC', array(':userid'=>$userid));
$apps = "";

foreach($followingapps as $appfileid) {
    
 $appupload = DB::query('UPDATE android SET version=:version, appfile=:appfile, date=NOW() WHERE id=:postid',  array(':version'=>$version, ':appfile'=>$appfile, ':postid'=>$appfileid['id']));
 echo "<li class=list-group-item>Your App Has Been Shared To The World. Check it out on trends page!</li>";

    if (move_uploaded_file($_FILES['appfile']['tmp_name'], $target)) {
    $msg = "app uploaded successfully";
    } else {
        $msg = "there was a problem uploading your app";
    }
}
}
?>
<h2>Update Your App and get more Downloads!</h2>

<form action="trendupdateandroid.php" method="post" enctype="multipart/form-data">
    <h2>New version</h2>
    <textarea name="appbody" rows="1" cols="35" placeholder="Version"></textarea><br /><br /><br />
    <h2>New android App File(apk)</h2>
    <input type="file" name="appfile"<button class="btn btn-default" type="button" style="background-image:url(&quot;none&quot;);background-color:#da052b;color:#fff;padding:16px 32px;margin:0px 0px 6px;border:none;box-shadow:none;text-shadow:none;opacity:0.9;text-transform:uppercase;font-weight:bold;font-size:13px;letter-spacing:0.4px;line-height:1;outline:none;" </button><br /><br /><br />

<input type="submit" name="post" value="Post" <button class="btn btn-default" type="button" style="background-image:url(&quot;none&quot;);background-color:#da052b;color:#fff;padding:16px 32px;margin:0px 0px 6px;border:none;box-shadow:none;text-shadow:none;opacity:0.9;text-transform:uppercase;font-weight:bold;font-size:13px;letter-spacing:0.4px;line-height:1;outline:none;" </button><br />
</form>
