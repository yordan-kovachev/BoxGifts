<?php
/*Created by
*author name: Yordan Kovachev
*author id: abdt361
*date created: 04/2012
*/
//Start new session - this will help the url remember what has been added as a product to the cart
session_start();
//Now establish DB connection
///
include_once('storescripts/config.php');
//Error reporting
error_reporting(E_ALL);
ini_set('display_error', '1');
?>
<?php
//////////// Part 1 - If the customer wants to add a product to the shopping cart
////////////
if (isset($_POST['pid'])){
	$pid = $_POST['pid'];
	$wasFound = false;
	$i = 0;
	//if the cart session variable is not set or cart arrray is empty
	if(!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1) {
	//Now create a multy dimensional array where it will hold information for each product id an dit s quantity
	//first thing first - run if the cart is empty or not set with product
	$_SESSION["cart_array"] = array(0 => array("item_id" => $pid, "quantity" => 1));
	}else{
	//run if the cart has at least one product added by the customer
		foreach ($_SESSION["cart_array"] as $each_item){
			$i++;
			while (list($key, $value) = each($each_item)){
			if($key == "item_id" && $value == $pid){
				//this item is in the cart already. Now I can edjust its quantity using array_splice() funtion
				array_splice($_SESSION["cart_array"], $i-1, 1, array(array("item_id" => $pid, "quantity" => $each_item['quantity'] + 1)));
				$wasFound = true;
		} //end of if condition
	} //end of while loop
} //end of foreach loop

//now if there is no product added to the cart and the customer wants to add it to the cart then the folowing if condition will 'push' a new array which will be nested in the multidimentional array set above.
if ($wasFound == false){
	array_push($_SESSION["cart_array"], array("item_id" => $pid, "quantity" => 1));
	 }
}
header("location: cart.php"); //this will prevent the user to add extra quantity for each product when he/she press the refresh button on their browser.
exit; // exit the loop
}
?>
<?php
//////////// Part 2 - If the customer wants to empty their cart
////////////
if (isset($_GET['cmd']) && $_GET['cmd'] == "emptycart"){
	unset($_SESSION["cart_array"]);
	}
?>
<?php
//////////// Part 3 - If the customer wants to adjust the product quantity
////////////
if (isset($_POST['item_to_adjust']) && $_POST['item_to_adjust'] !=""){ //now I need to initialise the local variable before accessing its value from the array

	$item_to_adjust = $_POST['item_to_adjust'];
	$quantity = $_POST['quantity'];
	$quantity = preg_replace('#[^0-9]#i', '', $quantity);
	if($quantity >= 100){$quantity = 99;}
	if($quantity < 1){$quantity = 1;}
	if($quantity ==""){$quantity = 1;}
	$i = 0;
	foreach ($_SESSION["cart_array"] as $each_item){
			$i++;
			while (list($key, $value) = each($each_item)){
			if($key == "item_id" && $value == $item_to_adjust){
				//this item is in the cart already. Now I can edjust its quantity using array_splice() funtion
				array_splice($_SESSION["cart_array"], $i-1, 1, array(array("item_id" => $item_to_adjust, "quantity" => $quantity)));
		} //end of if condition
	} //end of while loop
} //end of foreach loop
header("location: cart.php");
	exit();
	}
