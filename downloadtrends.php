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
$app_file = DB::query('SELECT id FROM android WHERE id=:username', array(':username'=>$appfile))[0]['id'];
$followingapps = DB::query('SELECT * FROM android WHERE id=:postid', array(':postid'=>$appfile));
$path = "";
foreach($followingapps as $appfile) {
$path .="".$appfile['appfile']."";
header('content-Disposition: attachment; filename='.$path.'');
 header('content-type:application/content-strem');
 header('content-length:'.filesize('./trends/androidapps/'.$path));
 readfile('./trends/androidapps/'.$path);
}
           ?>