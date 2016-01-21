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
//Parse the information from the inventory form on to the system
if(isset($_POST['productName']) && isset($_POST['productPrice']) && isset($_POST['productCategory']) && isset($_POST['productSubcategory']) && isset($_POST['productDescription']) && isset($_POST['productQuantity'])){

$pid = ($_GET['pid']);
$productName = ($_POST['productName']);
$productPrice = ($_POST['productPrice']);
$productCategory = ($_POST['productCategory']);
$productSubcategory = ($_POST['productSubcategory']);
$productDescription = ($_POST['productDescription']);
$productQuantity = ($_POST['productQuantity']);

//Check if the new product exists in the db already
$sql = "UPDATE products SET productName='$productName', productPrice='$productPrice', productCategory='$productCategory', productSubcategory='$productSubcategory', productDescription='$productDescription', productQuantity='$productQuantity' WHERE id='$pid'";
$res = iQuery($sql);
//This will upload a new image for the product 
if($_FILES['fileField']['tmp_name']!=""){
$newname = "$pid.jpg";//pid=PructID
move_uploaded_file($_FILES['fileField']['tmp_name'], "../Images/Products/$newname");
}
header("location: inventory_list.php");
exit();
}
?>
<?php
//Get all of the information for the selected product id and display it on the form bellow for edit purposes
if (isset($_GET['pid'])){
$targetID = $_GET['pid'];
$sql = "SELECT * FROM products WHERE id='$targetID'";
$res = query($sql);
if($res) {
foreach ($res as $row) {
		$productName = $row["productName"];
		$productPrice = $row["productPrice"];
		$productCategory = $row["productCategory"];
		$productSubcategory = $row["productSubcategory"];
		$productDescription = $row["productDescription"];
		$productQuantity = $row["productQuantity"];
		$productDateAdded = strftime("%b %d %Y",strtotime($row["productDateAdded"]));
}
}else{
	echo"Error - the item does not exist in the systme. You should't see this message at all if product is already on the system.";
	exit();
}
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
    <div align="left"; style="margin-right: 24px; width: 920px; margin-left:auto; margin-right:auto; border: 1px solid #000;">
    
    <table align="center" width="920px" border="0">
  <tr>
    <td width="802" align="left"><h1 style="font-size: 13px;">You are logged in as Administrator</h1></td>
    <td width="108" align="right"><h2 style="font-size: 13px;"> <a href="../store/storescripts/logout.php">Log out</a></h2></td>
  </tr>
</table>      
  </div>
	<div id="pageContent" style="width:920px;"><br/>
    <div align="right" style="padding-right:120px; padding-top: 20px; margin-left:auto; margin-right:auto; width:920px"><a href="inventory_list.php#inventoryForm"><strong>+ Add New Inventory Products</strong></a></div>
   	 <div align="left"; style="padding-left: 24px; width:920px; margin-left:auto; margin-right:auto;">
       <h1 style="text-align:left; color:#900;">Update Product:</h1>
       <h2>Here you can update the selected product with name: "<?php echo $productName;?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="inventory_list.php"><strong>Cancel Edit</strong></a><br/><br/></h2>
</div>
<a name="inventoryForm" id="inventoryForm"></a>
     <h3>Add New Inventory Product Form</h3>
     <form action="inventory_edit.php?pid=<?php echo $targetID; ?>" enctype="multipart/form-data" name="myForm" id="myForm" method="POST">
     <table width="920px" border="0" cellspacing="0" cellpadding="5">
       <tr>
         <td align="right">Product Name</td>
         <td><label>
         <input name="productName" type="text" id="productName" size="52" value="<?php echo $productName;?>"/>
         </label>*</td>
       </tr>
       <tr>
         <td align="right">Product Price</td>
         <td><label>
         £
         <input name="productPrice" type="text" id="textfield" size="12" value="<?php echo $productPrice;?>"/>
         </label>*</td>
       </tr>
       <tr>
         <td align="right">Category</td>
         <td><label>
         <select name="productCategory" id="category">
         <option value="">-Select-</option>
         <option value="<?php echo $productCategory;?>"><?php echo $productCategory;?></option>
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
         <option value="<?php echo $productSubcategory;?>"><?php echo $productSubcategory;?>-Select-</option>
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
         <textarea name="productDescription" id="description" cols="50" rows="5"><?php echo $productDescription;?></textarea>
         </label>*</td>
       </tr>
       <td align="right">Product Quantity</td>
         <td><label>
         <select name="productQuantity" id="quantity">
         <option value="<?php echo $productQuantity;?>"><?php echo $productQuantity;?>-Select-</option>
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
         <td><label>All fields marked with * must be completed!<br/>
         <input name="thisID" type="hidden" value="<?php echo $targetID;?>"/>
         <input type="submit" name="button" id="button" value="Update Product Details"/>
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