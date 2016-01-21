<?php
/*Created by
*author name: Yordan Kovachev
*author id: abdt361
*date created: 04/2012
*/
session_start();
if(!isset($_SESSION["admin"])){
	header("location: admin_login.php");
	exit();
}
//Now establish DB connection
include('../store/storescripts/config.php');
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>BoxGifts-Administration</title>
<link rel="stylesheet" href="../css/mainStyle.css" type="text/css" media="screen">
</head>
<body> 

<div align="center" id="mainWraper">
  <?php include_once("../store/template_header.php");?>
    <div align="center"; style="margin-left:auto; margin-right:auto; width:920px; border: 1px solid #000;">
    <table align="center" width="920px" border="0">
  <tr>
    <td width="90%" align="left"><h1 style="font-size: 13px; padding-left:10px;">You are logged in as Administrator</h1></td>
    <td width="108" align="right"><h2 style="font-size: 13px;"> <a href="../store/storescripts/logout.php">Log out</a></h2></td>
  </tr>
</table>
  </div>
	<div id="pageContent" style="width:920px; margin-left:auto; margin-right:auto;"><br/>
   	 <div align="left"; style="padding: 24px 24px;">
       <h2>Welcome back!<br/>
        Now you can manage your web store online.</h2>
       <table width="100%" border="1">
         <tr>
           <td align="center"><a href="inventory_list.php">Manage Inventory</a></td>
           <td align="center"><a href="manage_staff.php">Manage Staff</a></td>
           <td align="center"><a href="manage_users.php">Manage Users</a></td>
           <td align="center"><a href="manage_orders.php">Manage Orders</a></td>
         </tr>
       </table>
</div>
     <br/>
     <br/>
     <br/>
  </div>
    <?php include_once("../store/template_footer.php");?>
</div>
</body>
</html>