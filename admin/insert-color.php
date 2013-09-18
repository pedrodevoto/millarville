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
	if (isset($_POST["boxad1-producto_id"]) && $_POST["boxad1-producto_id"]!="") {
		
			// Insert
			$insertSQL = sprintf("INSERT INTO color (color.producto_id, color_hex, color_nombre_es, color_nombre_en) VALUES (%s, %s, TRIM(%s), TRIM(%s))",
							GetSQLValueString($_POST['boxad1-producto_id'], "int"),
							GetSQLValueString($_POST['boxad1-color_hex'], "text"),
							GetSQLValueString($_POST['boxad1-color_nombre_es'], "text")	,				
							GetSQLValueString($_POST['boxad1-color_nombre_en'], "text"));													
			$Result1 = mysql_query($insertSQL, $connection) or die("Database error.");
			echo "El registro fue insertado con éxito.";
		
	} else {
		die("Error: Acceso denegado.");
	}
?>