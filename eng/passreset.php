<?php
if (!isset($_SESSION)) {
  session_start();
}
?>
<?php
	// Require connection
	require_once('../Connections/connection.php');
	// Require DB functions
	require_once('../inc/db_functions.php');
	// Require General functions
	require_once('../inc/general_functions.php');			
	// Require Globals
	require_once('../inc/globals.php');		
?>
<?php
	

	// Error variable
	$error = "";
	
	// If form was submitted
	if (isset($_POST['reset']) && $_POST['reset']==1) {	
	
		// Set variables
		$email=$_POST['usuario_email'];

		// Check username query
		$query_Recordset1 = sprintf("SELECT usuario.usuario_id FROM usuario WHERE usuario_email=%s",
							GetSQLValueString($email, "text"));	
		$Recordset1 = mysql_query($query_Recordset1, $connection) or die("Database error.");
		$foundUser = mysql_num_rows($Recordset1);
		
		// If user was found
		if ($foundUser) {
		
			// Generate password
			$genpassword = createPassword(8);

			// Update password
			$updateSQL = sprintf("UPDATE usuario SET usuario_pass=SHA1(%s), usuario_passreset=1 WHERE usuario_email=%s LIMIT 1",
							GetSQLValueString($genpassword, "text"), 
							GetSQLValueString($email, "text"));
			$Result1 = mysql_query($updateSQL, $connection) or die("Database error.");		

			// Send e-mail			
			$headers = "MIME-Version: 1.0\n";			
			$headers .= "Content-type: text/plain; charset=UTF-8\n";								
			$headers .= "Content-Transfer-Encoding: quoted-printable\n";			
			$headers .= "From: \"".$email_from_name."\" <".$email_from_address.">\n";					
			$subject = "Password reset";			
			$body = "Your new password is: ".$genpassword."\n\n";			
			$body .= "Once you're logged-in you can change it by going to the \"Your Account\" section of the site.\n\n";
			$body .= $email_from_name;		
			$body = str_replace("=0A","\n",imap_8bit($body));			
			mail($email, $subject, $body, $headers); 			
						
			// Redirect to confirmation page
			header("Location: passreset_instructions.php");
						
		} else {
			$error = "Error: No valid user was found with the provided e-mail address.";
		} // End: If user was found		
	
	} // End: If form was submitted 			
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Millarville Web Site - Password Reset</title>
<?php include('../inc/library.php'); ?>
<script language="javascript" type="text/javascript">
$(document).ready(function() {
	$("#frmReset").validate({		
		rules: {							
			"usuario_email": {required: true, email: true}
		}
	});	
});
</script>
</head>

<body>
<div align="center">
	<?php include('inc/header.php');?>
    <div id="main">    
        <?php include('inc/menu.php');?>
        <div id="separator" /></div>
    	<div id="content">  
            <div id="innercontent">  
                      
            	<h1 class="header1">Password Reset</h1>
                <hr />
                <p class="f_12 f_white">Please enter the following information to reset your password:</p>				
                <form name="frmReset" id="frmReset" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="formReset">
                    <p>
                        <label for="usuario_email">E-mail *</label>
                        <input type="text" name="usuario_email" id="usuario_email" maxlength="255" />
                    </p>
                    <p>
                    	<input type="hidden" name="reset" id="reset" value="1" />
                        <input type="submit" name="submit" id="submit" value="RESET" />
                    </p>
                </form>
                <?php
					if ($error!="") {
						echo '<p class="txterror">'.$error.'</p>';
					}
				?>
                                                                                                   
            </div>                    		                   
        </div>
        <?php include('inc/bottom.php');?>
    </div> 
</div>
</body>
</html>