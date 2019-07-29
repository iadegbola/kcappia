<?php
class Post {

        public static function createPost($postbody, $loggedInUserId, $profileUserId) {

                if (strlen($postbody) > 160 || strlen($postbody) < 1) {
                        die('Incorrect length!');
                }

                $topics = self::getTopics($postbody);

                if ($loggedInUserId == $profileUserId) {

                        if (count(Notify::createNotify($postbody)) != 0) {
                                foreach (Notify::createNotify($postbody) as $key => $n) {
                                                $s = $loggedInUserId;
                                                $r = DB::query('SELECT id FROM users WHERE username=:username', array(':username'=>$key))[0]['id'];
                                                if ($r != 0) {
                                                        DB::query('INSERT INTO notifications VALUES (\'\', :type, :receiver, :sender, :extra)', array(':type'=>$n["type"], ':receiver'=>$r, ':sender'=>$s, ':extra'=>$n["extra"]));
                                                }
                                        }
                                }

                        DB::query('INSERT INTO posts VALUES (\'\', :postbody, NOW(), :userid, 0, \'\', :topics)', array(':postbody'=>$postbody, ':userid'=>$profileUserId, ':topics'=>$topics));

                } else {
                        die('Incorrect user!');
                }
        }

        
        

        public static function likePost($postId, $likerId) {

                if (!DB::query('SELECT user_id FROM posts_likes WHERE post_id=:postid AND user_id=:userid', array(':postid'=>$postId, ':userid'=>$likerId))) {
                        DB::query('UPDATE posts SET likes=likes+1 WHERE id=:postid', array(':postid'=>$postId));
                        DB::query('INSERT INTO posts_likes VALUES (\'\', :postid, :userid)', array(':postid'=>$postId, ':userid'=>$likerId));
                     //   Notify::createNotify("", $postId);
                } else {
                        DB::query('UPDATE posts SET likes=likes-1 WHERE id=:postid', array(':postid'=>$postId));
                        DB::query('DELETE FROM posts_likes WHERE post_id=:postid AND user_id=:userid', array(':postid'=>$postId, ':userid'=>$likerId));
                }

        }

         public static function likePostimg($imageId, $likerId) {

                if (!DB::query('SELECT user_id FROM image_likes WHERE post_id=:postid AND user_id=:userid', array(':postid'=>$imageId, ':userid'=>$likerId))) {
                        DB::query('UPDATE image SET likes=likes+1 WHERE id=:postid', array(':postid'=>$imageId));
                        DB::query('INSERT INTO image_likes VALUES (\'\', :postid, :userid)', array(':postid'=>$imageId, ':userid'=>$likerId));
                        //Notify::createNotify("", $postId);
                } else {
                        DB::query('UPDATE image SET likes=likes-1 WHERE id=:postid', array(':postid'=>$imageId));
                        DB::query('DELETE FROM image_likes WHERE post_id=:postid AND user_id=:userid', array(':postid'=>$imageId, ':userid'=>$likerId));
                }

        }
         public static function likePostapp($appId, $likerId) {

                if (!DB::query('SELECT user_id FROM app_likes WHERE post_id=:postid AND user_id=:userid', array(':postid'=>$appId, ':userid'=>$likerId))) {
                        DB::query('UPDATE appupload SET likes=likes+1 WHERE id=:postid', array(':postid'=>$appId));
                        DB::query('INSERT INTO app_likes VALUES (\'\', :postid, :userid)', array(':postid'=>$appId, ':userid'=>$likerId));
                        //Notify::createNotify("", $postId);
                } else {
                        DB::query('UPDATE appupload SET likes=likes-1 WHERE id=:postid', array(':postid'=>$appId));
                        DB::query('DELETE FROM app_likes WHERE post_id=:postid AND user_id=:userid', array(':postid'=>$appId, ':userid'=>$likerId));
                }

        }

        public static function getTopics($text) {

                $text = explode(" ", $text);

                $topics = "";

                foreach ($text as $word) {
                        if (substr($word, 0, 1) == "#") {
                                $topics .= substr($word, 1).",";
                        }
                }

                return $topics;
        }

        public static function link_add($text) {

                $text = explode(" ", $text);
                $newstring = "";

                foreach ($text as $word) {
                        if (substr($word, 0, 1) == "@") {
                                $newstring .= "<a href='profile.php?username=".substr($word, 1)."'>".htmlspecialchars($word)."</a> ";
                        } else if (substr($word, 0, 1) == "#") {
                                $newstring .= "<a href='topics.php?topic=".substr($word, 1)."'>".htmlspecialchars($word)."</a> ";
                        } else {
                                $newstring .= htmlspecialchars($word)." ";
                        }
                }

                return $newstring;
        }

        public static function displayPosts($userid, $username, $loggedInUserId) {
                $dbposts = DB::query('SELECT * FROM posts WHERE user_id=:userid ORDER BY id DESC', array(':userid'=>$userid));
                $posts = "";

                foreach($dbposts as $p) {

                        if (!DB::query('SELECT post_id FROM posts_likes WHERE post_id=:postid AND user_id=:userid', array(':postid'=>$p['id'], ':userid'=>$loggedInUserId))) {

                                $posts .= self::link_add($p['body'])."
                                <form action='profile.php?username=$username&postid=".$p['id']."' method='post'>
                                        <input type='submit' name='like' value='Like'>
                                        <span>".$p['likes']." likes</span>
                                ";
                                if ($userid == $loggedInUserId) {
                                        $posts .= "<input type='submit' name='deletepost' value='x' />";
                                }
                                $posts .= "
                                </form><hr /></br />
                                ";

                        } else {
                                $posts .= self::link_add($p['body'])."
                                <form action='profile.php?username=$username&postid=".$p['id']."' method='post'>
                                <input type='submit' name='unlike' value='Unlike'>
                                <span>".$p['likes']." likes</span>
                                ";
                                if ($userid == $loggedInUserId) {
                                        $posts .= "<input type='submit' name='deletepost' value='x' />";
                                }
                                $posts .= "
                                </form><hr /></br />
                                ";
                        }
                }

                return $posts;
        }

        
 public static function displayImg($userid, $username, $loggedInUserId) {

                $dbposts = DB::query('SELECT * FROM image WHERE user_id=:userid ORDER BY id DESC', array(':userid'=>$userid));
                $image = "";


foreach($dbposts as $img) {
    

                        if (!DB::query('SELECT post_id FROM posts_likes WHERE post_id=:postid AND user_id=:userid', array(':postid'=>$img['id'], ':userid'=>$userid))) {

                                $image .= "<img src='post/images/".$img['image']."'>".htmlspecialchars($img['text'])."
                                <form action='home.php?postid=".$img['id']."' method='post'>
                                        <input type='submit' name='like' value='Like'>
                                        <span>".$img['likes']." likes</span>
                                
                                </form>
                                <hr /></br />
                                ";

                        } else {
                                 $image .= "<img src='post/images/".$img['image']."'>".htmlspecialchars($img['text'])."
                                <form action='home.php?postid=".$img['id']."' method='post'>
                                        <input type='submit' name='like' value='Like'>
                                        <span>".$img['likes']." likes</span>
                                
                                </form>
                                <hr /></br />
                                ";
                        }
                }

                
                return $image;
        }
        
}

?>
