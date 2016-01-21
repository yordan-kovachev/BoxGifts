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
/**
*
* Start an if else loop that check if the add product form has been filled in and submitted and if so, add the product by adding it into the database, otherwise, show the add product form to fill in
*/
// Check if the add product form has been submitted
if (array_key_exists('addProduct', $_POST))
{
	// Grab all details from the form
$productName = trim($_REQUEST['productName']);
$productDescription = trim($_REQUEST['productDescription']);
$productPrice= trim($_REQUEST['productPrice']);
$productQuantity= trim($_REQUEST['productQuantity']);
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

// if the message array is empty, go and process the form
	if (!$errorMessage)
	{
/**
* Insert the captured details if the previous checkks did not return any errors
*/
// Check which is the biggest ID in the users table and set the AUTO_INCREMENT accordingly to prevent empty user rows when deleting existing users
$biggestID = vQuery("ALTER TABLE products AUTO_INCREMENT = 1");
// insert the details in the database
$sql = "INSERT INTO products (productName, productDescription, productPrice, productQuantity) VALUES ('$productName', '$productDescription', '$productPrice', '$productQuantity')";
$insert = query($sql);
if (!empty($insert))
{
// generate a failure message
$errorMessage[] = "There was a problem adding the product $productName into the system. Please try again";
} else
{
// generate a success message
$errorMessage[] = "You have successfully added the product named: $productName.";
header("Refresh: 5 url=manageProducts.php");
}
}
}
?>

	
	
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo SITETITLE; ?> - Add a New Product</title>
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

<form name="addProductForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
<label name='productName'>Product name:</label>
<input type="text" name="productName" value="" />
<br/>
<label name='productDescription'>Product Description:</label>
<textarea name="productDescription" cols="30" rows="3"></textarea>
<br/>
<label name='productPrice'>Product price:</label>
<input type="text" name="productPrice" value="<?php if (isset($productPrice)) { echo $productPrice; } ?>" />
<br/>
<label name='productQuantity'>Product quantity:</label>
<input type="text" name="productQuantity" value="<?php if (isset($productQuantity)) { echo $productQuantity; } ?>" />
<br/>
<input type="submit" name="addProduct" value="Add product" />
</form>

<?php echo COPYRIGHT; ?>
</body>
</html>
