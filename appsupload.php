<?php 
include('./classes/header.php');
?>

<?php

  


  

if (Login::isLoggedIn()) {
    
    
 } else {
    die('Not Logged In!');
}

function getTopics($text) {

$text = explode(" ", $text); 
$topics = "";   

    foreach ($text as $word) {
        if(substr($word, 0, 1) == "#") {
            $topics .="<a href='topics.php?topic=".substr($word, 1)."'>".htmlspecialchars($word)." </a>"; 
    }
}

    return $topics;
}

  $msg = "";
if (isset($_POST['post'])) {
   

    
    $postbody = $_POST['postbody'];
$image = $_FILES['image']['name']; 
$appfile = $_FILES['appfile']['name'];
$operatingsystem = $_POST['operatingsystem'];
$appbody = $_POST['appbody'];
$userid = Login::isLoggedIn();
$topics = getTopics($postbody);

$appfile = $FinalFilename = $_FILES['appfile']['name'];
// rename file if it already exists by prefixing an incrementing number
$FileCounter = 1;
while (file_exists( 'post/apps/'.$FinalFilename ))
$FinalFilename = $FileCounter++.'_'.$appfile;
$target = "post/apps/" . $FinalFilename;

$loggedInUserId = Login::isLoggedIn();


$image = $FinalFilenamea = $_FILES['image']['name'];
// rename file if it already exists by prefixing an incrementing number
$FileCounter = 1;
while (file_exists( 'post/apps/images/'.$FinalFilenamea))
$FinalFilenamea = $FileCounter++.'_'.$image;
$targetimage = "post/apps/images/" . $FinalFilenamea;


$imageallowed = array('jpg', 'png', 'jpeg', 'gif');
$fileExt = explode('.', $image);
$fileActualExt = strtolower(end($fileExt));


if (in_array($fileActualExt, $imageallowed)) {
    if ($image < 1048576) {
        $imageNew = uniqid('', true).".".$fileActualExt;
    } else {
       
    }
} else {
    die("<li class=list-group-item>You can not upload that image</li>");
}

$appallowed = array('apk', 'xap', 'ipa', 'iod', 'alx', 'exe');
$fileExt = explode('.', $appfile);
$fileActualExt = strtolower(end($fileExt));

if (in_array($fileActualExt, $appallowed)) {
    if ($appfile < 100000000) {
        $AppNew = uniqid('', true).".".$fileActualExt;
    } else {
      
    }
} else {
    die("<li class=list-group-item>You can not upload that app</li>");
}

if ( strlen($appbody) < 1) {
                        die('<li class="list-group-item">Please upload the name of your app!</li>');
                }
           if (count(Notify::createNotify($postbody)) != 0) {
                                foreach (Notify::createNotify($postbody) as $key => $n) {
                                                $s = $loggedInUserId;
                                                $r = DB::query('SELECT id FROM users WHERE username=:username', array(':username'=>$key))[0]['id'];
                                                if ($r != 0) {
                                                        DB::query('INSERT INTO notifications VALUES (\'\', :type, :receiver, :sender, :extra, NOW())', array(':type'=>$n["type"], ':receiver'=>$r, ':sender'=>$s, ':extra'=>$n["extra"]));
                                                }
                                        }
                                }

 $appupload = DB::query('INSERT INTO posts VALUES (\'\', :postbody, :image, :appfile, :operatingsystem, :appbody, \'\', NOW(), :userid, 0, :topics)', array(':postbody'=>$postbody, ':image'=>$FinalFilenamea, ':appfile'=>$FinalFilename, ':operatingsystem'=>$operatingsystem, ':appbody'=>$appbody, ':userid'=>$userid, ':topics'=>$topics));


 echo "<li class=list-group-item>Your App Has Been Shared To Your Friends. Check it out on your profile or home page!</li>";

 if (move_uploaded_file($_FILES['image']['tmp_name'], $targetimage)) {
        $msg = "image uploaded successfully";
    } else {
        $msg = "there was a problem uploading your image";
    }
    if (move_uploaded_file($_FILES['appfile']['tmp_name'], $target)) {
    $msg = "app uploaded successfully";
    } else {
        $msg = "there was a problem uploading your app";
    }
}
?>
<h2>Upload Your Apps For Your Friends To See!</h2>
<h2>Talk about it</h2>
<form action="appsupload.php" method="post" enctype="multipart/form-data">
    <textarea name="postbody" rows="4" class=list-group-item cols="38" placeholder="Talk About It..."></textarea><br />
    <h2>Upload an image to identify the app:</h2>
    <input type="file" name="image"<button class="btn btn-default" type="button" style="background-image:url(&quot;none&quot;);background-color:#da052b;color:#fff;padding:16px 32px;margin:0px 0px 6px;border:none;box-shadow:none;text-shadow:none;opacity:0.9;text-transform:uppercase;font-weight:bold;font-size:13px;letter-spacing:0.4px;line-height:1;outline:none;" </button><br /><br /><br />
    <h2>Upload an app Of Any OS:</h2>
    <input type="file" name="appfile"<button class="btn btn-default" type="button" style="background-image:url(&quot;none&quot;);background-color:#da052b;color:#fff;padding:16px 32px;margin:0px 0px 6px;border:none;box-shadow:none;text-shadow:none;opacity:0.9;text-transform:uppercase;font-weight:bold;font-size:13px;letter-spacing:0.4px;line-height:1;outline:none;" </button><br /><br /><br />
    <h2>Select Your Operating System</h2>
    <select name="operatingsystem" class=list-group-item>
<option value="Android">Android</option>
 <option value="IOS">IOS</option>
<option value="WindowsMobile">WindowsMobile</option>
<option value="WindowsPC">WindowsPc</option>
<option value="Blackberry">Blackberry</option>
</select><br /><br /><br />
<h2>The name of the app:</h2>
    <textarea name="appbody" rows="1" class=list-group-item cols="35"></textarea><br /><br /><br />
<input type="submit" name="post" value="Post" <button class="btn btn-default" type="button" style="background-image:url(&quot;none&quot;);background-color:#da052b;color:#fff;padding:16px 32px;margin:0px 0px 6px;border:none;box-shadow:none;text-shadow:none;opacity:0.9;text-transform:uppercase;font-weight:bold;font-size:13px;letter-spacing:0.4px;line-height:1;outline:none;" </button><br />
</form>
