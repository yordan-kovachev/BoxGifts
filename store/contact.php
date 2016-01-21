<!-- Created by
author name: Yordan Kovachev
author id: abdt361
date created: 03/2012
-->
<?php

// Set email variables
$email_to = 'boxgifts.test@gmail.com';
$email_subject = 'Customer Feedback';

// Set required fields
$required_fields = array('fullname','email','comment');

// set error messages
$error_messages = array(
	'fullname' => 'Please enter your Name.',
	'email' => 'Please enter your Email Address.',
	'comment' => 'Please enter your Message.'
);

// Set form status
$form_complete = FALSE;

// configure validation array
$validation = array();

// check form submition
if(!empty($_POST)) {
	// Sanitise POST array
	foreach($_POST as $key => $value) $_POST[$key] = remove_email_injection(trim($value));
	
	// Loop into required fields and make sure they match our needs
	foreach($required_fields as $field) {		
		// the field has been submitted?
		if(!array_key_exists($field, $_POST)) array_push($validation, $field);
		
		// check there is information in the field?
		if($_POST[$field] == '') array_push($validation, $field);
		
		// validate the email address supplied
		if($field == 'email') if(!validate_email_address($_POST[$field])) array_push($validation, $field);
	}
	
	// basic validation result
	if(count($validation) == 0) {
		// Prepare our content string
		$email_content = 'New Website Comment: ' . "\n\n";
		
		// simple email content
		foreach($_POST as $key => $value) {
			if($key != 'submit') $email_content .= $key . ': ' . $value . "\n";
		}
		
		// if validation passed ok then send the email
		mail($email_to, $email_subject, $email_content);
		
		// Update form switch
		$form_complete = TRUE;
	}
}

function validate_email_address($email = FALSE) {
	return (preg_match('/^[^@\s]+@([-a-z0-9]+\.)+[a-z]{2,}$/i', $email))? TRUE : FALSE;
}

function remove_email_injection($field = FALSE) {
   return (str_ireplace(array("\r", "\n", "%0a", "%0d", "Content-Type:", "bcc:","to:","cc:"), '', $field));
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>


	<title>BoxGifts-Contact us</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/contactform.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/mootools/1.3.0/mootools-yui-compressed.js"></script>
    <script type="text/javascript" src="contact/validation/validation.js"></script>
    
<script type="text/javascript">
var nameError = '<?php echo $error_messages['fullname']; ?>';
		var emailError = '<?php echo $error_messages['email']; ?>';
		var commentError = '<?php echo $error_messages['comment']; ?>';
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
</script>

</head>
<?php require_once('template_header.php'); ?>
<body onload="MM_preloadImages('contact/images/x.png')">
    
<div id="formWrap">

<h2>We appreciate your feedback</h2>

<div id="form">
<?php if($form_complete === FALSE): ?>
<form action="contact.php" method="post" id="comments_form">

    
    <div class="row">
    <div class="label">Your Name</div><!--end .label-->
    <div class="input">
    <input type="text" id:"fullname" class="detail" name="fullname" value="<?php echo isset($_POST['fullname'])? $_POST['fullname'] : ''; ?>"/><?php if(in_array('fullname', $validation)): ?><span class="error"><?php echo $error_messages['fullname']; ?></span><?php endif; ?>
    </div><!--end .input-->
    <div class="content">e.g. John Smith</div><!-- end .contrent-->
    </div><!--end .row-->



	<div class="row">
    <div class="label">Your Email Address</div><!--end .label-->
    <div class="input">
    <input type="text" id:"email" class="detail" name="email" value="<?php echo isset($_POST['email'])? $_POST['email'] : ''; ?>"/>  <?php if(in_array('email', $validation)): ?><span class="error"><?php echo $error_messages['email']; ?></span><?php endif; ?>
    </div><!--end .input-->
    <div class="content">We will not share your email address or spam you either</div><!-- end .contrent-->
    </div><!--end .row-->



	<div class="row">
    <div class="label">Your Feedback</div><!--end .label-->
    <div class="input">
    <textarea id="comment" name ="comment" class="mess"><?php echo isset($_POST['comment'])? $_POST['comment'] : ''; ?></textarea><?php if(in_array('comment', $validation)): ?><span class="error"><?php echo $error_messages['comment']; ?></span><?php endif; ?>
    </div><!--end .input-->
    </div><!--end .row-->
    
    
    <div class="submit">
    <input type ="submit" id="submit" name="submit" value="Submit Feedback"/>
    </form>
    </div><!--end .submit-->
  
  
<?php else: ?>
    
<p style="font-size:35px; font-family:'Arial Black', Gadget, sans-serif; color:#033; margin-left:25px;">Thank you for your message!</p>

<script type="text/javascript">
window.location = "index.php"
setTimeout(5000);
</script>

<?php endif; ?>

</div><!--end form-->
</div><!--end formWrap-->

<?php require_once('template_footer.php'); ?>
</body>
</html>
