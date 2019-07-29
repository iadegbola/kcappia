<?php 
include('./classes/DB.php');
include('./classes/Login.php');
 
  
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kcappia</title>
    <link href='./img/akcappia.png' rel='icon' type='image/x-icon'/>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/Footer-Dark.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="assets/css/Navigation-Clean1.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/untitled.css">
</head>

<body>
    <header class="hidden-sm hidden-md hidden-lg">
            <form>

                <h1 class="text-left">Kcappia's Feedback</h1>
                    <ul class="list-group autocomplete" style="position:absolute;width:100%; z-index: 100">
                    </ul>
                </div>
                <div class="dropdown">
                    
                    
            </form>
        <hr>
    </header>
    <div>
        <nav class="navbar navbar-default hidden-xs navigation-clean">
            <div class="container">
                <div class="illustration"><i class=""><img src="./img/akcappia.png"></i></div>
                </div>
                <h2>Kcappia's Feedback</h2>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <form class="navbar-form navbar-left">
                            <ul class="list-group autocomplete" style="position:absolute;width:100%; z-index:100">
                            </ul>
                    </form>
                    <ul class="nav navbar-nav hidden-md hidden-lg navbar-right">
                        
                            
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
                    

<form name="contactform" method="post" action="feedback.php">
<br><table width="450px">
<tr>
 <td valign="top">
  <label for="first_name"> Name *</label><br>
 </td>
 <td valign="top">
  <input  type="text" name="first_name" class="btn btn-default" maxlength="50" size="30"><br><br>
 </td>
</tr>

<tr>
 <td valign="top">
  <label for="email">Email Address *</label>
 </td>
 <td valign="top">
  <input  type="text" name="email" class="btn btn-default" maxlength="80" size="30"><br><br>
 </td>
</tr>
<tr>
 <td valign="top">
  <label for="feedback">Feedback *</label>
 </td>
 <td valign="top">
  <textarea  name="feedback" class="btn btn-default" maxlength="1000" cols="25" rows="6"></textarea><br><br>
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
 
    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "anpilotcreators@gmail.com";
    $email_subject = "Kcappia Feedback";
   
 
    
 
 
    // validation expected data exists
    if(!isset($_POST['first_name']) ||
        !isset($_POST['email']) ||
        !isset($_POST['feedback'])) {
        die('We are sorry, but there appears to be a problem with the form you submitted.');       
    }
 
     
 
    $first_name = $_POST['first_name']; // required
    $email_from = $_POST['email']; // required
    $comments = $_POST['feedback']; // required
 
    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
  if(!preg_match($email_exp,$email_from)) {
    $error_message .= '<li class="list-group-item">The Email Address you entered does not appear to be valid.</li><br />';
  }
 
    $string_exp = "/^[A-Za-z .'-]+$/";
 
  if(!preg_match($string_exp,$first_name)) {
    $error_message .= '<li class="list-group-item">The First Name you entered does not appear to be valid.</li><br />';
  }
 
 
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
 
     
 
    $email_message .= "First Name: ".clean_string($first_name)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Feedback: ".clean_string($comments)."\n";
 
// create email headers
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);  
?>
 
<!-- include your own success html here -->
 
<li class="list-group-item">Thank you for giving us a feedback. You have made us improve more! We will work more to make Kcappia better for you.</li>
 
<?php
 
}
?>