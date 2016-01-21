<!-- Created by
author name: Yordan Kovachev
author id: abdt361
date created: 04/2012
-->
<?php
// Load the main configuration file
include_once('../config.php');
// Initialise an error array holding all errors
$errorMessage = array();
// get the product ID of the product from the address
$productID = $_REQUEST['productID'];
// check if there is no product ID
if (!isset($productID))
{
die('Invalid product ID.');
}
// Get the product's info from the database
$query = "SELECT * FROM products WHERE productID = $productID";
$result = query($query);
// Check if any details were retrieved
if ($result)
{
	// Make readable variables with the details
	$originalProductName = $result[0]['productName'];
	$originalProductDescription = $result[0]['productDescription'];
	$originalProductPrice = $result[0]['productPrice'];
	$originalProductQuantity = $result[0]['productQuantity'];
}

// Check if the edit product form has been submitted
if ($_POST)
{
// if the error array is empty, go and process the form
	if (!$errorMessage)
	{
/**
* Delete the product if the previous checkks did not return any errors
*/
// Check which is the biggest ID in the product's table and set the AUTO_INCREMENT to prevent uneven rows when deleting existing products
$biggestID = vQuery("ALTER TABLE products AUTO_INCREMENT = 1");
// delete the details from the database
$sql = "DELETE FROM products WHERE productID = '$productID'";
$delete = query($sql);
if (!empty($delete))
{
// generate a failure message
$errorMessage[] = "There was a problem deleting the product $originalProductName from the system. Please try again";
} else
{
// generate a success message
$errorMessage[] = "You have successfully deleted the product named: $originalProductName.";
header("Refresh: 5 url=manageProducts.php");
}
}
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo SITETITLE; ?> - Edit a Product</title>
</head>

<body>

<p>

<?php if (isset($errorMessage))
{
?>
<ul>
<?php 	foreach ($errorMessage as $error)
{
?>
<li><?php echo $error; ?></li>
<?php } ?>
</ul>
<?php } ?>	
</p>
<p>Would you like to remove the following product: <?php echo $originalProductName; ?></p>

<form name="deleteProductForm" action="<?php echo $_SERVER['PHP_SELF']; ?>?productID=<?php echo $productID; ?>" method="POST">
<input type="submit" name="deleteProduct" value="Delete product" />
</form>

<?php echo COPYRIGHT; ?>
</body>
</html>
