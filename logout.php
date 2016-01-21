<!-- Created by
author name: Yordan Kovachev
author id: abdt361
date created: 04/2012
-->

<?php
// Logout file
session_start();
// Destroy the session
$_SESSION = array();
session_destroy();
unset($_SESSION);
echo "You have been logged out. Bye bye.";
header("refresh: 2; url='html/index.html'");
exit;
?>