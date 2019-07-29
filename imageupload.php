
<?php 
include('./classes/header.php');
?>
<?php

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
if (isset($_POST['upload'])) {
    $image = $FinalFilenamea = $_FILES['uploadimage']['name'];
// rename file if it already exists by prefixing an incrementing number
$FileCounter = 1;
while (file_exists( 'post/images/'.$FinalFilenamea))
$FinalFilenamea = $FileCounter++.'_'.$image;
$targetimage = "post/images/" . $FinalFilenamea;

    $text = $_POST['postbody'];
    $image = $_FILES['uploadimage']['name'];
    $userid = Login::isLoggedIn();
    $topics = getTopics($text);
    $loggedInUserId = Login::isLoggedIn();


    $imageallowed = array('jpg', 'png', 'jpeg', 'gif');
$fileExt = explode('.', $image);
$fileActualExt = strtolower(end($fileExt));

if (in_array($fileActualExt, $imageallowed)) {
    if ($image < 1048576) {
        $imageNew = uniqid('', true) . '.' . $fileActualExt;
    } else {
       
    }
} else {
    die("<li class=list-group-item>You can not upload that image</li>");
}

if (count(Notify::createNotify($text)) != 0) {
                                foreach (Notify::createNotify($text) as $key => $n) {
                                                $s = $loggedInUserId;
                                                $r = DB::query('SELECT id FROM users WHERE username=:username', array(':username'=>$key))[0]['id'];
                                                if ($r != 0) {
                                                        DB::query('INSERT INTO notifications VALUES (\'\', :type, :receiver, :sender, :extra, NOW())', array(':type'=>$n["type"], ':receiver'=>$r, ':sender'=>$s, ':extra'=>$n["extra"]));
                                                }
                                        }
                                }

    $imageupload = DB::query('INSERT INTO posts VALUES (\'\', :postbody, :image, \'\', \'\', \'\', \'\', NOW(), :userid, 0, :topics)', array(':postbody'=>$text, ':image'=>$FinalFilenamea, ':userid'=>$userid, ':topics'=>$topics));

      

    echo "<li class=list-group-item>Image shared Go to your profile or home to view it!</li>";
    if (move_uploaded_file($_FILES['uploadimage']['tmp_name'], $targetimage)) {
        $msg = "image uploaded successfully";
    } else {
        $msg = "there was a problem uploading your image";
    }
}
?>




<h2>Share Your Image</h2>
<form action="imageupload.php" method="post" enctype="multipart/form-data">
<h2>Talk about it</h2>
    <textarea name="postbody" class=list-group-item rows="4" cols="38" placeholder="Talk About It..."></textarea><br /><br /><br />
    Upload an image:
    <input type="file" name="uploadimage"<button class="btn btn-default" type="button" style="background-image:url(&quot;none&quot;);background-color:#da052b;color:#fff;padding:16px 32px;margin:0px 0px 6px;border:none;box-shadow:none;text-shadow:none;opacity:0.9;text-transform:uppercase;font-weight:bold;font-size:13px;letter-spacing:0.4px;line-height:1;outline:none;" </button><br /><br />
    
    <input type="submit" name="upload" value="Upload Image" <button class="btn btn-default" type="button" style="background-image:url(&quot;none&quot;);background-color:#da052b;color:#fff;padding:16px 32px;margin:0px 0px 6px;border:none;box-shadow:none;text-shadow:none;opacity:0.9;text-transform:uppercase;font-weight:bold;font-size:13px;letter-spacing:0.4px;line-height:1;outline:none;" </button><br />
</form>