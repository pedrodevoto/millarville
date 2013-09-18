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
	if ((isset($_POST["id"])) && ($_POST["id"] != "")) {
		$updateSQL = sprintf("UPDATE pedido SET pedido.estado_id = %s WHERE pedido.pedido_id = %s LIMIT 1",
						GetSQLValueString($_POST['value'], "int"),
						GetSQLValueString($_POST['id'], "int"));
		$Result1 = mysql_query($updateSQL, $connection) or die("Database error.");
		echo $_POST['nombre'];
	} else {
		die("Error actualizando el registro.");
	}
?>