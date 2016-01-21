<?php
/*Created by
*author name: Yordan Kovachev
*author id: abdt361
*date created: 04/2012
*/
//This block check if the customer is logged in or not
session_start();
if(!isset($_SESSION["customer"])){
	header("location: customer_login.php");
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
echo 'Do you really want to delete your details' .$_GET['deleteid'].'?<a href="customer_details.php?yesdelete='.$_GET['deleteid'].'">Yes</a>|<a href="customer_details.php">No</a>';
exit();	
}
if (isset($_GET['yesdelete'])){
	//Delete customer details from the system
	$id_to_delete = $_GET['yesdelete'];
	$sql = "DELETE FROM customer WHERE id='$id_to_delete'";
	$res = iQuery($sql);
	header("location: customer_details.php");
	exit();
}
?>
<?php
//Parse the information from the customer update details form on to the system
if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['dob']) && isset($_POST['gender']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password'])){

$firstname = ($_POST['firstname']);
$lastname = ($_POST['lastname']);
$dob = ($_POST['dob']);
$gender = ($_POST['gender']);
$phone = ($_POST['phone']);
$email = ($_POST['email']);
$username = ($_POST['username']);
$password = ($_POST['password']);

//Check if the new customer detials exists in the db already
$sql = "SELECT * FROM customer WHERE firstname='$firstname'";
$res = query($sql);
if($res) {
	//evaluate the count
echo 'The customer details are already on the system. Please add new details, <a href="customer_details.php">Update Details</a>';
	exit();
		}
	//add this information to the databse now
$sql = "INSERT INTO customers (firstname, lastname, dob, gender, phone, email, username, password) VALUES('$firstname','$lastname','$dob','$gender','$phone', '$email', username, password)";
// Execute the query
$insert = iQuery($sql);
$cid = $_SESSION['lastInsertID'];
}
?>
<?php
//This block gathers the data from the db in order to be displayed later on the webpage
$details_list = "";
$sql = "SELECT * FROM customers";
$res = query($sql); // Get the output from products in the database
if($res) {
foreach ($res as $row) {
		$firstname = $row["firstname"];
		$lastname = $row["lastname"];
		$dob = strftime("%b %d %Y",strtotime($row["dob"]));
		$gender = $row["gender"];
		$phone = $row["phone"];
		$email = $row["email"];
		$username = $row["username"];
		$password = $row["password"];
		$details_list .= "$firstname - $lastname - $dob - $gender - $phone - $email &nbsp;&nbsp;<a href='cust_details_update.php?cid=$id'>Edit</a>&bull;<a href='cust_details_update.php?deleteid=$id'>Delete</a><br/>"; //the period will compund all product from the database and they will be displayed
}
}else{
	$product_list = "You have no details set yet";
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
    <div align="center"; style="margin-right: 24px; width: 920px; margin-left:auto; margin-right:auto; border: 1px solid #000;">
  </div>
	<div id="pageContent" align="center" style="width:920px;"><br/>
    <div align="right" style="padding-right:120px; padding-top: 20px; margin-left:auto; margin-right:auto; width:920px"><a href="../customer/c_home.php"><strong>Back to My Account</strong></a></div>
   	 <div align="left"; style="padding-left: 24px; width:920px; margin-left:auto; margin-right:auto;">
       <h1 style="text-align:left; color:#900;">Manage Personal Details :</h1>
       <h2>Here you can update your personal information<br/><br/></h2>
       <?php echo $details_list;?>
</div>
     <h3>Enter Your New Personal Details</h3>
     <table width="920px" border="1">
         <tr>
           <td width="30%" height="27" align="right" valign="top" bgcolor="#FFFFFF"><strong><a href="../customer/cust_details_update.php">Manage Personal Details</a></strong></td>
           <td width="73%" colspan="3" rowspan="2" align="center" bgcolor="#CCCCCC">
            <form action="../admin/inventory_edit.php?pid=<?php echo $targetID; ?>" enctype="multipart/form-data" name="myForm" id="myForm" method="POST">
     <table width="720px" border="0" cellspacing="0" cellpadding="5">
       <tr>
         <td width="149" align="right">Product Name</td>
         <td width="551"><label>
         <input name="productName" type="text" id="productName" size="52" value="<?php echo $productName;?>"/>
         </label>*</td>
       </tr>
       <tr>
         <td align="right">Product Price</td>
         <td><label>
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
           </td>
         </tr>
         <tr align="right" valign="top" bgcolor="#FFFFFF">
           <td>&nbsp;</td>
         </tr>
       </table>
     <br/>
     <br/>
  </div>
<?php include_once("../store/template_footer.php");?>
</div>
</body>
</html>