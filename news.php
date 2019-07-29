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
if (Login::isLoggedIn()) {

	
 } else {
	die('Not Logged In!');
}

if (isset($_POST['post'])) {
$postbody = $_POST['postbody'];
$userid = Login::isLoggedIn();
$topics = getTopics($postbody);
$loggedInUserId = Login::isLoggedIn();
 if ( strlen($postbody) < 1) {
                        die('<li class="list-group-item">Please upload a news about your app!</li>');
                }
                if (count(Notify::createNotify($postbody)) != 0) {
                                foreach (Notify::createNotify($postbody) as $key => $n) {
                                                $s = $loggedInUserId;
                                                $r = DB::query('SELECT id FROM users WHERE username=:username', array(':username'=>$key))[0]['id'];
                                                
                                                if 
                                                    ($r != 0) {
                                                        DB::query('INSERT INTO notifications VALUES (\'\', :type, :receiver, :sender, :extra, NOW())', array(':type'=>$n["type"], ':receiver'=>$r, ':sender'=>$s, ':extra'=>$n["extra"]));
                                                } 
                                        }
                                }

DB::query('INSERT INTO posts VALUES (\'\', :postbody, \'\', \'\', \'\', \'\', \'\', NOW(), :userid, 0, :topics)', array(':postbody'=>$postbody, ':userid'=>$userid, ':topics'=>$topics));
echo "<li class=list-group-item>Posted! go to your profile or home page to view it!</li>"; 
}



//$dbposts = DB::query('SELECT * FROM posts WHERE user_id=:userid ORDER BY id DESC', array(':userid'=>$userid));
//$posts = "";
//foreach($dbposts as $p) {
	//$posts .= htmlspecialchars($p['body'])."

	//<form action='news.php?&postid=".$p['id']."' method='post'>
 	//<input type='submit' name='like' value='Like'>
 //</form>

	//<hr /></br />
	//";
//}
//}
?>
<h3>Upload Your News About Your App</h3>
 <div class="postForm">
 <form action="news.php" method="post">
 	<textarea name="postbody" rows="4" class=list-group-item cols="38"></textarea>
 	<input type="submit" name="post" value="Post" <button class="btn btn-default" type="button" style="background-image:url(&quot;none&quot;);background-color:#da052b;color:#fff;padding:16px 32px;margin:0px 0px 6px;border:none;box-shadow:none;text-shadow:none;opacity:0.9;text-transform:uppercase;font-weight:bold;font-size:13px;letter-spacing:0.4px;line-height:1;outline:none;" </button><br />
 </form>
</div>
<?php

?>

</body>
</html>
