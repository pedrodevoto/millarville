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
	if (isset($_POST["box-insert"]) && $_POST["box-insert"]=="1") {
		
			// Insert
			$insertSQL = sprintf("INSERT INTO envio (envio_nombre_es, envio_nombre_en, envio_precio, envio_ocultar) VALUES (TRIM(%s), TRIM(%s), %s, %s)",
							GetSQLValueString($_POST['box-envio_nombre_es'], "text"),
							GetSQLValueString($_POST['box-envio_nombre_en'], "text"),
							GetSQLValueString($_POST['box-envio_precio'], "double"),
							GetSQLValueString($_POST['box-envio_ocultar'], "int"));						
			$Result1 = mysql_query($insertSQL, $connection);
			switch (mysql_errno()) {
				case 0:
					echo "El registro ha sido insertado con éxito.";
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