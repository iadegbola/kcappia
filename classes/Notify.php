<?php


class Notify {
        public static function createNotify($text = "", $userid = 0) {
                $text = explode(" ", $text);
                $notify = array();

                foreach ($text as $word) {
                        if (substr($word, 0, 1) == "@") {
                                $notify[substr($word, 1)] = array("type"=>1, "extra"=>' { "postbody": "'.htmlentities(implode($text, " ")).'" } ');
                        }
                }

                

if (count($text) == 1 && $userid != 0) {
                        $temp = DB::query('SELECT DISTINCT followers.user_id AS receiver, followers.follower_id AS sender FROM users, followers WHERE followers.follower_id = users.id AND users.id =:userid', array(':userid'=>$userid));
                        $r = $temp[0]["receiver"];
                        $s = $temp[0]["sender"];
                        DB::query('INSERT INTO notifications VALUES (\'\', :type, :receiver, :sender, :extra)', array(':type'=>3, ':receiver'=>$r, ':sender'=>$s, ':extra'=>""));
                }

                return $notify;
        }
}
?>
