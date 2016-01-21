<?php
/*Created by
author name: Yordan Kovachev
author id: abdt361
date created: 02/2012
*/ 
/** Database Abstraction Layer
* This file provides an abstract database class with functions for working with a MySQL database
* The class provides basic functions for connecting, disconnecting, inserting and retrieving results off and to a MySQL database
*/
require_once("{$_SERVER['DOCUMENT_ROOT']}/store/storescripts/config.php");

// create a few functions for our abstraction class
// create a connect function using our parameters
function connect()
{
$db_Link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die ('Cannot connect to the MySQL Server. Please go and check your username, password and database parameters in your configuration file.');
mysql_select_db(DB_NAME) or die ('Could not open database: ' . DB_NAME);
return $db_Link;
}

// disconnect function
function disconnect()
{
if (isset($db_Link))
{
mysql_close($db_Link);
}
else {
mysql_close();
}
}

/** create a query function that does not return any results
* For example such queries are insert, update and delete queries
*/
function vQuery($query)
{
if(!isset($db_Link))
$db_Link = 	connect();
$temp = mysql_query($query, $db_Link) or die('Error: ' . mysql_error());
}


/** query function that returns results
* This query function will first check if the connection to MySQL has been established and if so, will perform the requested query and will display the result in an associative array
* the result set could be used with a foreach loop later on within the other scripts
*/
function query($query)
{
if(!isset($db_Link))
$db_Link = connect();
$result = mysql_query($query, $db_Link) or die('Error: ' . mysql_error());
$lastInsertID = mysql_insert_id($db_Link);
$_SESSION['lastInsertID'] = $lastInsertID;
$returnArray = array();
$i=0;
while ($row = mysql_fetch_array($result, MYSQL_BOTH))
if ($row)
$returnArray[$i++]=$row;
return $returnArray;
// mysql_free_result($result);
}

/**
* Insert query function
* This function returns the last inserted ID if successfull, false otherwise
*/
function iQuery($query)
{
if(!isset($db_Link))
$db_Link = 	connect();
$insert = mysql_query($query, $db_Link) or die('Error: ' . mysql_error());
$lastInsertID = mysql_insert_id($db_Link);
$_SESSION['lastInsertID'] = $lastInsertID;
return $insert;
}



/** Single Query function
* This query returns a single row of the result set
* It can be used when we need to check if only one row is being found, for example when we check for an existing username or for an individual product
*/
function sQuery($query)
{
	if(!isset($db_Link))
$db_Link = connect();
$result = mysql_query($query, $db_Link) or die('Error: ' . mysql_error());
$singleRow = mysql_fetch_assoc($result);
return $singleRow;
mysql_free_result($result);
}

function getNumRows()
{
	if(isset($db_Link))
$result = mysql_query('SELECT FOUND_ROWS()', $db_Link) or die('Error: ' . mysql_error());
$singleRow = mysql_fetch_row($result);
return $singleRow;
mysql_free_result($result);
}

function setEncoding($encoding)
{
if(!isset($db_Link))
$db_Link = 	connect();
$encQuery = 'SET CHARSET ' .$encoding;
$temp = mysql_query($encQuery, $db_Link) or die('Error: ' . mysql_error());
}

?>