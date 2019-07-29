<?php include ( "./inc/header-index.inc.php" );
?>
<h2>Hurray you have successfully joined Kcappia please pick a profile image!</h2>
<?php 

//$check_pic = DB::query('SELECT profileimg FROM users WHERE id=:userid', array(':userid'=>$userid));
//$get_pic_row = DB::query($check_pic);
//$profileimage_db =$get_pic_row ['profileimage'];
// if ($profileimage_db =="") {
//$profileimage = "./img/default_pic.jpg";
//}
//else 
//{
//$profileimage = "Userdata/profile_pics/".$profileimage_db;
//}
if (isset($_FILES['profileimage'])) {
	if (((@$_FILES["profileimage"]["type"]=="image/jpeg") || (@$_FILES["profileimage"]["type"]=="image/png") || (@$_FILES["profileimage"]["type"]=="image/gif")) && (@$_FILES["profileimage"]["size"] < 10248576)) //1 megabyte
	{
$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789";
$rand_dir_name = substr(str_shuffle($chars) , 0, 15);
mkdir("Userdata/profile_pics/$rand_dir_name");

if (file_exists("Userdata/profile_pics/$rand_dir_name/".@$_FILES["profileimage"]["name"]))
{
	echo @$_FILES["profileimage"]["name"]." Already Exists!";


}
else
	{
move_uploaded_file(@$_FILES["profileimage"]["tmp_name"],"Userdata/profile_pics/$rand_dir_name/".$_FILES["profileimage"]["name"]); 
//echo "Uploaded and stored in: Userdata/profile_pics/$rand_dir_name/".@$_FILES["profileimage"]["name"];
$profile_pic_name = @$_FILES["profileimage"]["name"];
 DB::query('UPDATE users SET profileimg = :profileimg WHERE id=:userid', array(':profileimg'=>$_GET['$rand_dir_name->$profile_pic_name,'], ':userid'=>$userid));
header("location: signup-verification.php");
	}

	}
	else 
	{
echo "You image must be no larger than 10mb! and either .jpg, .jpeg, or .png or .gif";
	}
	}


?>
<h2>Upload Your Profile Picture</h2>
<form action="signup-verification.php" method="post" enctype="multipart/form-data">
	Upload a profile image:
	<img src="./img/default_pic.jpg" width="70">
	<input type="file" name="profileimage">
	<input type="submit" name="uploadprofileimage" value="Upload Image"><br />
	<input type="submit" name="next" value="Next">
</form>