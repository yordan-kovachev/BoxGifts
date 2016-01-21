<?php
/*Created by
*author name: Yordan Kovachev
*author id: abdt361
*date created: 04/2012
*/
//Error reporting
error_reporting(E_ALL);
ini_set('display_error', '1');
?>
<?php
//Now establish DB connection
include('../store/storescripts/config.php');
?>
<?php
// Check to see the URL variable is set in and exist in the db
if (isset($_GET['id'])){
	$id = preg_replace('#[^0-9]#i','',$_GET['id']);
	$sql = "SELECT * FROM products WHERE id='$id' LIMIT 1";
	$res = query($sql); // Get the output for the product with id=$id from the database
if($res > 0) {
	foreach ($res as $row) {
		$productName = $row["productName"];
		$productPrice = $row["productPrice"];
		$productDescription = $row["productDescription"];
		$productCategory = $row["productCategory"];
		$productSubcategory = $row["productSubcategory"];
		$productQuantity = $row["productQuantity"];
		$productDateAdded = strftime("%b %d %Y",strtotime($row["productDateAdded"]));
		//productName, productPrice, productDescription,productCategory, productSubcategory, productDateAdded
	}
} else {
		echo 'The item does not exists <a href="/store/index.php">Back to Home Page</a>';
		}
}else{
	echo "Data to render your requiest is missing. Please try again!"; //if id is not presents in the url then msg
	exit();
	}
mysql_close(); //if I have any open connection to the db established by any previous php code
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php $productName; ?></title>
<link rel="stylesheet" href="../css/mainStyle.css" type="text/css" media="screen">
</head>
<body>
<div align="center" id="mainWraper">
<?php include_once("template_header.php");?>
	<div id="pageContent">
	<table width="920px" border="1" cellspacing="0" cellpadding="15">
  <tr>
  
    <td width="272" height="190px" valign="top"><img src="../Images/Products/<?php echo $id; ?>.jpg" alt="../Images/Products/<?php echo $id; ?>.jpg" width="142" height="188" align="middle"><br/><a href="Images/Products/"> <a href="../Images/Products/<?php echo $id; ?>.jpg">View Large Size</a>
      <table width="228" border="0">
        <tr>
          <td width="119" align="center"><a href="http://www.facebook.com/">Like This Product<img src="../Images/fb.gif" width="42" height="40" longdesc="http://www.facebook.com"></a></td>
          <td width="93" align="center"><a href="http://www.twitter.com/">Tell a Friend<img src="../Images/tw.gif" width="42" height="40" longdesc="http://www.twitter.com"></a></td>
        </tr>
      </table></td>
    
    <td width="582" height="190px" valign="top">
    <p><strong>Name:</strong><?php echo $productName; ?><br/></p>
    <p><strong>Price: £</strong><?php echo $productPrice; ?><br/></p>
    <p><strong>Category:</strong><?php echo $productCategory; ?><br/></p>
    <p><strong>Subcategory:</strong><?php echo $productSubcategory; ?><br/></p>
    <p><strong>Product Description:</strong><?php echo $productDescription; ?><br/></p>
    <p>
    <form id="firm1" name="form1" method="post" action="cart.php">
    <input type="hidden" name="pid" id="pid" value="<?php echo $id; ?>"/>
    <input type="submit" name="button" id="button" value="Add to Shopping Basket"/>
    </form>
    </p>
      </td>
   </tr>
</table>
</div>
    <?php include_once("template_footer.php");?>
</div>
</body>
</html>