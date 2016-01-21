<?php
/*Created by
*author name: Yordan Kovachev
*author id: abdt361
*date created: 04/2012
*/
session_start();
if(!isset($_SESSION["customer"])){
	header("location: customer_login.php");
	exit();
}
//Now establish DB connection
include('../store/storescripts/config.php');
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>BoxGifts-Welcome</title>
<link rel="stylesheet" href="../css/mainStyle.css" type="text/css" media="screen">
</head>
<body> 

<div align="center" id="mainWraper">
  <?php include_once("../store/template_header.php");?>
    <div align="center"; style="margin-left:auto; margin-right:auto; width:920px; border: 1px solid #000;">
    <table align="center" width="920px" border="0">
  <tr>
    <td width="90%" align="left"><h1 style="font-size: 13px; padding-left:10px;">Hello: <?php echo ($_SESSION[customer]);?></h1></td>
    <!--<td width="10%" align="right"><h2 style="font-size: 13px; padding-right:10px;"> <a href="../store/storescripts/logout.php">Log out</a></h2></td>-->
  </tr>
</table>
  </div>
	<div id="pageContent" style="width:920px; margin-left:auto; margin-right:auto;"><br/>
   	 <div align="left"; style="padding:24px 24px;">
<h2><em>Welcome To Box Gifts!</em><br/><br/>
        Now you can manage your account <br/>and update your customer details.</h2>
<p>&nbsp;</p>
       <table width="90%" border="1">
         <tr>
           <td width="27%" align="right" valign="top" bgcolor="#FFFFFF"><strong><a href="../customer/cust_details_update.php">Manage Personal Details</a></strong></td>
           <td width="73%" colspan="3" rowspan="4" align="center" bgcolor="#CCCCCC">&nbsp;</td>
         </tr>
         <tr align="right" valign="top" bgcolor="#FFFFFF">
           <td><strong><a href="../customer/upadate_address.php">Update Address</a></strong></td>
         </tr>
         <tr align="right" valign="top" bgcolor="#FFFFFF">
           <td><strong><a href="../customer/manage_shipping_address.php">Manage Shipping Address</a></strong></td>
         </tr>
         <tr align="right" valign="top" bgcolor="#FFFFFF">
           <td height="25"><strong><a href="../customer/view_orders.php">View Orders</a></strong></td>
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