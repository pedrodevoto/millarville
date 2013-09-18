<?php
	$MM_authorizedUsers = "admin";
?>
<?php require_once('inc/security-html.php'); ?>
<?php
	// Require connection
	require_once('Connections/connection.php');
	// Require DB functions
	require_once('inc/db_functions.php');	
	// Require File functions
	require_once('inc/file_functions.php');		
?>
<?php
	if ((isset($_POST["box-insert"])) && ($_POST["box-insert"] != "")) {
		
		// Insert basic info		
		$insertSQL = sprintf("INSERT INTO producto (producto.categoria_id, producto_nombre_es, producto_nombre_en, producto_desc_es, producto_desc_en, producto_precio, producto_destacado, producto_ocultar) VALUES (%s, TRIM(%s), TRIM(%s), TRIM(%s), TRIM(%s), %s, %s, %s)",
						GetSQLValueString($_POST['box-categoria_id'], "int"),
						GetSQLValueString($_POST['box-producto_nombre_es'], "text"),
						GetSQLValueString($_POST['box-producto_nombre_en'], "text"),						
						GetSQLValueString($_POST['box-producto_desc_es'], "text"),
						GetSQLValueString($_POST['box-producto_desc_en'], "text"),						
						GetSQLValueString($_POST['box-producto_precio'], "double"),						
						GetSQLValueString($_POST['box-producto_destacado'], "int"),
						GetSQLValueString($_POST['box-producto_ocultar'], "int"));											
		$Result1 = mysql_query($insertSQL, $connection) or die("Database error.");
		
		// Check insert
		switch (mysql_errno()) {
			case 0:			
				// Get ID
				$inserted_id = mysql_insert_id();				
				echo $inserted_id;
				break;
			default:
				echo "Database error.";
				break;
		}			
		
	} else {
		die("Error: Acceso denegado.");
	}
?>