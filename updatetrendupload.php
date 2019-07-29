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

$showTimeline = False;
if (isLoggedIn()) {
	echo 'Logged In';
	echo isLoggedIn();
$showTimeline = True;
	
 } else {
	echo 'Not Logged In!';
}


?>
<h2>Update Your App!</h2>
<h2>Version</h2>
<form action="trendupload.php" method="post">
    <textarea name="postbody" rows="1" cols="35"></textarea><br />
    <h2>Upload the appfile:</h2>
    <form action="trendupload.php" method="post" enctype="multipart/form-data">
    <input type="file" name="appfile"><br /><br /><br />

<input type="submit" name="update" value="Update">