?>
<?php
//////////// Part 4 - If the customer wants to delete or remove an item/product from the shopping bakset
////////////
if (isset($_POST['index_to_remove']) && $_POST['index_to_remove'] !="") {
	//this will access the array index and also remove that array index quantity - index refer to the unique item already in the array
	
	$key_to_remove = $_POST['index_to_remove']; //assign variable to index_to_remove
	//echo 'index -'.$index_to_temove.' : Count -'; //Test - display the quantity of the index minus the sount
	if (count($_SESSION["cart_array"]) <= 1) { //count cart array and if it is less or equal to 1clear its value
	unset($_SESSION["cart_array"]);
	}else{
		unset($_SESSION["cart_array"]["$key_to_remove"]); //This will clear the selected key_to_remove from the cart_array
		sort($_SESSION["cart_array"]); //this will reorder or sort the array where the que will move one step ahead in the multy-dimentional array.
		//echo count($_SESSION["cart_arrray"]); //test 2 - count the number for the product that is in the basket/array
	}
}
?>
<?php
//////////// Part 5 - This will display the cart details to the customer.
////////////
$cartOutput = "";
$cartTotal = "";
$pp_checkout_btn='';
$product_id_array='';
if (!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1){
	$cartOutput = "<h2 align='center'>Your Shopping Basket is Empty</h2>";
	
	}else{
	
	//Start Paypal checkout button
	$pp_checkout_btn .='<form action="https://www.sandbox.paypal.com/cgibin/webscr" method="post">
<input type="hidden" name="cmd" value="_cart">
<input type="hidden" name="upload" value="1">
<input type="hidden" name="business" value="boxgifts.test@gmail.com">';
	
	//Start the foreachloop
	$i = 0;
	foreach ($_SESSION["cart_array"] as $each_item){
		$item_id = $each_item['item_id']; //assign the item_id that is hold in the multidimentional array to the local function $item_id
		$sql = "SELECT * FROM products WHERE id='$item_id' LIMIT 1";
		$res = query($sql); // Get the output from products in the database
		foreach ($res as $row){
			$productName = $row["productName"];
			$productPrice = $row["productPrice"];
			$productDescription = $row["productDescription"];	
		}
		$priceTotal = $productPrice * $each_item['quantity'];
		$cartTotal = $priceTotal + $cartTotal;
setlocale(LC_MONETARY, "en");
$priceTotal = money_format("%10.2n", $priceTotal);

		//Dynamic Checkout Button Assembly
		$x = $i + 1; //it will set the item number to initialise from 1 as PayPal requirement
		$pp_checkout_btn .='<input type="hidden" name="item_name_'.$x.'" value="'.$productName.'">
		<input type="hidden" name="amount_'.$x.'" value="'.$productPrice.'">
		<input type="hidden" name="quantity_'.$x.'" value="'.$each_item['quantity'].'">';
		
//Create the product array variable
$product_id_array .= "$item_id-".$each_item['quantity'].",";

////////////////////Dynamic Table row for the shopping basket
		$cartOutput .= '<tr>';
		$cartOutput .= '<td><a  href="product.php?id='.$item_id.'">'.$productName.'</a><br/><img src="../Images/Products/'.$item_id.'.jpg" alt="'.$productName.'"width="100" height="130" border="2"/></td>'; //back slashes are one way to escape errors and render the links corectly		
		$cartOutput .= '<td>' .$productDescription. '</td>'; //this will display and let me know the value from the array for product id
		$cartOutput .= '<td>£' .$productPrice. '</td>'; // hence this line will pull out the item quantity
		$cartOutput .= '<td>
		<form action="cart.php" method="post">
		<input name="quantity" type="text" value="' . $each_item['quantity']. '" size="1" maxlength="2">
		<input name="adjustBtn' .$item_id. '" type="submit" value="Update"/>
		<input name="item_to_adjust" type="hidden" value="' .$item_id. '"/>
		</form>
		</td>';
		$cartOutput .= '<td>£' .$priceTotal. '</td>';
		$cartOutput .= '<td>
		<form action="cart.php" method="post">
		<input name="Delete Product" type="submit" value="Delete Product "' . $item_id . '""/>
		<input name="index_to_remove" type="hidden" value="'.$i.'"/>
		</form>
		</td>'; //this button will remove the unique index ID for the particular item/product in the multy-dimentional array created above
	
		setlocale(LC_MONETARY, "en");
		$cartTotal = money_format("%10.2n", $cartTotal);
		$cartOutput .= '<tr>';
		$i++;
	}
	
	//Fininsh the PayPal Checkout Button
	$pp_checkout_btn .='<action="https://www.sandbox.paypal.com/cgibin/webscr" method="post">
	<input type="hidden" name="item_number" value="' .$item_id. '">
	<input type="hidden" name="item_name" value="' . $productName. '">
	<input type="hidden" name="amount" value="' .$each_item['quantity'].'">
	<input type="hidden" name="custom" value="' .$product_id_array. '">
	<input type="hidden" name="upload" value="1">
	<input type="hidden" name="cmd" value="_cart">
	<input type="hidden" name="business" value="boxgifts.test@gmail.com">
	<input type="hidden" name="notify_url" value="http://kovachev.dreamhosters.com/store/storescripts/paypal_ipn.php">
	<input type="hidden" name="business" value="boxgifts.test@gmail.com">
	<input type="hidden" name="lc" value="GB">
	<input type="hidden" name="currency_code" value="GBP">
	<input type="hidden" name="upload" value="1">
	<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHostedGuest">
	<input type="image" src="https://www.sandbox.paypal.com/en_US/GB/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal — The safer, easier way to pay online.">
	<img alt="" border="1" src="https://www.sandbox.paypal.com/en_GB/i/scr/pixel.gif" width="1" height="1">
	<input type="hidden" name="return" value="http://kovachev.dreamhosters.com/store/order_completed" >
	</form>';
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>My Basket</title>
<link rel="stylesheet" href="../css/mainStyle.css" type="text/css" media="screen">
</head>
<body>
	<div align="center" style="width:920px; margin-left:auto; margin-right:auto;" id="mainWrapper">
    <?php include_once("template_header.php");?>
    <div id="pageContent" style="width:920px; margin-left:auto; margin-right:auto; border-bottom-width: 2px"><h1><strong>Shopping List</strong></h1>
    <div style="margin:15px; text-align:left;"><br/>
    <table width="100%" border="1" cellpadding="6" cellspacing="0">
      <tr>
        <td width="143" bgcolor="#D6D2FF"><strong>Product</strong></td>
        <td width="232" bgcolor="#D6D2FF"><strong>Product Description</strong></td>
        <td width="63" bgcolor="#D6D2FF"><strong>Price</strong></td>
        <td width="68" bgcolor="#D6D2FF"><strong>Quantity</strong></td>
        <td width="58" bgcolor="#D6D2FF"><strong>Total</strong></td>
        <td width="70" bgcolor="#D6D2FF"><strong>Delete Item</strong></td>
      </tr>
      <?php echo $cartOutput; ?>
    </table>
    <table width="200" border="1" cellpadding="5" cellspacing="5" style="width:390px; margin-left:500px">
      <tr bgcolor="#FFFFFF">
        <td align="left" valign="middle"><strong><em>Your Total Price:</em></strong> £ <?php echo $cartTotal; ?></td>
        <td align="center" valign="middle"><a href="cart.php?cmd=emptycart"><strong>Empty My Basket</strong></a></td>
      </tr>
    </table>
    <br/>
    <div align="right" style="padding:10px;">
    <?php echo  $pp_checkout_btn; ?>
    </div>
    </div>
    </div>
    <?php include_once("template_footer.php");?>
</div>
</body>
</html>
