<?php
/**
* Created by
* author name: Yordan Kovachev
* author id: abdt361
* date created: 04/2012
*/
session_start();
if(isset($_SESSION["customer"])){
	header("location: c_home.php");
	exit();
}
//this will check if the form is filled and the button is pressed to submit the login details
if(isset($_POST["username"]) && isset($_POST["password"])){
	
	$customer = trim($_POST["username"]);
	$password = trim($_POST["password"]);
//alternative function for security reasons	$password = preg_replace('#[A-Za-z0-9]#i','',$_POST["password"]); //this will fillter every other caracter apart from numbers and letters that is password field

//Establish DB connection
	include("../store/storescripts/config.php");

	$sql = "SELECT id FROM customers WHERE username='$customer' AND password='$password'";
	//---check if the customer login details exists in the database
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
	$_SESSION["customer"] = $customer;
	$_SESSION["password"] = $password;
	//creating these session variable will provide the customer to move from page to page without being logout from the system.
	header("location: c_home.php");
	exit();
	} else {
		echo 'Your Username or Password is incorrect! Please check your login details and try again <a href="c_home.php" >Back to Login</a>';
	exit();
	}
}
?>

<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Box Gifts-My Account</title>
<link rel="stylesheet" href="../css/mainStyle.css" type="text/css" media="screen">
</head>

<body>

<div align="center" id="mainWraper">
	<?php include_once("../store/template_header.php");?>
	<div id="pageContent" style="width:920px; margin-left:auto; margin-right:auto;"><br/>
   	 <div align="left";>
   	   <h2>Login To Your Account</h2>
       <form id="form1" name="form1" method="post" action="<?php echo $_SERVER['../customer/PHP_SELF']; ?>">
       User Name:<br/>
       	<input name="username" type="text" id="username" size"40"/>
        <br/>
       Password:<br/>
       	<input name="password" type="password" id="password" size"40"/>
        <br/>
        <input type="Submit" name="button" id="button" value="LogIn"/>
       </form>
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