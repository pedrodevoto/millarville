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
	// Require Globals
	require_once('../inc/globals.php');		
?>
<?php
	// General variables
	$error = "";		

	// If form submitted
	if (isset($_POST["insert"]) && $_POST["insert"]=="1") {		
		
		// Insert
		$insertSQL = sprintf("INSERT INTO usuario (usuario_email, usuario_pass, usuario_pais, usuario_nombre, usuario_apellido, usuario_empresa, usuario_direccion1, usuario_direccion2, usuario_ciudad, usuario_estado, usuario_cp, usuario_tel) VALUES (TRIM(%s), SHA1(%s), TRIM(%s), TRIM(%s), TRIM(%s), TRIM(%s), TRIM(%s), TRIM(%s), TRIM(%s), TRIM(%s), TRIM(%s), TRIM(%s))",
						GetSQLValueString($_POST['usuario_email'], "text"),
						GetSQLValueString($_POST['usuario_pass1'], "text"),
						GetSQLValueString($_POST['usuario_pais'], "text"),					
						GetSQLValueString($_POST['usuario_nombre'], "text"),					
						GetSQLValueString($_POST['usuario_apellido'], "text"),	
						GetSQLValueString($_POST['usuario_empresa'], "text"),					
						GetSQLValueString($_POST['usuario_direccion1'], "text"),					
						GetSQLValueString($_POST['usuario_direccion2'], "text"),																																							
						GetSQLValueString($_POST['usuario_ciudad'], "text"),					
						GetSQLValueString($_POST['usuario_estado'], "text"),					
						GetSQLValueString($_POST['usuario_cp'], "text"),
						GetSQLValueString($_POST['usuario_tel'], "text"));						
		$Result1 = mysql_query($insertSQL, $connection);
		switch (mysql_errno()) {
			case 0:
			
				// Send e-mail			
				$headers = "MIME-Version: 1.0\n";			
				$headers .= "Content-type: text/plain; charset=UTF-8\n";								
				$headers .= "Content-Transfer-Encoding: quoted-printable\n";			
				$headers .= "From: \"".$email_from_name."\" <".$email_from_address.">\n";					
				$subject = "Your registration";			
				$body = "Thank you for registering, ".strip_tags(trim($_POST['usuario_nombre']))." ".strip_tags(trim($_POST['usuario_apellido'])).".\n\n";							
				$body .= "You can start shopping right now by visting our site: http://www.".$site_domain."\n\n";							
				$body .= "Best regards,\n\n";
				$body .= $email_from_name;
				$body = str_replace("=0A","\n",imap_8bit($body));			
				mail(strip_tags(trim($_POST['usuario_email'])), $subject, $body, $headers); 

				// Redirect URL
				$redirectURL = "login.php?register=true";
				
				// Check if directed from Shopping Cart
				if (isset($_POST['accesscheck']) && $_POST['accesscheck']!="") {
					$redirectURL .= "&accesscheck=".urlencode($_POST['accesscheck']);
				}
						
				// Redirect to confirmation page
				header("Location: ".$redirectURL);				
			
				break;
			case 1062:
				$error = "The e-mail address you provided is already in use. If you are already registered, please login.";							
				break;
			default:
				$error = "Database error.";
				break;
		}
		
	} // End: If form was submitted
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Millarville Web Site - Registration</title>
<?php include('../inc/library.php'); ?>
<script language="javascript" type="text/javascript">
$(document).ready(function() {
	$("#frmRegister").validate({
		rules: {							
			"usuario_nombre": {required: true},
			"usuario_apellido": {required: true},
			"usuario_tel": {required: true},
			"usuario_email": {required: true, email: true},
			"usuario_pass1": {required: true, minlength: 8},
			"usuario_pass2": {required: true, minlength: 8, equalTo: "#usuario_pass1"},
			"usuario_direccion1": {required: true},		
			"usuario_ciudad": {required: true},
			"usuario_cp": {required: true},
			"usuario_estado": {required: true},
			"usuario_pais": {required: true}
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
                      
            	<h1 class="header1">Registration</h1>
                <hr />                      
                         
                <p class="f_white f_12">Please complete the following information.<br /> 
                <strong>Fields marked with an asterisk (*) are mandatory.</strong></p>                                  
                <form name="frmRegister" id="frmRegister" action="<?php echo($_SERVER['PHP_SELF']); ?>" method="post" class="formRegAccount">
                	<p>
                        <label for="usuario_nombre">Name *</label>
                        <input type="text" name="usuario_nombre" id="usuario_nombre" maxlength="255" value="<?php if (isset($_POST['usuario_nombre'])) echo $_POST['usuario_nombre']; ?>" />
					</p>
                    <p>
                        <label for="usuario_apellido">Surname *</label>
                        <input type="text" name="usuario_apellido" id="usuario_apellido" maxlength="255" value="<?php if (isset($_POST['usuario_apellido'])) echo $_POST['usuario_apellido']; ?>" />
					</p>
                    <p>                        
                        <label for="usuario_empresa">Company</label>
                        <input type="text" name="usuario_empresa" id="usuario_empresa" maxlength="255" value="<?php if (isset($_POST['usuario_empresa'])) echo $_POST['usuario_empresa']; ?>" />
					</p>
                    <p>                        
                        <label for="usuario_tel">Phone number *</label>
                        <input type="text" name="usuario_tel" id="usuario_tel" maxlength="255" value="<?php if (isset($_POST['usuario_tel'])) echo $_POST['usuario_tel']; ?>" />
					</p>
                    <p>                        
                        <label for="usuario_email">E-mail *</label>
                        <input type="text" name="usuario_email" id="usuario_email" maxlength="255" />
					</p>
                    <p>                        
                        <label for="usuario_pass1">Password *</label>
                        <input type="password" name="usuario_pass1" id="usuario_pass1" maxlength="32" value="<?php if (isset($_POST['usuario_pass1'])) echo $_POST['usuario_pass1']; ?>" />
					</p>
                    <p>                        
                        <label for="usuario_pass2">Repeat password *</label>
                        <input type="password" name="usuario_pass2" id="usuario_pass2" maxlength="32" value="<?php if (isset($_POST['usuario_pass2'])) echo $_POST['usuario_pass2']; ?>" />
					</p>
                    <p>                        
                        <label for="usuario_direccion1">Address line 1*</label>
                        <input type="text" name="usuario_direccion1" id="usuario_direccion1" maxlength="255" value="<?php if (isset($_POST['usuario_direccion1'])) echo $_POST['usuario_direccion1']; ?>" />
					</p>
                    <p>                        
                        <label for="usuario_direccion2">Address line 2</label>
                        <input type="text" name="usuario_direccion2" id="usuario_direccion2" maxlength="255" value="<?php if (isset($_POST['usuario_direccion2'])) echo $_POST['usuario_direccion2']; ?>" />
					</p>
                    <p>                        
                        <label for="usuario_ciudad">City *</label>
                        <input type="text" name="usuario_ciudad" id="usuario_ciudad" maxlength="255" value="<?php if (isset($_POST['usuario_ciudad'])) echo $_POST['usuario_ciudad']; ?>" />
					</p>
                    <p>                        
                        <label for="usuario_cp">ZIP/Postal code *</label>
                        <input type="text" name="usuario_cp" id="usuario_cp" maxlength="255" value="<?php if (isset($_POST['usuario_cp'])) echo $_POST['usuario_cp']; ?>" />
					</p>
                    <p>                        
                        <label for="usuario_estado">State *</label>
                        <input type="text" name="usuario_estado" id="usuario_estado" maxlength="255" value="<?php if (isset($_POST['usuario_estado'])) echo $_POST['usuario_estado']; ?>" />
					</p>
                    <p>                        
                        <label for="usuario_pais">Country *</label>
                        <input type="text" name="usuario_pais" id="usuario_pais" maxlength="255" value="<?php if (isset($_POST['usuario_pais'])) echo $_POST['usuario_pais']; ?>" />
					</p>
                    <p>                        
                        <input type="hidden" name="insert" id="insert" value="1" />
                        <input type="hidden" name="accesscheck" id="accesscheck" value="<?php if(isset($_GET['accesscheck'])) { echo $_GET['accesscheck']; } ?>"  />
                        <input type="submit" name="register" id="register" value="REGISTER" />
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