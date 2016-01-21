<?php
/*Created by
*author name: Yordan Kovachev
*author id: abdt361
*date created: 04/2012
*/
//This block check if the admin is logged in or not
session_start();
if(!isset($_SESSION["admin"])){
	header("location: admin_login.php");
	exit();
}
//Now establish DB connection
include('../store/storescripts/config.php');
?>
<?php
//Error reporting block
error_reporting(E_ALL);
ini_set('display_errors','1');
?>
<?php
//Delete product from the webpage, the db and remove the picture fromthe server
if (isset($_GET['deleteid'])){
echo 'Do you really want to delete this product' .$_GET['deleteid'].'?<a href="inventory_list.php?yesdelete='.$_GET['deleteid'].'">Yes</a>|<a href="inventory_list.php">No</a>';
exit();	
}
if (isset($_GET['yesdelete'])){
	//Delete product from the system and remove the picure from the server folder images.
	//now delete the product info from the db
	$id_to_delete = $_GET['yesdelete'];
	$sql = "DELETE FROM products WHERE id='$id_to_delete'";
	$res = iQuery($sql);
	//now delete/unlink the product image from the server
	$pictodelete = ("../Images/Products/$id_to_delete.jpg");
	if(file_exists($pictodelete)){
		unlink($pictodelete);
	}
	header("location: inventory_list.php");
	exit();
}
?>
<?php
//Parse the information from the inventory form on to the system
if(isset($_POST['productName']) && isset($_POST['productPrice']) && isset($_POST['productCategory']) && isset($_POST['productSubcategory']) && isset($_POST['productDescription']) && isset($_POST['productQuantity'])){

$productName = ($_POST['productName']);
$productPrice = ($_POST['productPrice']);
$productCategory = ($_POST['productCategory']);
$productSubcategory = ($_POST['productSubcategory']);
$productDescription = ($_POST['productDescription']);
$productQuantity = ($_POST['productQuantity']);

//Check if the new product exists in the db already
$sql = "SELECT * FROM products WHERE productName='$productName'";
$res = query($sql);
if($res) {
	//evaluate the count
echo 'The product is already on the system. Please add a different (NEW) product, <a href="inventory_list.php">Add New Product</a>';
	exit();
		}
	//add this product to the databse now
$sql = iQuery("ALTER TABLE products AUTO_INCREMENT = 1"); //Insert this statement before every INSERT query to the database in order to tell the db to reuse the next free id number for the product which about to add.
$sql = "INSERT INTO products (productName, productPrice, productCategory, productSubcategory, productDescription, productQuantity, productDateAdded) VALUES('$productName','$productPrice','$productCategory','$productSubcategory','$productDescription', '$productQuantity', now())";
// Execute the query
$insert = iQuery($sql);
$pid = $_SESSION['lastInsertID'];
//This willl upload the image
$newname = "$pid.jpg";//pid=ProductID
move_uploaded_file($_FILES['fileField']['tmp_name'], "../Images/Products/$newname");
header("location: inventory_list.php");
}
?>
<?php
//This block gathers the data from the db in order to be displayed later on the webpage
$product_list = "";
$sql = "SELECT * FROM products ORDER BY productDateAdded DESC";
$res = query($sql); // Get the output from products in the database
if($res) {
foreach ($res as $row) {
		$id = $row["id"];
		$productName = $row["productName"];
		$productDateAdded = strftime("%b %d %Y",strtotime($row["productDateAdded"]));
		$productQuantity = $row["productQuantity"];
		$product_list .= "$productDateAdded - $id - $productName - $productQuantity &nbsp;&nbsp;<a href='inventory_edit.php?pid=$id'>Edit</a>&bull;<a href='inventory_list.php?deleteid=$id'>Delete</a><br/>"; //the period will compund all product from the database and they will be displayed
}
}else{
	$product_list = "You have no products on you system yet";
}
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
    <div align="left"; style="margin-left:auto; margin-right:auto; width:920px; border: 1px solid #000;">
    
    <table align="center" width="920px" border="0">
  <tr>
    <td width="549" align="left"><h1 style="font-size: 13px;">You are logged in as Administrator</h1></td>
    <td width="71" align="right"><h2 style="font-size: 13px;"> <a href="../store/storescripts/logout.php">Log out</a></h2></td>
  </tr>
</table>      
  </div>
	<div id="pageContent" style="margin-left:auto; margin-right:auto; width:920px;"><br/>
    <div align="right" style="margin-left:auto; margin-right:auto; width:880px; padding: 20px;"><a href="inventory_list.php#inventoryForm"><strong>+ Add New Products</strong></a></div>
   	 <div align="left"; style="margin-left:auto; margin-right:auto; width:880px; padding: 20px;"">
       <h2>Inventory list:</h2>
   	   <?php echo $product_list;?>
</div>
<a name="inventoryForm" id="inventoryForm"></a>
     <h3>Add New Inventory Product Form</h3>
     <form action="inventory_list.php" enctype="multipart/form-data" name="myForm" id="myForm" method="POST">
     <table width="90%" border="0" cellspacing="0" cellpadding="5">
       <tr>
         <td align="right">Product Name</td>
         <td><label>
         <input name="productName" type="text" id="productName" size="50"/>
         </label>*</td>
       </tr>
       <tr>
         <td align="right">Product Price</td>
         <td><label>
         £
         <input name="productPrice" type="text" id="textfield" size="12"/>
         </label>*</td>
       </tr>
       <tr>
         <td align="right">Category</td>
         <td><label>
         <select name="productCategory" id="category">
         <option value="">-Select-</option>
         <option value="Boy">Boy</option>
         <option value="Girl">Girl</option>
         <option value="Twins">Twins</option>
         <option value="Quads">Quads</option>
         </select>
         </label>*</td>
       </tr>
       <tr>
         <td align="right">Subcategory</td>
         <td><label>
         <select name="productSubcategory" id="subcategory">
         <option value="">-Select-</option>
         <option value="BoxSets">Box Sets</option>
         <option value="Baskets">Baskets</option>
         <option value="NappyCake">Nappy Cakes</option>
         <option value="BuildABox">Build a Box</option>
         <option value="ChristeningGifts">Christening Gifts</option>
         </select>
         </label>*</td>
       </tr>
       <tr>
         <td align="right">Product Description</td>
         <td><label>
         <textarea name="productDescription" id="textarea" cols="50" rows="5"></textarea>
         </label>*</td>
       </tr>
       <td align="right">Product Quantity</td>
         <td><label>
         <select name="productQuantity" id="quantity">
         <option value="">-Select-</option>
         <option value="1">1</option>
         <option value="2">2</option>
         <option value="3">3</option>
         <option value="4">4</option>
         <option value="5">5</option>
         </select>
         </label>*</td>
       </tr>
       <tr>
         <td align="right">Product Image</td>
         <td><label>
         <input type="file" name="fileField" id="fileField"/>
         </label>*</td>
       </tr>
       <tr>
         <td>&nbsp;</td>
         <td><label>All fields market with * must be completed!<br/>
         <input type="submit" name="button" id="button" value="Upload Item To Store"/> 
         </label></td>
       </tr>
     </table>
     </form>
     <br/>
     <br/>
  </div>
<?php include_once("../store/template_footer.php");?>
</div>
</body>
</html>