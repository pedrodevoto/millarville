<?php
if (!isset($_SESSION)) {
  session_start();
}
?>
<?php
	// Require security
	require_once('../inc/security.php');		
?>
<?php
	// Require connection
	require_once('../Connections/connection.php');
	// Require DB functions
	require_once('../inc/db_functions.php');	
?>
<?php
	// General variables
	if (isset($_GET["confirm"]) && $_GET["confirm"]=="true") {
		$message = "Su información ha sido actualizada.";
	} else {
		$message = "";			
	}

	// If form submitted
	if (isset($_POST["update"]) && $_POST["update"]=="1") {		
		
		// Update
		$updateSQL = sprintf("UPDATE usuario SET usuario_email = TRIM(%s), usuario_pass = IF(ISNULL(%s),usuario_pass,SHA1(%s)), usuario_passreset = IF(ISNULL(%s),usuario_passreset,0), usuario_pais = TRIM(%s), usuario_nombre = TRIM(%s), usuario_apellido = TRIM(%s), usuario_empresa = TRIM(%s), usuario_direccion1 = TRIM(%s), usuario_direccion2 = TRIM(%s), usuario_ciudad = TRIM(%s), usuario_estado = TRIM(%s), usuario_cp = TRIM(%s), usuario_tel = TRIM(%s) WHERE usuario.usuario_id = %s LIMIT 1",
						GetSQLValueString($_POST['usuario_email'], "text"),					
						GetSQLValueString($_POST['usuario_pass1'], "text"),
						GetSQLValueString($_POST['usuario_pass1'], "text"),
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
						GetSQLValueString($_POST['usuario_tel'], "text"),
						GetSQLValueString($_SESSION['User_MM_UserID'], "int"));										
		$Result1 = mysql_query($updateSQL, $connection);		
		switch (mysql_errno()) {
			case 0:						
				if (isset($_GET['checkout']) && $_GET['checkout']==1) {
					$location = "checkout.php";
				} else { 
					$location = $_SERVER['PHP_SELF']."?confirm=true";								
				}
				header("Location: ".$location);						
				break;
			case 1062:
				$message = "Error: La dirección de e-mail se encuentra en uso. Por favor especifique otra.";							
				break;				
			default:
				$message = "Database error.";
				break;
		}	
		
	} // End: If form was submitted
	
	// Recordset: Usuario
	$query_Recordset1 = sprintf("SELECT usuario_email, usuario_pais, usuario_nombre, usuario_apellido, usuario_empresa, usuario_direccion1, usuario_direccion2, usuario_ciudad, usuario_estado, usuario_cp, usuario_tel FROM usuario WHERE usuario_id = %s",
						GetSQLValueString($_SESSION['User_MM_UserID'], "int"));	
	$Recordset1 = mysql_query($query_Recordset1, $connection) or die("Database error.");
	$row_Recordset1 = mysql_fetch_assoc($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Millarville Web Site - Mi Cuenta</title>
<?php include('../inc/library.php'); ?>
<script src="../js/messages_es.js"></script>  
<script language="javascript" type="text/javascript">
$(document).ready(function() {
	$("#frmUpdate").validate({		
		rules: {							
			"usuario_nombre": {required: true},
			"usuario_apellido": {required: true},
			"usuario_tel": {required: true},
			"usuario_email": {required: true, email: true},			
			"usuario_pass1": {minlength: 8},
			"usuario_pass2": {minlength: 8, equalTo: "#usuario_pass1"},
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
                      
            	<h1 class="header1">Mi Cuenta</h1>
                <hr />                      
                         
                <p class="f_white f_12">Actualice su información.<br /> 
                <strong>Los campos marcados con un asterisco (*) son obligatorios.</strong></p>                                  
                <form name="frmUpdate" id="frmUpdate" action="<?php echo($_SERVER['PHP_SELF']); ?><?php echo (isset($_GET['checkout']) && $_GET['checkout']==1) ? "?checkout=1" : ""; ?>" method="post" class="formRegAccount" autocomplete="off">
					<p>
                        <label for="usuario_nombre">Nombre *</label>
                        <input type="text" name="usuario_nombre" id="usuario_nombre" maxlength="255" value="<?php echo $row_Recordset1['usuario_nombre']; ?>" />
                    </p>                
                    <p>                        
                        <label for="usuario_apellido">Apellido *</label>
                        <input type="text" name="usuario_apellido" id="usuario_apellido" maxlength="255" value="<?php echo $row_Recordset1['usuario_apellido']; ?>" />
                    </p>                
                    <p>                                                
                        <label for="usuario_empresa">Empresa</label>
                        <input type="text" name="usuario_empresa" id="usuario_empresa" maxlength="255" value="<?php echo $row_Recordset1['usuario_empresa']; ?>" />
                    </p>                
                    <p>                                                
                        <label for="usuario_tel">Teléfono *</label>
                        <input type="text" name="usuario_tel" id="usuario_tel" maxlength="255" value="<?php echo $row_Recordset1['usuario_tel']; ?>" />
                    </p>   
                    <p>                        
                        <label for="usuario_email">E-mail *</label>
                        <input type="text" name="usuario_email" id="usuario_email" maxlength="255" value="<?php echo $row_Recordset1['usuario_email']; ?>" />
					</p>                                 
                    <p>                                                
                        <label for="usuario_pass1">Clave</label>
                        <input type="password" name="usuario_pass1" id="usuario_pass1" maxlength="32" />
                    </p>                
                    <p>                                                
                        <label for="usuario_pass2">Repetir clave</label>
                        <input type="password" name="usuario_pass2" id="usuario_pass2" maxlength="32" />
                    </p>                
                    <p>                                                
                        <label for="usuario_direccion1">Dirección línea 1 *</label>
                        <input type="text" name="usuario_direccion1" id="usuario_direccion1" maxlength="255" value="<?php echo $row_Recordset1['usuario_direccion1']; ?>" />
                    </p>                
                    <p>                                                
                        <label for="usuario_direccion2">Dirección línea 2</label>
                        <input type="text" name="usuario_direccion2" id="usuario_direccion2" maxlength="255" value="<?php echo $row_Recordset1['usuario_direccion2']; ?>" />
                    </p>                
                    <p>                                                
                        <label for="usuario_ciudad">Ciudad *</label>
                        <input type="text" name="usuario_ciudad" id="usuario_ciudad" maxlength="255" value="<?php echo $row_Recordset1['usuario_ciudad']; ?>" />
                    </p>                
                    <p>                                                
                        <label for="usuario_cp">Código postal *</label>
                        <input type="text" name="usuario_cp" id="usuario_cp" maxlength="255" value="<?php echo $row_Recordset1['usuario_cp']; ?>" />
                    </p>                
                    <p>                                                
                        <label for="usuario_estado">Provincia/Estado *</label>
                        <input type="text" name="usuario_estado" id="usuario_estado" maxlength="255" value="<?php echo $row_Recordset1['usuario_estado']; ?>" />
                    </p>                
                    <p>                                                
                        <label for="usuario_pais">País *</label>
                        <input type="text" name="usuario_pais" id="usuario_pais" maxlength="255" value="<?php echo $row_Recordset1['usuario_pais']; ?>" />
                    </p>                
                    <p>                                                
                        <input type="hidden" name="update" id="update" value="1" />
                        <input type="submit" name="modify" id="modify" value="MODIFICAR" />
                    </p>                                        
                </form>   
                
                <?php 
					if ($message!="") {
						echo '<p class="f_12 f_white">'.$message.'</p>';
					}
				?>         
                                                                                                   
            </div>                    		                   
        </div>
        <?php include('inc/bottom.php');?>
    </div> 
</div>
</body>
</html>
<?php
	mysql_free_result($Recordset1);
?>