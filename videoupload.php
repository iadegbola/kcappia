
<?php 
include('./classes/header.php');
?>
<?php

  


  

if (Login::isLoggedIn()) {
	
	
 } else {
	echo 'Not Logged In!';
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
if (isset($_POST['uploadvideo'])) {
    $image = $FinalFilenamea = $_FILES['uploadvideo']['name'];
// rename file if it already exists by prefixing an incrementing number
$FileCounter = 1;
while (file_exists( 'post/videos/'.$FinalFilenamea))
$FinalFilenamea = $FileCounter++.'_'.$image;
$target = "post/videos/" . $FinalFilenamea;
    $text = $_POST['postbody'];
    $image = $_FILES['uploadvideo']['name'];
    $userid = Login::isLoggedIn();
    $topics = getTopics($text);
$loggedInUserId = Login::isLoggedIn();

    $imageallowed = array('mp4', 'webm');
$fileExt = explode('.', $image);
$fileActualExt = strtolower(end($fileExt));

if (in_array($fileActualExt, $imageallowed)) {
    if ($image < 1048576) {
        $imageNew = uniqid('', true) . '.' . $fileActualExt;
    } else {
       
    }
} else {
    die("<li class=list-group-item>You can not upload that video</li>");
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

    $imageupload = DB::query('INSERT INTO posts VALUES (\'\', :postbody, \'\', \'\', \'\', \'\', :video, NOW(), :userid, 0, :topics)', array(':video'=>$FinalFilenamea, ':postbody'=>$text, ':userid'=>$userid, ':topics'=>$topics));
    echo "<li class=list-group-item>Video shared Go to your profile or home to view it!</li>";
    if (move_uploaded_file($_FILES['uploadvideo']['tmp_name'], $target)) {
        $msg = "video uploaded successfully";
    } else {
        $msg = "there was a problem uploading your video";
    }
}
?>
<h2>Share Your Video Or Triller About Your App</h2>
<h2>Talk about it</h2>
<form action="videoupload.php" method="post" enctype="multipart/form-data">
    <textarea name="postbody" class=list-group-item rows="4" cols="38" placeholder="Talk About It..."></textarea><br /><br /><br />
    <h2>Upload a Video:</h2>
    <p>Note: Your video or triller must not be more than 4mb in size.</p>
    <input type="file" name="uploadvideo" type="button" style="background-image:url(&quot;none&quot;);background-color:#da052b;color:#fff;padding:16px 32px;margin:0px 0px 6px;border:none;box-shadow:none;text-shadow:none;opacity:0.9;text-transform:uppercase;font-weight:bold;font-size:13px;letter-spacing:0.4px;line-height:1;outline:none;" </button><br /><br /><br /><br />
    <input type="submit" name="uploadvideo" value="Upload Video" <button class="btn btn-default" type="button" style="background-image:url(&quot;none&quot;);background-color:#da052b;color:#fff;padding:16px 32px;margin:0px 0px 6px;border:none;box-shadow:none;text-shadow:none;opacity:0.9;text-transform:uppercase;font-weight:bold;font-size:13px;letter-spacing:0.4px;line-height:1;outline:none;" </button><br /><br />
</form>

