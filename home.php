<?php
include('./classes/DB.php');
include('./classes/Login.php');
include('./classes/Comment.php');
include('./classes/Post.php');


$showTimeline = False;
if (Login::isLoggedIn()) {
        $userid = Login::isLoggedIn();
        $showTimeline = True;
	
 } else {
	die('Not Logged In!');
}
if (isset($_GET['postid'])) {
                        Post::likePost($_GET['postid'], $userid);
                }

if (isset($_GET['imageid'])) {
        Post::likePostimg($_GET['imageid'], $userid);
}
if (isset($_GET['appid'])) {
        Post::likePostapp($_GET['appid'], $userid);
}
if (isset($_POST['post'])) {
$postbody = $_POST['postbody'];
$userid = isLoggedIn();
}
if (isset($_POST['comment'])) {
        Comment::createComment($_POST['commentbody'], $_GET['postid'], $userid);
}



?>

  <h2>Share Your:</h2>
<div class="newsphp">                
<a href="./news.php">News</a>
<a href="./appupload.php">App</a>
<a href="./imageupload.php">Video</a>
<a href="./videoupload.php">Image</a>
</div>
<?php 



$followingposts = DB::query('SELECT posts.id, posts.body, posts.likes, users.`username` FROM users, posts, followers
WHERE posts.user_id = followers.user_id
AND users.id = posts.user_id
AND follower_id = :userid;', array(':userid'=>$userid));


foreach($followingposts as $post) {

        echo $post['body']." ~ ".$post['username'];
        echo "<form action='home.php?postid=".$post['id']."' method='post'>";

        if (!DB::query('SELECT post_id FROM posts_likes WHERE post_id=:postid AND user_id=:userid', array(':postid'=>$post['id'], ':userid'=>$userid))) {

        echo "<input type='submit' name='like' value='Like'>";
        } else {
        echo "<input type='submit' name='unlike' value='Unlike'>";
        }
        echo "<span>".$post['likes']." likes</span>
        </form>
        <form action='home.php?postid=".$post['id']."' method='post'>
        <textarea name='commentbody' rows='3' cols='50'></textarea>
        <input type='submit' name='comment' value='Comment'>
        </form>
        ";
        Comment::displayComments($post['id']);
        echo "
        <hr /></br />";
    
}
    $followingimages = DB::query('SELECT * FROM image WHERE user_id=:userid ORDER BY id DESC', array(':userid'=>$userid));
$image = "";

foreach($followingimages as $img) {
    

                        if (!DB::query('SELECT post_id FROM image_likes WHERE post_id=:imageid AND user_id=:userid', array(':imageid'=>$img['id'], ':userid'=>$userid))) {

                                $image .= "<img src='post/images/".$img['image']."'>".htmlspecialchars($img['text'])."
                                <form action='home.php?imageid=".$img['id']."' method='post'>
                                        <input type='submit' name='like' value='Like'>
                                        <span>".$img['likes']." likes</span>
                                
                                </form>
                                <hr /></br />
                                ";

                        } else {
                                 $image .= "<img src='post/images/".$img['image']."'>".htmlspecialchars($img['text'])."
                                <form action='home.php?imageid=".$img['id']."' method='post'>
                                        <input type='submit' name='unlike' value='Unlike'>
                                        <span>".$img['likes']." likes</span>
                                
                                </form>
                                <hr /></br />
                                ";
                        }
                }

                echo '<pre>';
        print_r($image);
        echo '</pre>';
               
        $followingapps = DB::query('SELECT * FROM appupload WHERE user_id=:userid ORDER BY id DESC', array(':userid'=>$userid));
$apps = "";

foreach($followingapps as $appfile) {
    

                        if (!DB::query('SELECT post_id FROM app_likes WHERE post_id=:postid AND user_id=:userid', array(':postid'=>$appfile['id'], ':userid'=>$userid))) {

                                $apps .= "<img src='post/apps/images/".$appfile['image']."'>".htmlspecialchars($appfile['postbody'])."~ ".$appfile['operatingsystem']."<br />~ ".$appfile['appbody']."
                                <form action='download.php?id=".$appfile['id']."' method='post'>
                                
                                <input type='submit' name='download' value='Download'>
                                </form>
                                <form action='home.php?appid=".$appfile['id']."' method='post'>
                                        <input type='submit' name='like' value='Like'>
                                        <span>".$appfile['likes']." likes</span>
                                
                                </form>
                                <hr /></br />

                                ";

                        } else {
                               $apps .= "<img src='post/apps/images/".$appfile['image']."'>".htmlspecialchars($appfile['postbody'])."~ ".$appfile['operatingsystem']."<br />~ ".$appfile['appbody']."
                                <form action='download.php?id=".$appfile['id']."' method='post'>
                                
                                <input type='submit' name='download' value='Download'>
                                </form>
                                <form action='home.php?appid=".$appfile['id']."' method='post'>
                                        <input type='submit' name='unlike' value='Unlike'>
                                        <span>".$appfile['likes']." likes</span>
                                
                                </form>
                                <hr /></br />
                                ";
                        }
                }

                echo '<pre>';
        print_r($apps);
        echo '</pre>';

?>
