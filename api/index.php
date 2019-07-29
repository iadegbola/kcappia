<?php
require_once("DB.php");
require_once("Mail.php");

$db = new DB("127.0.0.1", "kcappia", "root", "");

if ($_SERVER['REQUEST_METHOD'] == "GET") {

        if ($_GET['url'] == "musers") {

                $token = $_COOKIE['SNID'];
                $userid = $db->query('SELECT user_id FROM login_token WHERE token=:token', array(':token'=>sha1($token)))[0]['user_id'];

                $users = $db->query("SELECT DISTINCT s.username AS Sender, r.username AS Receiver, s.profileimg AS SenderA, r.profileimg AS ReceiverA, s.id AS SenderID, r.id AS ReceiverID FROM messages LEFT JOIN users s ON s.id = messages.sender LEFT JOIN users r ON r.id = messages.receiver WHERE (s.id = :userid OR r.id=:userid)", array(":userid"=>$userid));
                $u = array();
                foreach ($users as $user) {
                        if (!in_array(array('username'=>$user['Receiver'], 'profileimg'=>$user['ReceiverA'], 'id'=>$user['ReceiverID']), $u)) {
                                array_push($u, array('username'=>$user['Receiver'], 'profileimg'=>$user['ReceiverA'], 'id'=>$user['ReceiverID']));
                        }
                        if (!in_array(array('username'=>$user['Sender'], 'profileimg'=>$user['SenderA'], 'id'=>$user['SenderID']), $u)) {
                                array_push($u, array('username'=>$user['Sender'], 'profileimg'=>$user['SenderA'], 'id'=>$user['SenderID']));
                        }
                }
                echo json_encode($u);
} else if ($_GET['url'] == "installs") {
    $token = $_COOKIE['SNID'];
                $userid = $db->query('SELECT user_id FROM login_token WHERE token=:token', array(':token'=>sha1($token)))[0]['user_id'];

                $installs = $db->query('SELECT appupload.id FROM appupload WHERE user_id=:userid ORDER BY id DESC', array(':userid'=>$userid));

               $response = "[";
                foreach($installs as $install) {
                     $response .= "{";
     $response .= '"AppuploadId": '.$install['id'].',';
    $response .= "},";

    }
    $response = substr($response, 0, strlen($response)-1);
$response .= "]";


                echo $response;

               
                    } else if ($_GET['url'] == "muser") {

                $token = $_COOKIE['SNID'];
                $userid = $db->query('SELECT user_id FROM login_token WHERE token=:token', array(':token'=>sha1($token)))[0]['user_id'];

                $users = $db->query("SELECT follower_id AS following, user_id AS follower FROM followers, users LEFT JOIN users s ON users.id = users.id LEFT JOIN users r ON users.id = users.id");
                $u = array();
                foreach ($users as $user) {
                        
                        if (!in_array(array('username'=>$user['follower'], 'id'=>$user['following']), $u)) {
                                array_push($u, array('username'=>$user['follower'], 'id'=>$user['following']));
                        }
                }
                echo json_encode($u);

        } else if ($_GET['url'] == "auth") {

        } else if ($_GET['url'] == "messages") {
                $sender = $_GET['sender'];
                $token = $_COOKIE['SNID'];
                $receiver = $db->query('SELECT user_id FROM login_token WHERE token=:token', array(':token'=>sha1($token)))[0]['user_id'];

                $messages = $db->query('SELECT messages.id AS SenderA, messages.id AS ReceiverA, messages.body AS SenderB, messages.body AS ReceiverB, s.username AS Sender, r.username AS Receiver, messages.date 
FROM messages
LEFT JOIN users s ON messages.sender = s.id
LEFT JOIN users r ON messages.receiver = r.id
WHERE (r.id=:r AND s.id=:s) OR r.id=:s AND s.id=:r 
ORDER BY messages.date DESC LIMIT 10 ', array(':r'=>$receiver, ':s'=>$sender));
                $u = array();
                foreach ($messages as $message) {
                    if (!in_array(array('id'=>$message['SenderA'], 'body'=>$message['SenderB'], 'username'=>$message['Sender']), $u)) {
                                array_push($u, array('id'=>$message['SenderA'], 'body'=>$message['SenderB'], 'username'=>$message['Sender']));
                                    }
                            
                $db->query('UPDATE messages SET `open`=1 WHERE id=:mid', array(':mid'=>$message['SenderA']));
            }

echo json_encode($u);

} else if ($_GET['url'] == "searchandroidapps") {

                $tosearch = explode(" ", $_GET['query']);
                if (count($tosearch) == 1) {
                        $tosearch = str_split($tosearch[0], 2);
                }

                $whereclause = "";
                $paramsarray = array(':name'=>'%'.$_GET['query'].'%');
                for ($i = 0; $i < count($tosearch); $i++) {
                        if ($i % 2) {
                        $whereclause .= " OR name LIKE :p$i ";
                        $paramsarray[":p$i"] = $tosearch[$i];
                        }
                }
                $posts = $db->query('SELECT DISTINCT android.id, android.name, android.version, android.date FROM android, users WHERE android.name  LIKE :name '.$whereclause.' LIMIT 2', $paramsarray);
                //echo "<pre>";
                echo json_encode($posts);

       } else if ($_GET['url'] == "search") {

                $tosearch = explode(" ", $_GET['query']);
                if (count($tosearch) == 1) {
                        $tosearch = str_split($tosearch[0], 2);
                }

                $whereclause = "";
                $paramsarray = array(':body'=>'%'.$_GET['query'].'%');
                for ($i = 0; $i < count($tosearch); $i++) {
                        if ($i % 2) {
                        $whereclause .= " OR body LIKE :p$i ";
                        $paramsarray[":p$i"] = $tosearch[$i];
                        }
                
                $posts = $db->query('SELECT posts.id, posts.body, users.username, posts.posted_at FROM posts, users WHERE users.id = posts.user_id AND posts.body LIKE :body '.$whereclause.' LIMIT 10', $paramsarray);

                

                 $whereclause = "";
                $paramsarray = array(':username'=>'%'.$_GET['query'].'%');
                for ($i = 0; $i < count($tosearch); $i++) {
                        if ($i % 2) {
                        $whereclause .= " OR username LIKE :p$i ";
                        $paramsarray[":p$i"] = $tosearch[$i];
                        }
                }

                $users = $db->query('SELECT users.username FROM users WHERE users.username LIKE :username '.$whereclause.' LIMIT 10', $paramsarray);
                //echo "<pre>";
                echo json_encode($users);
            }

        } else if ($_GET['url'] == "users") {

                $token = $_COOKIE['SNID'];
                $user_id = $db->query('SELECT user_id FROM login_token WHERE token=:token', array(':token'=>sha1($token)))[0]['user_id'];
                $username = $db->query('SELECT username FROM users WHERE id=:uid', array(':uid'=>$user_id))[0]['username'];
                echo $username;

        } else if ($_GET['url'] == "comments" && isset($_GET['postid'])) {
                $output = "";
                $comments = $db->query('SELECT comments.id, comments.comment, users.username FROM comments, users WHERE post_id = :postid AND comments.user_id = users.id', array(':postid'=>$_GET['postid']));
                $output .= "[";
                foreach($comments as $comment) {
                        $output .= "{";
                        $output .= '"CommentId": "'.$comment['id'].'",';
                        $output .= '"Comment": "'.$comment['comment'].'",';
                        $output .= '"CommentedBy": "'.$comment['username'].'"';
                        $output .= "},";
                        //echo $comment['comment']." ~ ".$comment['username']."<hr />";
                }
                $output = substr($output, 0, strlen($output)-1);
                $output .= "]";
                
                echo $output;
                } else if ($_GET['url'] == "trendandroidapps") {
$start = (int)$_GET['start'];
                $followingapps = $db->query('SELECT DISTINCT posts.id, posts.body, posts.image, posts.appfile, posts.operatingsystem, posts.appbody, posts.video, posts.posted_at, posts.likes, users.`username`, users.`profileimg` 
                    FROM users, posts
WHERE users.id = posts.user_id 
ORDER BY posts.posted_at DESC 
LIMIT 10
                OFFSET '.$start.';');

                $response = "[";
                foreach($followingapps as $apps) {

                         $response .= "{";
     $response .= '"PostId": '.$apps['id'].',';
    $response .= '"PostBody": "'.$apps['body'].'",';
    $response .= '"PostImage": "'.$apps['image'].'",';
    $response .= '"PostAppfile": "'.$apps['appfile'].'",';
    $response .= '"PostOperatingsystem": "'.$apps['operatingsystem'].'",';
    $response .= '"PostAppbody": "'.$apps['appbody'].'",';
    $response .= '"PostVideo": "'.$apps['video'].'",';
    $response .= '"PostedBy": "'.$apps['username'].'",';
    $response .= '"PostedPic": "'.$apps['profileimg'].'",';
 $response .= '"PostDate": "'.$apps['posted_at'].'",';
     $response .= '"Likes": '.$apps['likes'].''; 
    $response .= "},"; 
}
                $response = substr($response, 0, strlen($response)-1);
                $response .= "]";

                http_response_code(200);
                echo $response;

                 } else if ($_GET['url'] == "trendandroiduserapps") {

                $token = $_COOKIE['SNID'];
            $userid = $db->query('SELECT user_id FROM login_token WHERE token=:token', array(':token'=>sha1($token)))[0]['user_id'];

                $followingapps = $db->query('SELECT android.id, android.name, android.version, android.appfile, android.date, android.likes FROM android, users
                WHERE users.id = android.user_id
              AND users.id = :userid 
                ORDER BY android.likes DESC;', array(':userid'=>$userid));
                $response = "[";
                foreach($followingapps as $apps) {

                        $$response .= "{";
     $response .= '"PostId": '.$apps['id'].',';
    $response .= '"PostBody": "'.$apps['body'].'",';
    $response .= '"PostImage": "'.$apps['image'].'",';
    $response .= '"PostAppfile": "'.$apps['appfile'].'",';
    $response .= '"PostOperatingsystem": "'.$apps['operatingsystem'].'",';
    $response .= '"PostAppbody": "'.$apps['appbody'].'",';
    $response .= '"PostVideo": "'.$apps['video'].'",';
    $response .= '"PostedBy": "'.$apps['username'].'",';
    $response .= '"PostedPic": "'.$apps['profileimg'].'",';
 $response .= '"PostDate": "'.$apps['posted_at'].'",';
     $response .= '"Likes": '.$apps['likes'].''; 
    $response .= "},";
}
                $response = substr($response, 0, strlen($response)-1);
                $response .= "]";

                http_response_code(200);
                echo $response;
        
        } else if ($_GET['url'] == "posts") {
$start = (int)$_GET['start'];
            $token = $_COOKIE['SNID'];
            $userid = $db->query('SELECT user_id FROM login_token WHERE token=:token', array(':token'=>sha1($token)))[0]['user_id'];

                $followingposts = $db->query('SELECT DISTINCT posts.id, posts.body, posts.image, posts.appfile, posts.operatingsystem, posts.appbody, posts.video, posts.posted_at, posts.likes, users.`username`, users.`profileimg` FROM users, posts, followers
 WHERE (posts.user_id = followers.user_id
                OR posts.user_id = :userid)
                AND users.id = posts.user_id
                AND follower_id = :userid
ORDER BY posts.posted_at DESC
LIMIT 5
                OFFSET '.$start.';', array(':userid'=>$userid), array(':userid'=>$userid));
$response = "[";

foreach($followingposts as $post) {

    $response .= "{";
     $response .= '"PostId": '.$post['id'].',';
    $response .= '"PostBody": "'.$post['body'].'",';
    $response .= '"PostImage": "'.$post['image'].'",';
    $response .= '"PostAppfile": "'.$post['appfile'].'",';
    $response .= '"PostOperatingsystem": "'.$post['operatingsystem'].'",';
    $response .= '"PostAppbody": "'.$post['appbody'].'",';
    $response .= '"PostVideo": "'.$post['video'].'",';
    $response .= '"PostedBy": "'.$post['username'].'",';
    $response .= '"PostedPic": "'.$post['profileimg'].'",';
 $response .= '"PostDate": "'.$post['posted_at'].'",';
     $response .= '"Likes": '.$post['likes'].''; 
    $response .= "},";

    }
    $response = substr($response, 0, strlen($response)-1);
$response .= "]";


                echo $response;
                

        } else if ($_GET['url'] == "profileposts") {
                $start = (int)$_GET['start'];
                $userid = $db->query('SELECT id FROM users WHERE username=:username', array(':username'=>$_GET['username']))[0]['id'];

                $followingposts = $db->query('SELECT posts.id, posts.body, posts.image, posts.appfile, posts.operatingsystem, posts.appbody, posts.video, posts.posted_at, posts.likes, users.`username`, users.`profileimg` FROM users, posts
                WHERE users.id = posts.user_id
                AND users.id = :userid
                ORDER BY posts.posted_at DESC
                LIMIT 5
                OFFSET '.$start.';', array(':userid'=>$userid));
                $response = "[";
                foreach($followingposts as $post) {

                        $response .= "{";
                                $response .= '"PostId": '.$post['id'].',';
                                $response .= '"PostBody": "'.$post['body'].'",';
    $response .= '"PostImage": "'.$post['image'].'",';
    $response .= '"PostAppfile": "'.$post['appfile'].'",';
    $response .= '"PostOperatingsystem": "'.$post['operatingsystem'].'",';
    $response .= '"PostAppbody": "'.$post['appbody'].'",';
    $response .= '"PostVideo": "'.$post['video'].'",';
    $response .= '"PostedBy": "'.$post['username'].'",';
    $response .= '"PostedPic": "'.$post['profileimg'].'",';
                                $response .= '"PostDate": "'.$post['posted_at'].'",';
                                $response .= '"Likes": '.$post['likes'].'';
                        $response .= "},";


                }
                $response = substr($response, 0, strlen($response)-1);
                $response .= "]";

                http_response_code(200);
                echo $response;

        


        }
         


} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
     

        if ($_GET['url'] == "message") {
        if (isset($_COOKIE['SNID'])) {
          $token = $_COOKIE['SNID'];
        } else {
          die();
        }

        $userid = $db->query('SELECT user_id FROM login_token WHERE token=:token', array(':token'=>sha1($token)))[0]['user_id'];

        $postBody = file_get_contents("php://input");
        $postBody = json_decode($postBody);

        $body = $postBody->body;
        $receiver = $postBody->receiver;

        if (strlen($body) > 100) {
                echo "{ 'Error': 'Message too long!' }";
        }
        if ($body == null) {
          $body = "";
        }
        if ($receiver == null) {
          die();
        }
        if ($userid == null) {
          die();
        }

        $db->query("INSERT INTO messages VALUES ('', :body, :sender, :receiver, '0', '', NOW())", array(':body'=>$body, ':sender'=>$userid, ':receiver'=>$receiver));

        echo '{ "Success": "Message Sent!" }';
        } else if ($_GET['url'] == "users") {

                $postBody = file_get_contents("php://input");
                $postBody = json_decode($postBody);

                $username = $postBody->username;
                $password = $postBody->password;
                $email = $postBody->email;
                



                if (!$db->query('SELECT username FROM users WHERE username=:username', array(':username'=>$username))) {
  if (strlen($username) >= 3 && strlen($username) <= 32) {
if (preg_match('/[a-zA-Z0-9_]+/', $username)) {

   if (strlen($password) >= 6 && strlen($password) <= 60) {
        

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {


       $db->query('INSERT INTO users VALUES (\'\', :username, :password, :email, \'0\', \'\', \'\', \'\')', array(':username'=>$username, ':email'=>$email, ':password'=>password_hash($password, PASSWORD_BCRYPT)));
 Mail::sendmail('Welcome to Kcappia', 'now you can start sharing the things you have always imagined login now to begin!', $email);
       echo '{ "Success": "Account Created" }';
                        http_response_code(200);
       
        
       
      } else {
        echo '{ "Error": "Invalid Email!" }';
                        http_response_code(409);
      }
  } else {
    echo '{ "Error": "Invalid password!" }';
                        http_response_code(409);
  }
   } else {
    echo '{ "Error": "Invalid username!" }';
                        http_response_code(409);
   }
} else {
    echo '{ "Error": "Invalid username!" }';
                        http_response_code(409);
  }
} else {
    echo '{ "Error": "username exists!" }';
                        http_response_code(409);
}
}

        if ($_GET['url'] == "post") {
                $token = $_COOKIE['SNID'];

                $userid = $db->query('SELECT user_id FROM login_token WHERE token=:token', array(':token'=>sha1($token)))[0]['user_id'];
                echo "Dfdf";
        }

        if ($_GET['url'] == "auth") {
                $postBody = file_get_contents("php://input");
                $postBody = json_decode($postBody);

                $username = $postBody->username;
                $password = $postBody->password;

                if ($db->query('SELECT username FROM users WHERE username=:username', array(':username'=>$username))) {
                        if (password_verify($password, $db->query('SELECT password FROM users WHERE username=:username', array(':username'=>$username))[0]['password'])) {
                                $cstrong = True;
                                $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                                $user_id = $db->query('SELECT id FROM users WHERE username=:username', array(':username'=>$username))[0]['id'];
                                $db->query('INSERT INTO login_token VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$user_id));
                                echo '{ "Token": "'.$token.'" }';
                        } else {
                                echo '{ "Error": "Invalid username or password!" }';
                                http_response_code(401);
                        }
                } else {
                        echo '{ "Error": "Invalid username or password!" }';
                        http_response_code(401);
                }
            } else if ($_GET['url'] == "trendslikesapps") {
                $appId = $_GET['id'];
                $token = $_COOKIE['SNID'];
                $likerId = $db->query('SELECT user_id FROM login_token WHERE token=:token', array(':token'=>sha1($token)))[0]['user_id'];

               if (!$db->query('SELECT post_id FROM android_likes WHERE post_id=:applikeid AND user_id=:userid', array(':applikeid'=>$appId, ':userid'=>$likerId))) {
                        $db->query('UPDATE android SET likes=likes+1 WHERE id=:applikeid', array(':applikeid'=>$appId));
                        $db->query('INSERT INTO android_likes VALUES (\'\', :postid, :userid)', array(':postid'=>$appId, ':userid'=>$likerId));
                        //Notify::createNotify("", $appId);
                } else {
                        $db->query('UPDATE android SET likes=likes-1 WHERE id=:applikeid', array(':applikeid'=>$appId));
                        $db->query('DELETE FROM android_likes WHERE post_id=:applikeid AND user_id=:userid', array(':applikeid'=>$appId, ':userid'=>$likerId));
                }



                echo "{";
                echo '"Likes":';
                echo $db->query('SELECT likes FROM android WHERE id=:id', array(':id'=>$appId))[0]['likes'];
                echo "}";
          
        
        
                } else if ($_GET['url'] == "likes") {
                $postId = $_GET['id'];
                $token = $_COOKIE['SNID'];
                $likerId = $db->query('SELECT user_id FROM login_token WHERE token=:token', array(':token'=>sha1($token)))[0]['user_id'];

                if (!$db->query('SELECT user_id FROM posts_likes WHERE post_id=:postid AND user_id=:userid', array(':postid'=>$postId, ':userid'=>$likerId))) {

                        $db->query('UPDATE posts SET likes=likes+1 WHERE id=:postid', array(':postid'=>$postId));
                        $db->query('INSERT INTO posts_likes VALUES (\'\', :postid, :userid)', array(':postid'=>$postId, ':userid'=>$likerId));
                        //Notify::createNotify("", $postId);
                } else {
                        $db->query('UPDATE posts SET likes=likes-1 WHERE id=:postid', array(':postid'=>$postId));
                        $db->query('DELETE FROM posts_likes WHERE post_id=:postid AND user_id=:userid', array(':postid'=>$postId, ':userid'=>$likerId));
                }

                echo "{";
                echo '"Likes":';
                echo $db->query('SELECT likes FROM posts WHERE id=:postid', array(':postid'=>$postId))[0]['likes'];
                echo "}";
                
        }


}  else if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
        if ($_GET['url'] == "auth") {
                if (isset($_GET['token'])) {
                        if ($db->query("SELECT token FROM login_token WHERE token=:token", array(':token'=>sha1($_GET['token'])))) {
                                $db->query('DELETE FROM login_token WHERE token=:token', array(':token'=>sha1($_GET['token'])));
                                echo '{ "Status": "Success" }';
                                http_response_code(200);
                        } else {
                                echo '{ "Error": "Invalid token" }';
                                http_response_code(400);
                        }
                } else {
                        echo '{ "Error": "Malformed request" }';
                        http_response_code(400);
                }
        }
} else {
        http_response_code(405);
}

// Helper functions
?>
