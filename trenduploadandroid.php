<?php 
include('./classes/header.php');
?>
<?php

  $msg = "";
if (isset($_POST['post'])) {
   
    $target = "trends/androidapps/".basename($_FILES['appfile']['name']);
    $name = $_POST['postbody'];
 $version = $_POST['appbody'];
$appfile = $_FILES['appfile']['name'];

if ( strlen($name) < 1) {
                        die('<li class="list-group-item">Please input app  name!</li>');
                }

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
    die("<li class=list-group-item>You can not upload that app!/li>");
}

 $appupload = DB::query('INSERT INTO android VALUES (\'\', :name, :version, :appfile, \'\', NOW(), :userid, 0)', array(':name'=>$name, ':version'=>$version, ':appfile'=>$appfile, ':userid'=>$userid));
 echo "<li class=list-group-item>Your App Has Been Shared To The World. Check it out on trends page!</li>";

    if (move_uploaded_file($_FILES['appfile']['tmp_name'], $target)) {
    $msg = "app uploaded successfully";
    } else {
        $msg = "there was a problem uploading your app";
    }
}
?>
<h2>Add Your Own App and get more Downloads!</h2>
<h2>Name</h2>
<form action="trenduploadandroid.php" method="post" enctype="multipart/form-data">
<p><li class="list-group-item">Note: Please make sure the app you are uploading is yours otherwise it will be deleted!</li></p>
    <textarea name="postbody" rows="1" cols="35" placeholder="Name"></textarea><br />
    <h2>Version</h2>
    <textarea name="appbody" rows="1" cols="35" placeholder="Version"></textarea><br /><br /><br />
    <p><li class="list-group-item">Kcappia trends only supports android files for now, other os are coming soon!</li></p>
    <h2>Android App File(apk)</h2>
    <input type="file" name="appfile"<button class="btn btn-default" type="button" style="background-image:url(&quot;none&quot;);background-color:#da052b;color:#fff;padding:16px 32px;margin:0px 0px 6px;border:none;box-shadow:none;text-shadow:none;opacity:0.9;text-transform:uppercase;font-weight:bold;font-size:13px;letter-spacing:0.4px;line-height:1;outline:none;" </button><br /><br /><br />

<input type="submit" name="post" value="Post" <button class="btn btn-default" type="button" style="background-image:url(&quot;none&quot;);background-color:#da052b;color:#fff;padding:16px 32px;margin:0px 0px 6px;border:none;box-shadow:none;text-shadow:none;opacity:0.9;text-transform:uppercase;font-weight:bold;font-size:13px;letter-spacing:0.4px;line-height:1;outline:none;" </button><br />
</form>
