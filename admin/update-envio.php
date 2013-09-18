<?php
	$MM_authorizedUsers = "admin";
?>
<?php require_once('inc/security-html.php'); ?>
<?php
	// Require connection
	require_once('Connections/connection.php');
	// Require DB functions
	require_once('inc/db_functions.php');	
?>
<?php
	if (isset($_POST["box-envio_id"]) && $_POST["box-envio_id"] != "") {
				
		$updateSQL = sprintf("UPDATE envio SET envio_nombre_es = TRIM(%s), envio_nombre_en = TRIM(%s), envio_precio = %s, envio_ocultar = %s WHERE envio.envio_id = %s LIMIT 1",
						GetSQLValueString($_POST['box-envio_nombre_es'], "text"),
						GetSQLValueString($_POST['box-envio_nombre_en'], "text"),						
						GetSQLValueString($_POST['box-envio_precio'], "double"),						
						GetSQLValueString($_POST['box-envio_ocultar'], "int"),												
						GetSQLValueString($_POST['box-envio_id'], "int"));
		$Result1 = mysql_query($updateSQL, $connection);
		switch (mysql_errno()) {
			case 0:
				echo "El registro ha sido actualizado.";
				break;
			case 1062:
				echo "Error: Ya existe una forma de envío con el nombre especificado.";
				break;
			default:
				echo "Database error.";
				break;
		}					
		
	} else {
		die("Error: Acceso denegado.");
	}
?>