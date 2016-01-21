<?php
/*Created by
*author name: Yordan Kovachev
*author id: abdt361
*date created: 04/2012
*/
// get the MySQL functions file
require_once('../store/storescripts/config.php');
// perform the query only if the search button has been clicked
if (array_key_exists('search', $_POST))
{
$searchInput = $_POST['searchInput'];
// this is the variable containing the result set grabbed from the database
$products = query("SELECT * FROM products WHERE productName like '%$searchInput%'");
// display eatch product from the resultant array
// check if the products result is being retrieved
if ($products)
{
$productCount = count($products);
?>
<div>There are a total of <?php echo $productCount; ?> shown.<form action="index.php"><input type="submit" name="button" value="Search New Product"></form></div>
<table border="1" cellpadding="5" cellspacing="5">
<tr>
<td><strong>Product Name:</strong></td>
<td><strong>Product Description:</strong></td>
<td><strong>Product Price:</strong></td>
</tr>
<?php
// display a single product
foreach ($products as $product)
{
?>
<tr>
<td><?php echo $product['productName']; ?></td>
<td><?php echo $product['productDescription']; ?></td>
<td><?php echo $product['productPrice']; ?></td>
</tr>
<?php
}
} 
else
{
echo "There are no products in the database.";
}
?>
</table>
<?php
}
else
{
	?>
<form name="searchform" action="<?php echo $_SERVER['file:///Macintosh HD/Applications/MAMP/htdocs/PHP_SELF']; ?>" method="POST" />
<input type="text" name="searchInput" value="<?php echo $searchInput; ?>" />
<input type="submit" name="search" value="Search Products" />
</form>
<?php } ?>