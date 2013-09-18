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
		$confirm_send = "Mensaje enviado.";
	} else {
		$confirm_send = "";		
	}
	if (isset($_GET["confirm_suscribe"]) && $_GET["confirm_suscribe"]=="1") {
		$confirm_suscribe = "La dirección fue agregada a nuestro newsletter.";
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
<title>Millarville Web Site - Contacto</title>
<?php include('../inc/library.php'); ?>
<script src="../js/messages_es.js"></script>
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
			"nombre": "Requerido",
			"tel": "Requerido",
			"email": "Requerido",
			"comentario": "Requerido"			
		}
	});
	$("#frmSuscribe").validate({		
		rules: {								
			"mailing_email": {required: true, email: true}
		},
		messages: {
			"mailing_email": "Requerido"			
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
        <div id="separator"></div>
    	<div id="content">
            <div style="float:left; width:47%; text-align:right">
                <img src="../img/contact.jpg" width="234" height="372" />            
            </div>

        	<div style="float:right; width:47%; text-align:left" class="f_white f_12">
            	<div style="width:348px;" class="f_yellow f_11">
					Envíenos un e-mail a <a href="mailto:info@millarville.com.ar" class="f_yellow">info@millarville.com.ar</a> o complete el siguiente formulario. Los campos marcados con un asterisco (*) son obligatorios.
                    <div id="separator1"></div>
                    <form name="frmContact" id="frmContact" action="<?php echo($_SERVER['PHP_SELF']); ?>" method="post" class="formContact">
                    	<p>
                            <label for="nombre">NOMBRE *</label>
                            <input type="text" name="nombre" id="nombre" maxlength="255" />                           
                        </p>
                        <p>
                            <label for="tel">TELÉFONO *</label>
                            <input type="text" name="tel" id="tel" maxlength="255" />
                        </p>
                        <p>
                            <label for="email">E-MAIL *</label>
                            <input type="text" name="email" id="email" maxlength="255" />
                        </p>
                        <p>
                            <label for="comentario">COMENTARIO *</label>
                            <textarea name="comentario" id="comentario"></textarea>
                        </p>
                        <p>
	                        <label for="suscribir" class="secondary">Suscribirse al newsletter</label>
                            <input type="checkbox" name="suscribir" id="suscribir" value="1" />
                        </p>
                        <p>
                        	<input type="hidden" name="send" id="send" value="1"  />
	                        <input type="submit" name="submitSend" id="submitSend" value="ENVIAR" />
                        </p>
                    </form>                   
					<?php 
                        if ($confirm_send!="") {
                            echo '<p class="f_10 f_white" align="left">'.$confirm_send.'</p>';
                        }
                    ?> 
					<div id="separator2"></div>
                    <form name="frmSuscribe" id="frmSuscribe" action="<?php echo($_SERVER['PHP_SELF']); ?>" method="post" class="formContact">                        
                    	<p>
                            <label for="mailing_email">RECIBIR NOVEDADES MILLARVILLE EN SU E-MAIL *</label>
                            <input type="text" name="mailing_email" id="mailing_email" maxlength="255" />                           
                        </p>  
                        <p>
                        	<input type="hidden" name="suscribe" id="suscribe" value="1"  />
	                        <input type="submit" name="submitSuscribe" id="submitSuscribe" value="SUSCRIBIRSE AHORA" />
                        </p>                                              
                    </form>
					<?php 
                        if ($confirm_suscribe!="") {
                            echo '<p class="f_10 f_white" align="left">'.$confirm_suscribe.'</p>';
                        }
                    ?>                                         
                </div>
			</div>
            <br clear="all" />
		</div>            
        <?php include('inc/bottom.php');?>
    </div>
</div>
</body>
</html>