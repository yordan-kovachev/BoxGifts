<?php
/**
* Created by
* author name: Yordan Kovachev
* author id: abdt361
* date created: 04/2012
*/
session_start();
if(isset($_SESSION["admin"])){
	header("location: index.php");
	exit();
}
//this will check if the form is filled and the button is pressed to submit the login details
if(isset($_POST["username"]) && isset($_POST["password"])){
	
	$admin = trim($_POST["username"]);
	$password = trim($_POST["password"]);
//	$password = preg_replace('#[A-Za-z0-9]#i','',$_POST["password"]); //this will fillter every other caracter apart from numbers and letters that is password field

//Establish DB connection
	include("../store/storescripts/config.php");

	$sql = "SELECT id FROM admin WHERE username='$admin' AND password='$password'";
	//---now again checking if the administrator of the system who pretends to login exists in the database
// Execute the query
	$existCount = query($sql);
//	$existCount = mysql_num_rows($sql);//now count the row.
	if ($existCount)
	{//evaluate the count
foreach ($existCount as $row)
{
			$id = $row["id"];
	}
	$_SESSION["id"] = $id;
	$_SESSION["admin"] = $admin;
	$_SESSION["password"] = $password;
	//creating these session variable will provide the user to move from page to page without being logout from the system.
	header("location: index.php");
	exit();
	} else {
		echo header("location: admin_login_fail.php");
	exit();
	}
}
?>

<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Box Gifts-Admin</title>
<link rel="stylesheet" href="../css/mainStyle.css" type="text/css" media="screen">
</head>

<body>

<div align="center" id="mainWraper">
	<?php include_once("../store/template_header.php");?>
	<div id="pageContent" style="width:920px; margin-left:auto; margin-right:auto;"><br/>
   	 <div align="center";>
     <h1 style="font-size:14px; color:#36C;">Please check the following</h1>
   	   <h2>It seems there is an issue with your login details</h2>
        <?php echo 'Your Username or Password is incorrect! Please check your login details and try again <a href="admin_login.php" >Back to Login</a>' ?>
        <br/>
        <br/>
      <p>&nbsp;</p>
     </div>
     <br/>
     <br/>
     <br/>
  </div>
  <?php include_once("../store/template_footer.php");?>
</div>
</body>
</html>