<?php 
include('./classes/header.php');
?>
    <div class="container">
        <h1><u>Notifications </u></h1></div>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="list-group">
                      <?php
                      if (DB::query('SELECT * FROM notifications WHERE receiver=:userid', array(':userid'=>$userid))) {

                              $notifications = DB::query('SELECT * FROM notifications WHERE receiver=:userid ORDER BY id DESC LIMIT 20', array(':userid'=>$userid));
                              

                              foreach($notifications as $n) {

                                      if ($n['type'] == 1) {
                                              $senderName = DB::query('SELECT username FROM users WHERE id=:senderid', array(':senderid'=>$n['sender']))[0]['username'];

                                              if ($n['extra'] == "") {
                                                      echo "You got a notification!<hr />";
                                              } else {
                                                      $extra = json_decode($n['extra']);
                                                      echo '<li class="list-group-item"><span><a href=./'.$senderName.">$senderName</a> mentioned you in a post! - ".$extra->postbody.'</span>. <span><time class="timeago" title="'.$n['time'].'"></time> </span></li>';
                                              }

                                      } else if ($n['type'] == 2) {
                                              $senderName = DB::query('SELECT username FROM users WHERE id=:senderid', array(':senderid'=>$n['sender']))[0]['username'];
                                              echo '<li class="list-group-item"><span>'.$senderName.' liked your post!</span>. <span> <time class="timeago" title="'.$n['time'].'"></time> </span></li>';
                                      
                                        } else if ($n['type'] == 3) {
                                              $senderName = DB::query('SELECT username FROM users WHERE id=:senderid', array(':senderid'=>$n['sender']))[0]['username'];
                                              echo '<li class="list-group-item"><span>'.$senderName.' followed you to start checking out your shared stuffs!</span>. <span> <time class="timeago" title="'.$n['time'].'"></time> </span></li>';
                                      }
                                         
                              }

                      }
                      ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-animation.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.js"></script>
    <script type="text/javascript">

    (function timeAgo(selector) {

    var templates = {
        prefix: "",
        suffix: " ago",
        seconds: "less than a minute",
        minute: "about a minute",
        minutes: "%d minutes",
        hour: "about an hour",
        hours: "about %d hours",
        day: "a day",
        days: "%d days",
        month: "about a month",
        months: "%d months",
        year: "about a year",
        years: "%d years"
    };
    var template = function (t, n) {
        return templates[t] && templates[t].replace(/%d/i, Math.abs(Math.round(n)));
    };

    var timer = function (time) {
        if (!time) return;
        time = time.replace(/\.\d+/, ""); // remove milliseconds
        time = time.replace(/-/, "/").replace(/-/, "/");
        time = time.replace(/T/, " ").replace(/Z/, " UTC");
        time = time.replace(/([\+\-]\d\d)\:?(\d\d)/, " $1$2"); // -04:00 -> -0400
        time = new Date(time * 1000 || time);

        var now = new Date();
        var seconds = ((now.getTime() - time) * .001) >> 0;
        var minutes = seconds / 60;
        var hours = minutes / 60;
        var days = hours / 24;
        var years = days / 365;

        return templates.prefix + (
        seconds < 45 && template('seconds', seconds) || seconds < 90 && template('minute', 1) || minutes < 45 && template('minutes', minutes) || minutes < 90 && template('hour', 1) || hours < 24 && template('hours', hours) || hours < 42 && template('day', 1) || days < 30 && template('days', days) || days < 45 && template('month', 1) || days < 365 && template('months', days / 30) || years < 1.5 && template('year', 1) || template('years', years)) + templates.suffix;
    };

    var elements = document.getElementsByClassName('timeago');
    for (var i in elements) {
        var $this = elements[i];
        if (typeof $this === 'object') {
            $this.innerHTML = timer($this.getAttribute('title') || $this.getAttribute('datetime'));
        }
    }
    // update time every minute
    setTimeout(timeAgo, 100);

})();

  </script>
</body>

</html>
