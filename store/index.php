<?php
/**
* Created by
* author name: Yordan Kovachev
* author id: abdt361
* date created: 04/2012
*/
//Now establish DB connection
include_once('storescripts/config.php');
//run a select query to get the first 6 products
$dynamicList = "";
$sql = "SELECT * FROM products ORDER BY productDateAdded DESC LIMIT 6";
$res = query($sql); // Get the output from products in the database
if($res) {
foreach ($res as $row) {
		$id = $row["id"];
		$productName = $row["productName"];
		$productPrice = $row["productPrice"];
		$productDescription = $row["productDescription"];
		$productQuantity = $row["productQuantity"];
		$dynamicList .= '<table width="560px" height="190px" border="1" cellpadding="5">
        <tr>
          <td width="130px" height="190px"><a href="product.php?id='. $id .'"><img style="border-color:#C03 3px solid;" src="../Images/Products/'.$id.'.jpg" alt="'.$productName.'" width="126" height="167" border="3px"></a></td>
		  
          <td width="320px" height="190px" valign="top"><p>'. $productName.'<br><strong>Price: £</strong>'. $productPrice .'<br><strong>Product Details:</strong> '. $productDescription . '<br><strong>Quantity Left in Stock:</strong> ' . $productQuantity . '<br><a href="product.php?id='. $id .'"><strong>View Product Details</strong></a></p></td>
        </tr>
      </table>';
}
}else{
	$dynamicList = "There is no products on the system yet"; 
mysql_close(); //if I have any open connection to the db established by any previous php code
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Box Gifts-Home</title>
<link rel="stylesheet" href="../css/mainStyle.css" type="text/css" media="screen">
</head>

<body>

<div align="center" id="mainWraper">

	<?php include_once("template_header.php");?>
	<div id="pageContent">
	 <table width="920px" border="1">
  <tr>
    <td width="65" valign="top"><strong></strong>
      </td>
    <td width="200" align="center" valign="top"><?php include_once("search.php"); ?><br/><p><?php echo $dynamicList; ?></p>
      <!--<table width="452" height="192" border="1" cellpadding="5">
        <tr>
          <td width="128" height="190"><a href="product.php"><img style="border-color:#666 1px solid;" src="../Images/Baby Girl Wine.png" alt="$dynamicTitle" width="126" height="167" border="1"></a></td>
          <td width="284" align="left" valign="top">
          <p> ProductName</p>
          <p>ProductPrice</p>
          <p><a href="product.php?">View Product</a></p></td>
        </tr>
      </table>--></td>
    <td width="65" valign="top"><strong></strong></td>
  </tr>
</table>
  </div>
    <?php include_once("template_footer.php");?>

</div>

</body>
</html>