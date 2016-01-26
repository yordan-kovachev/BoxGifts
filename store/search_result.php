<?php
/*Created by
*author name: Yordan Kovachev
*author id: abdt361
*date created: 04/2012
*/
// get the MySQL functions file
require_once('storescripts/mysql.inc.php');
// get the configuration file
require_once('../php/config.php');
// this is the variable containing the result set grabbed from the database
$products = query("SELECT * FROM products");
// display eatch product from the resultant array
// check if the products result is being retrieved
if ($products)
{
$productCount = count($products);
?>
<pre><?php print_R($products); ?></pre>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo sitetitle; ?> - <?php echo sitedescription; ?></title>
</head>

<body>
<table border="1" cellpadding="5">
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
<tr>
<td>There are a total of <?php echo $productCount; ?> products under this category.</td>
</tr>
<?php

}
} 
else
{
echo "There are no products in the database.";
exit;
}
?>
</table>
</body>
</html>