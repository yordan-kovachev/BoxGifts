<?php
/*Created by
author name: Yordan Kovachev
author id: abdt361
date created: 02/2012
*/
// Enable output buffering for PHP 5
ob_start();
//save sessions in tmp folder located in root of project
ini_set('session.save_path', 'boxgiftsession');
//Start a new session with duration of 1 day on cookie life span
session_start();
/**
* Configuration file for BoxGifts
* @author Yordan Kovachev <yordan.kovachev@gmail.com>
* @version 0.1
*/

/**
* Main Settings
*/

// site title
define('SITETITLE', 'Box Gifts');
// define the site description
define('SITEDESCRIPTION', 'BoxGifts');
// define admin email
define('ADMINMAIL', 'boxgifts.test@gmail.com');
// define the copyright message
define('COPYRIGHT', 'Copyright & Copy;' .date("Y") .' Box Gifts LTD. All rights reserved');

/**
* MySQL Settings
*/
/**
* DATABASE Settings
*
* This section defines the settings needed for the script to connect to its database
* Please change the relevant details as needed
* All settings are constants so they are available within the global scope of the script
*/

define('DB_HOST', 'mysql.boxgifts.yordan.co.uk');
define('DB_NAME', 'boxgifts_yordan_co');
define('DB_USER', 'boxgiftsyordan');
define('DB_PASS', 'k3#T#mK#');
define('DB_PREFIX', '');
$db_Prefix = DB_PREFIX;
// Take the DB_PREFIX constant and assign it into a variable with global scope for convenience.
global $db_Prefix;
// Load the MySQL abstraction class
include_once('mysql.inc.php');
?>