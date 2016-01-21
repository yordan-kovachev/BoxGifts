<?php
/*Created by
*author name: Yordan Kovachev
*author id: abdt361
*date created: 04/2012
*/
//This block check if the customer is logged in or not
session_start();
if(!isset($_SESSION["customer"])){
	header("location: customer_login.php");
	exit();
}
//Now establish DB connection
include('../store/storescripts/config.php');
?>
<?php
//Error reporting block
error_reporting(E_ALL);
ini_set('display_errors','1');
?>
<?php
//Parse the information from the personal details form on to the system
if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['dob']) && isset($_POST['gender']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password'])){

$cid = ($_GET['id']);
$firstname = ($_POST['firstname']);
$lastname = ($_POST['lastname']);
$dob = ($_POST['dob']);
$gender = ($_POST['gender']);
$phone = ($_POST['phone']);
$email = ($_POST['email']);
$username = ($_POST['username']);
$password = ($_POST['password']);

//Check if the new customer details exists in the db already
$sql = "UPDATE customers SET firstname='$firstname', lastname='$lastname', dob='$dob', gender='$gender', phone='$phone', email='$email', username='$username', password='$password' WHERE id='$cid'";
$res = iQuery($sql);
header("location: customer_details.php");
exit();
}
?>
<?php
//Get all of the information for the selected customer id and display it on the form bellow for edit purposes
if (isset($_GET['cid'])){
$targetID = $_GET['cid'];
$sql = "SELECT * FROM customers WHERE id='$targetID'";
$res = query($sql);
if($res) {
foreach ($res as $row) {
		$firstname = $row["firstname"];
		$lastname = $row["lastname"];
		$dob = $row["dob"];
		$gender = $row["gender"];
		$phone = $row["phone"];
		$email = $row["email"];
		$username = $row["username"];
		$password = $row["password"];
}
}else{
	echo"Error - the customer details do not exist in the system. You should't see this message at all if customer is already logged in the system.";
	exit();
}
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>BoxGifts-Customer</title>
<link rel="stylesheet" href="../css/mainStyle.css" type="text/css" media="screen">
</head>

<body>

<div align="center" id="mainWraper">
  <?php include_once("../store/template_header.php");?>
    <div align="left"; style="margin-right: 24px; width: 920px; margin-left:auto; margin-right:auto; border: 1px solid #000;">
  </div>
	<div id="pageContent" style="width:920px;"><br/>
    <div align="right" style="padding-right:120px; padding-top: 20px; margin-left:auto; margin-right:auto; width:920px"><a href="../customer/c_home.php"><strong>Back to My Account</strong></a></div>
   	 <div align="left"; style="padding-left: 24px; width:920px; margin-left:auto; margin-right:auto;">
       <h1 style="text-align:left; color:#900;">Manage Personal Details :</h1>
       <h2>Here you can update your personal information <?php echo $firstname; ?><br/><br/></h2>
</div>
     <h3>Enter Your New Personal Details</h3>
     <table width="720px" border="1">
         <tr>
           <td width="30%" align="right" valign="top" bgcolor="#FFFFFF"><strong><a href="../customer/cust_details_update.php">Manage Personal Details</a></strong></td>
           <td width="70%" colspan="3" align="center" bgcolor="#CCCCCC">
            <form action="../customer/cust_details_update.php?cid=<?php echo $targetID; ?>" enctype="multipart/form-data" name="myForm" id="myForm" method="POST">
     <table width="620px" border="0" cellspacing="0" cellpadding="5">
       <tr>
         <td width="228" align="right">First Name</td>
         <td width="472"><label>
         <input name="firstname" type="text" id="firstname" value="<?php echo $firstname;?>"/>
         </label>*</td>
       </tr>
       <tr>
         <td align="right">Last Name</td>
         <td><label>
         <input name="lastname" type="text" id="textfield" value="<?php echo $lastname;?>"/>
         </label>*</td>
       </tr>
       <tr>
         <td align="right">Date of Birth</td>
         <td><label>
         <input name="dob" type="text" id="textfield" value="<?php echo $dob;?>"/>
         </label>*</td>
       </tr>
       <tr>
         <td align="right">Gender</td>
         <td><label>
         <select name="gender" id="gender">
         <option value="<?php echo $gender;?>"><?php echo $gender;?>-Select-</option>
         <option value="Male">Male</option>
         <option value="Female">Female</option>
         </select>
         </label>*</td>
       </tr>
       <tr>
         <td align="right">Phone Number</td>
         <td><label>
           <input name="phone" type="text" id="phone" value="<?php echo $phone;?>">
         </label>*</td>
       </tr>
       <td align="right">User Name</td>
         <td><label>
           <input name="username" type="text" id="username" value="<?php echo $username;?>">
         </label>*</td>
       </tr>
       <tr>
         <td align="right">Password</td>
         <td><label>
           <input name="password" type="password" id="password" value="<?php echo $password;?>">
         </label>*</td>
       </tr>
       <tr>
         <td height="52">&nbsp;</td>
         <td><label>All fields marked with * must be completed!<br/>
         <input name="thisID" type="hidden" value="<?php echo $targetID;?>"/>
         <input type="submit" name="button" id="button" value="Update Customer Details"/> 
         </label></td>
       </tr>
     </table>
     </form>
           </td>
         </tr>
       </table>
     <br/>
     <br/>
  </div>
<?php include_once("../store/template_footer.php");?>
</div>
</body>
</html>