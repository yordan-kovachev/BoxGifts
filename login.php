<!-- Created by
author name: Yordan Kovachev
author id: abdt361
date created: 03/2012
-->

<?php
// Login file
// Start a new session
session_start();
	// Enable output buffering for PHP 5
ob_start();
// Require the mysql class
require_once("store/storescripts/mysql.inc.php");
// check if the login form was submitted
if (array_key_exists('login', $_POST))
{
// Execute everything from here until the endwhile if the previous line was evaluated to true
// get the details from the form ($_REQUEST array contains both the $_GET and $_POST superglobal arrays)
// Get the user
$email = $_REQUEST['email'];
// get the password
$password = $_REQUEST['password'];
// Try to login the user
// prepare a query to check if the user was logged in
$sql = "SELECT * from users where email = '$email' and password = '$password'";
// Execute the query on the server
$result = query($sql);
// Check if any rows were retrieved. If rows are retrieved, this means that the user is logged in successfully.
if ($result)
{
// This code is executed if the previous line returns true
// set some session parameters in the superglobal $_SESSION array
$_SESSION['email'] = $result['email'];
$_SESSION['loggedin'] = 1;
// Redirect the page to a new page
header("Location: myAccount.php");
}
else
{
echo "Login unsusccesfull! Please check your 'username' and 'password!'";
}
// Endwhile
}
else
{
?>
<html>
<head>
<title>Login</title>
</head>
<body>
<form name="loginform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
<input type="text" name="email" value="" />
<input type="password" name="password" value="" />
<input type="submit" name="login" value="Log in"/>
</form>
</body>
</html>
<?php } ?>