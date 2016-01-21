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
	// Grab all details from the form
$productName = trim($_REQUEST['productName']);
$productDescription = trim($_REQUEST['productDescription']);
$productPrice= trim($_REQUEST['productPrice']);
$productQuantity= $_REQUEST['productQuantity'];
/**
* Make a few security checks of the fields submitted
*/
// Check if the product name is set
if (!isset($productName))
{
	$errorMessage[] = "Please type in a product name.";
}
// Check the product description
if (!isset($productDescription))
{
	$errorMessage[] = "Please type in a product description.";
}
// Check for the price and if it's a number
if (!isset($productPrice) || (!is_numeric($productPrice)))
{
	$errorMessage[] = "Please type in a product price and make sure to use only digits.";
}
// Check for the price and if it's a number
if (!isset($productQuantity) || (!is_numeric($productQuantity)))
{
	$errorMessage[] = "Please type in a product quantity and make sure to use only digits.";
}
// if the error array is empty, go and process the form
	if (!$errorMessage)
	{
/**
* Insert the captured details if the previous checkks did not return any errors
*/
// Check which is the biggest ID in the product's table and set the AUTO_INCREMENT to prevent uneven rows when deleting existing products
$biggestID = vQuery("ALTER TABLE products AUTO_INCREMENT = 1");
// insert the details in the database
$sql = "UPDATE products set productName = '$productName', productDescription = '$productDescription', productPrice ='$productPrice', productQuantity='$productQuantity' WHERE productID = '$productID'";
$insert = query($sql);
if (!empty($insert))
{
// generate a failure message
$errorMessage[] = "There was a problem adding the product $productName into the system. Please try again";
} else
{
// generate a success message
$errorMessage[] = "You have successfully modified the product named: $productName.";
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

<form name="editProductForm" action="<?php echo $_SERVER['PHP_SELF']; ?>?productID=<?php echo $productID; ?>" method="POST">
<label name='productName'>Product name:</label>
<input type="text" name="productName" value="<?php if (isset($originalProductName)) { echo $originalProductName; } ?>" />
<br/>
<label name='productDescription'>Product Description:</label>
<textarea name="productDescription" cols="30" rows="3"><?php if (isset($originalProductDescription)) { echo $originalProductDescription; } ?></textarea>
<br/>
<label name='productPrice'>Product price:</label>
<input type="text" name="productPrice" value="<?php if (isset($originalProductPrice)) { echo $originalProductPrice; } ?>" />
<br/>
<label name='productQuantity'>Product quantity:</label>
<input type="text" name="productQuantity" value="<?php if (isset($originalProductQuantity)) { echo $originalProductQuantity; } ?>" />
<br/>
<input type="submit" name="EditProduct" value="Edit product" />
</form>

<?php echo COPYRIGHT; ?>
</body>
</html>
