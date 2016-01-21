<?php
/*Created by
*author name: Yordan Kovachev
*author id: abdt361
*date created: 04/2012
*/
// Set email variables
$email_to = 'boxgifts.test@gmail.com';
$email_subject = 'Registration Successfull';
// Load the main configuration file
include_once('../store/storescripts/config.php');
// Initialise an error array holding all errors
$errorMessage = array();
/**
*
* Start an if else loop that check if the register form has been filled in and submitted and if so, register the user by adding it into the database, otherwise, show the registration form to the customer to fill in
*/
// Check if the register form has been submitted
if (array_key_exists('register', $_POST))
{
	// Grab all details from the form
	$firstName = trim($_REQUEST['firstName']);
	$lastName = trim($_REQUEST['lastName']);
	$dob = $_REQUEST['dob'];
	$gender = $_REQUEST['gender'];
	$email = trim($_REQUEST['email']);
	$password = trim($_REQUEST['password']);
	$passwordConfirmed = trim($_REQUEST['passwordConfirmed']);
	$phone = trim($_POST['phone']);
/**
* Make a few security checks of the fields are submitted or not
*/
// check password
if(strlen($password) < 6 || preg_match('/\s/', $password))
{
$errorMessage[] = 'The password must contain minimum of 6 characters without spaces';
}
// check that the passwords match
if ($password != $passwordConfirmed)
{
$errorMessage[] = "The passwords you typed do not match, please retype them again and make sure that both are the same";
}
if(!$gender)
{
$errorMessage[] = "Gender was not selected. Please select your gender.";
}
// Check if the email was formatted correctly and that the email exists at all
// if there is no email or it's messed up
// Perform a match using a regular expression on the email address provided
$regexpemail = "/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/";
if (!preg_match($regexpemail, $_POST['email']))
{
	$errorMessage[] = "The email address you provided is not valid, please provide an email address in the format john.smith@example.com or john@example.com";
}
// check if email is provided at all
if (!$_POST['email'])
{
	$errorMessage[] = "An email address is not provided. Please provide one.";
}
// Check the birthday format
if(preg_match('/^(\d){1,2}\/(\d){1,2}\/(\d){4}$/',$DOB))
{ 
list($month,$day,$year) = explode('/',$DOB);
} else
{
	$errorMessage[] = "Please enter your date of birth in the following format: mm/dd/yyyy.";
}
// check for duplicate email registered to the system
$checkDuplicateEmail = query("SELECT * FROM customers WHERE email = '$email'");
// if the array returns a result
if ($checkDuplicateEmail)
{
// display a message 
$errorMessage[] = "The email address: $email, you have tryed to register with is already in our system. Please choose another one and try again.";
}
// if the message array is empty, go and process the form
	if (!$errorMessage)
	{
/**
* Insert the captured details if the previous checks did not return any errors
*/
// Check which is the biggest ID in the users table and set the AUTO_INCREMENT accordingly to prevent empty user rows when deleting existing users
$biggestID = vQuery("ALTER TABLE custoemrs AUTO_INCREMENT = 1");
// insert the details in the database
$sql = "INSERT INTO users (firstName, lastName, dob, gender, email, phone, password) VALUES ('$firstName', '$lastName', '$DOB', '$gender', '$email', '$phone', '$password')";
$insert = iQuery($sql);
if (!empty($insert))
{
// generate a failure message
$errorMessage[] = "There was a problem adding the user $email into the system. Please try again";
} else
{
// generate a success message
$errorMessage[] = "Thank you for registering at BoxGifts.";
}
}
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Box Gifts - New Customer</title>
<link rel="stylesheet" href="../css/mainStyle.css" type="text/css" media="screen">
</head>
<body>

<div align="center" id="mainWraper">
  <?php include_once("../store/template_header.php");?>
    <div align="left"; style="margin-right: 24px; width: 920px; margin-left:auto; margin-right:auto; border: 1px solid #000;">     
  </div>
  <div id="pageContent" align="left" style="width:920px; margin-left:auto; margin-right:auto;">
  <div align="center"><h1 style="font:'Times New Roman', Times, serif; font-size:20px; color:#39F">Please enter your personal details in the form bellow.</h1>
  <br/>
  <h2 align="left" style= "font-style:italic; font-family: 'Palatino Linotype', 'Book Antiqua', Palatino, serif; padding-left:15px; font-size:15px">* When you complete your registration <br/> a confirmation email will be <br/>
     send to your email address.</h2>
  </div><br/> 
<form name="registerForm" action="" method="POST">
  <table width="535" border="1" cellpadding="5" cellspacing="1">
    <tr>
    <td width="191" align="right" valign="middle"><strong>
      <label name='email'>Email address:</label>
    </strong></td>
    <td width="315" align="left" valign="middle"><input type="text" name="email2" value="<?php if (isset($email)) { echo $email; } ?>" /></td>
  </tr>
  <tr>
    <td align="right" valign="middle"><strong>
      <label name='password'>Password:</label>
    </strong></td>
    <td align="left"><input type="password" name="password2" value="<?php if (isset($password)) { echo $password; } ?>" /></td>
  </tr>
  <tr>
    <td align="right" valign="middle"><strong>Confirm your password:</strong></td>
    <td align="left"><input type="password" name="passwordConfirmed" value="<?php if (isset($passwordConfirmed)) { echo $passwordConfirmed; } ?>" /></td>
  </tr>
  <tr>
    <td align="right" valign="middle"><strong>
      <label name="DOB">Date of Birth:</label>
    </strong></td>
    <td align="left"><input type="text" name="DOB2" value ="mm/dd/yyyy" /></td>
  </tr>
  <tr>
    <td align="right" valign="middle"><strong>
      <label name='gender'>Gender:</label>
    </strong></td>
    <td align="left"><select name="gender2">
      <option name="unspecified">--- Please choose your gender</option>
      <option name="m" value="m">Male</option>
      <option name="f" value="f">Female</option>
    </select></td>
  </tr>
  <tr>
    <td align="right" valign="middle"><strong>First name:</strong></td>
    <td align="left"><input type="text" name="firstName2" value="<?php if (isset($firstName)) { echo $firstName; } ?>" /></td>
  </tr>
  <tr>
    <td align="right" valign="middle"><strong>
      <label name='lastName'>Last name:</label>
    </strong></td>
    <td align="left"><input type="text" name="lastName2" value="<?php if (isset($lastName)) { echo $lastName; } ?>" /></td>
  </tr>
  <tr>
    <td align="right" valign="middle"><strong>
      <label name='phone'>Phone:</label>
    </strong></td>
    <td align="left"><input type="text" name="phone2" value="<?php if (isset($phone)) { echo $phone; } ?>" /></td>
  </tr>
  <tr>
    <td align="right" valign="middle">&nbsp;</td>
    <td align="left"><input type="submit" name="register" value="Register as New Customer" /></td>
  </tr>
</table>
  <br/>
  <br/>
</form>
<br/>
<br/>
  </div>
<?php include_once("../store/template_footer.php");?>
</div>
</body>
</html>