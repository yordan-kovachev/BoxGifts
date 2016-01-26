<!-- Created by
author name: Yordan Kovachev
author id: abdt361
date created: 03/2012
-->
<div id="pageHeader"><table width="91
0" height="35" border="1" align="center" cellpadding="12">
  <tr>
    <td width="321"><a href="http://boxgifts.yordan.co.uk/store/index.php"><img src="http://boxgifts.yordan.co.uk/Images/box_gifts1.jpg" alt="Box Gifts - logo" width="600" height="60" border="0"></a></td>
    <td width="280px" align="right"><table width="270" border="1" cellpadding="5" cellspacing="5">
      <tr>
        <td align="right" valign="middle" bgcolor="#F0F0F0">
		<?php
        if(isset($_SESSION['customer']) && $_SESSION['customer']!="")
			{
			echo "Hello: '$_SESSION[customer]', here you can:"; // displays customer name
     		echo ("<a href='../store/storescripts/logout.php'><strong>Logout</strong></a>");
			}
				else
				{
      				echo ("<a href='../customer/customer_login.php'><strong>Login</strong></a><br/>");
					echo ("New Customer: <a href='../customer/new_cust_register.php'>Register</a>");
				}
		?>
     </td>
      </tr>
      <tr>
        <td align="left" valign="middle" bgcolor="#F0F0F0"><strong><a href="../store/cart.php"> Your Shpping Cart</a></strong></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;&mdash;&nbsp;<a href="http://boxgifts.yordan.co.uk/store/index.php">Home</a>&nbsp;&mdash;&nbsp;<a href="#">Boy</a>&nbsp;&mdash;&nbsp;<a href="#">Girl</a>&nbsp;&mdash;&nbsp;<a href="#">Twins</a>&nbsp;&mdash;&nbsp;<a href="#">Unisex</a>&nbsp;&mdash;&nbsp;</td>
    </tr>
    </table>
</div>