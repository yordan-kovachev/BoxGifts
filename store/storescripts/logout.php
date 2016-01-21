<?php session_start();
/*Created by
*author name: Yordan Kovachev
*author id: abdt361
*date created: 04/2012
*/
// Log out the current logged in user
$_SESSION = array();
session_destroy();
header("Location: ../../store/index.php");
?>