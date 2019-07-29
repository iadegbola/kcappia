<?php

include('./classes/DB.php');
include('./classes/Login.php');
if (Login::isLoggedIn()) {
        $userid = Login::isLoggedIn();
} else {
        die('Not logged in');
          }
          ?>
          <?php
$appfile = $_GET['id'];
$app_file = DB::query('SELECT id FROM posts WHERE id=:username', array(':username'=>$appfile))[0]['id'];
$followingapps = DB::query('SELECT * FROM posts WHERE id=:postid', array(':postid'=>$appfile));
$path = "";
foreach($followingapps as $appfile) {
$path .="".$appfile['appfile']."";
header('content-Disposition: attachment; filename='.$path.'');
 header('content-type:application/content-strem');
 header('content-length:'.filesize('./post/apps/'.$path));
 readfile('./post/apps/'.$path);
}
           ?>