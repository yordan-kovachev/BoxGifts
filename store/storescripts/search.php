<!-- Created by
author name: Yordan Kovachev
author id: abdt361
date created: 04/2012
-->
<?php
// get the MySQL functions file
require_once('mysql.inc.php');
// get the configuration file
require_once('../../php/config.php');
// perform the query only if the search button has been clicked
if (array_key_exists('search', $_POST))
{
$searchInput = $_POST['searchInput'];
// this is the variable containing the result set grabbed from the database
$products = query("select * from products WHERE productName like '%$searchInput%'");
// display eatch product from the resultant array
// check if the products result is being retrieved
if ($products)
{
$productCount = count($products);
?>
<div>There are a total of <?php echo $productCount; ?> shown.</div>
<table>
<tr>
<td>Product Name:</td>
<td>Product Description:</td>
<td>Product Price:</td>
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
<form name="searchform" action="<?php echo $_SERVER['../../PHP_SELF']; ?>" method="POST" />
<input type="text" name="searchInput" value="<?php echo $searchInput; ?>" />
<br/>
<input type="submit" name="search" value="Search This" />
</form>

<?php } ?>