<?php
include ( "./inc/header.inc.php" );

  function isLoggedIn() {

    if (isset($_COOKIE['SNID'])) {
	if (DB::query('SELECT user_id FROM login_token WHERE token=:token', array(':token'=>sha1($_COOKIE['SNID'])))) {
		$userid = DB::query('SELECT user_id FROM login_token WHERE token=:token', array(':token'=>sha1($_COOKIE['SNID'])))[0]['user_id'];

if (isset($_COOKIE['SNID_'])) {
		return $userid;
        } else {
        	$cstrong = True;
            $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
        	DB::query('INSERT INTO login_token VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$userid));
        	DB::query('DELETE FROM login_token WHERE token=:token', array(':token'=>sha1($_COOKIE['SNID'])));

        	setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
            setcookie("SNID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);

            return $userid;
        }
    }
}


	return false;
}

if (isset($_GET['topic'])) {

if (DB::query("SELECT topics FROM posts WHERE FIND_IN_SET(:topic, topics)", array(':topic'=>$_GET['topic']))) {

    $posts = DB::query("SELECT * topics FROM posts WHERE FIND_IN_SET(:topic, topics)", array(':topic'=>$_GET['topic'])) {

    foreach($posts as $post) {
        //echo "<pre>";
        //print_r($post);
        //echo "</pre>";
        echo $post['body']."<br />";
    }
}
}
}
?>