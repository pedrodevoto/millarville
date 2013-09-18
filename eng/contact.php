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
	// Confirmation messages		
	if (isset($_GET["confirm_send"]) && $_GET["confirm_send"]=="1") {
		$confirm_send = "Message was sent.";
	} else {
		$confirm_send = "";		
	}
	if (isset($_GET["confirm_suscribe"]) && $_GET["confirm_suscribe"]=="1") {
		$confirm_suscribe = "Your e-mail address was added to our mailing list.";
	} else {
		$confirm_suscribe = "";		
	}	

	// If form submitted (send)
	if (isset($_POST["send"]) && $_POST["send"]=="1") {	
	
		// If suscription selected, insert
		if (isset($_POST["suscribir"]) && $_POST["suscribir"]=="1") {			
			$insertSQL = sprintf("INSERT INTO mailing (mailing_email) VALUES (TRIM(%s))",
							GetSQLValueString($_POST['email'], "text"));						
			$Result1 = mysql_query($insertSQL, $connection);
		}
		
		// Send e-mail			
		$headers = "MIME-Version: 1.0\n";			
		$headers .= "Content-type: text/plain; charset=UTF-8\n";								
		$headers .= "Content-Transfer-Encoding: quoted-printable\n";			
		$headers .= "From: \"".$email_from_name."\" <".$email_from_address.">\n";					
		$subject = "Formulario de contacto";					
		$body = "Nombre: ".strip_tags(trim($_POST['nombre']))."\n";
		$body .= "Teléfono: ".strip_tags(trim($_POST['tel']))."\n";
		$body .= "E-mail: ".strip_tags(trim($_POST['email']))."\n\n";
		$body .= strip_tags(trim($_POST['comentario']))."\n\n";																
		$body .= $email_from_name;
		$body = str_replace("=0A","\n",imap_8bit($body));			
		mail($email_to_contact, $subject, $body, $headers); 

		// Redirect to self (avoid multiple submissions)
		header("Location: ".$_SERVER['PHP_SELF']."?confirm_send=1");
		die();		
		
	} // End: If form submitted (send)
	
	// If form submitted (suscribe)	
	if (isset($_POST["suscribe"]) && $_POST["suscribe"]=="1") {	
	
		// Insert
		$insertSQL = sprintf("INSERT INTO mailing (mailing_email) VALUES (TRIM(%s))",
						GetSQLValueString($_POST['mailing_email'], "text"));						
		$Result1 = mysql_query($insertSQL, $connection);	
		
		// Redirect to self (avoid multiple submissions)
		header("Location: ".$_SERVER['PHP_SELF']."?confirm_suscribe=1");
		die();			
		
	} // End: If form submitted (suscribe)	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Millarville Web Site - Contact</title>
<?php include('../inc/library.php'); ?>
<script language="javascript" type="text/javascript">
$(document).ready(function() {
	$("#frmContact").validate({		
		rules: {							
			"nombre": {required: true},
			"tel": {required: true},			
			"email": {required: true, email: true},
			"comentario": {required: true, maxlength: 1024}
		},
		messages: {
			"nombre": "Required",
			"tel": "Required",
			"email": "Required",
			"comentario": "Required"			
		}
	});
});
</script>
<style>
	html{
		height:100%;
	}
</style>
</head>

<body>
<div align="center" class="deg">
	<?php include('inc/header.php');?>
    <div id="main">
        <?php include('inc/menu.php');?>
        <div id="separator6"></div>
    	<div id="content">
        	<div style="width:797px;">
                <div style="float:left; width:47%; text-align:right">
                    <img src="../img/contact.jpg" width="398" height="329" />            
                </div>
    
                <div style="float:right; width:314px; text-align:left; margin-top:85px;" class="f_white f_12">
                    <div style="width:314px;" class="f_yellow f_15">
                      <a href="mailto:info@millarville.com.ar" class="f_yellow f_15">info@millarville.com.ar</a>
                      <div id="separator1"></div>
                        <form name="frmContact" id="frmContact" action="<?php echo($_SERVER['PHP_SELF']); ?>" method="post" class="formContact">
                            <p>
                                <label for="nombre">NAME *</label>
                                <input type="text" name="nombre" id="nombre" maxlength="255" />                           
                            </p>
                            <p>
                                <label for="tel">PHONE *</label>
                                <input type="text" name="tel" id="tel" maxlength="255" />
                            </p>
                            <p>
                                <label for="email">E-MAIL *</label>
                                <input type="text" name="email" id="email" maxlength="255" />
                            </p>
                            <p>
                                <label for="comentario">COMMENT *</label>
                                <textarea name="comentario" id="comentario"></textarea>
                            </p>
                            <p style="float:right">
                                <input type="hidden" name="send" id="send" value="1"  />
                                <input type="submit" name="submitSend" id="submitSend" value="SEND" />
                            </p>
                        </form>                   
                        <?php 
                            if ($confirm_send!="") {
                                echo '<p class="f_10 f_white" align="left">'.$confirm_send.'</p>';
                            }
                        ?> 
                     </div>
                </div>
            </div>
            <br clear="all" />
		</div>            
        <?php include('inc/bottom.php');?>
    </div>
</div>
</body>
</html>