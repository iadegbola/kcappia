
<?php 
include('./classes/header.php');
?>
    <h3>Please Invite your friends To join Kcappia and make app sharing more fun!</h3>
    <?php 
$invite = "I just checked out 
kcappia, a new app sharing
 social network that is 
 very interesting and was
  created by two 16 
  year old Nigerian teenagers
 and I will like you too to 
 join kcappia. Kcappia gives
  you the ability to be able 
  to do something you have 
  always only dream't of doing
   which is app sharing.
    Kcappia makes app sharing 
    more fun because you can 
    share apps, screenshots,
     thrillers, and news
about apps and games 
you love with your
friends anywhere in the world,
     something that has never
      been created before as
   that is the next big thing 
   for the future just like
    that of Instagram 
for photo sharing.
    Sign Up at:
     http://www.kcappia.site11.com 
    and join me in making
     app sharing much more fun!";
    ?>
   <form name="contactform" method="post" action="invitefriends.php">
<br><table width="450px">

<tr>
 <td valign="top">
  <label for="email">Friends Email*</label>
 </td>
 <td valign="top">
  <input  type="text" name="email" class="btn btn-default" maxlength="80" size="30"><br><br>
 </td>
</tr>
<tr>
 <td valign="top">
  <label for="feedback">Invitation *</label>
 </td>
 <td valign="top">
  <textarea  name="feedback" class="btn btn-default" maxlength="1000" cols="25" rows="6"><?php echo $invite; ?></textarea><br><br>
 </td>
</tr>
<tr>
 <td colspan="2" style="text-align:center">
  <input type="submit" value="Submit"<button class="btn btn-default" type="button" style="background-image:url(&quot;none&quot;);background-color:#da052b;color:#fff;padding:16px 32px;margin:0px 0px 6px;border:none;box-shadow:none;text-shadow:none;opacity:0.9;text-transform:uppercase;font-weight:bold;font-size:13px;letter-spacing:0.4px;line-height:1;outline:none;" </button>   
 </td>
</tr>
</table>
</form>

<?php

if(isset($_POST['email'])) {
 $email_from = $_POST['email']; 
    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = $email_from; 
    $email_subject = "Invitation to join Kcappia";
   
 
    
 
 
    // validation expected data exists
    if( !isset($_POST['email']) ||
        !isset($_POST['feedback'])) {
        die('We are sorry, but there appears to be a problem with the invite you submitted.');       
    }
 
     
 
    $email_from = $_POST['email']; // required
    $comments = $_POST['feedback']; // required
 
    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
  if(!preg_match($email_exp,$email_from)) {
    $error_message .= '<li class="list-group-item">The Email Address you entered does not appear to be valid.</li><br />';
  }
 
    $string_exp = "/^[A-Za-z .'-]+$/";
 
 
  if(strlen($comments) < 2) {
    $error_message .= '<li class="list-group-item">The Comments you entered do not appear to be valid.</li><br />';
  }
 
  if(strlen($error_message) > 0) {
    die($error_message);
  }
 
    $email_message = "Form details below.\n\n";
 
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
 
     
 
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Feedback: ".clean_string($comments)."\n";
 
// create email headers
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);  
?>
 
<!-- include your own success html here -->
 
<li class="list-group-item">Thanks a lot for Inviting your friends to join Kcappia. You have made us have more friends who will make app sharing more fun! We will work more to make Kcappia better for everyone using it.</li>
 
<?php
 
}
?>
    
    