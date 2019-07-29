<?php 
include ( "./inc/conect.inc.php" );

$post= $_POST['post'];
if ($post != "") {
	$date_added = date("Y-m-d");
	$user_profile_picture = 
	$added_by = "test123";
	$user_posted_to = "test123";

	$sqlCommand = "INSERT INTO posts VALUES('', '$post', '$date_added', '$user_profile_picture', '$added_by', '$user_posted_to')";
	$query = mysql_query($sqlCommand) or die (mysql_error());

}
else 
{
echo "You must enter your news first before sending it...";
}

?>