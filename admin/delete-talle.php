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
		$deleteSQL = sprintf("DELETE FROM talle WHERE talle.talle_id=%s LIMIT 1",
						GetSQLValueString($_POST['id'], "int"));
		$Result1 = mysql_query($deleteSQL, $connection) or die("Database error.");
		echo "El registro ha sido eliminado.";
	} else {
		die("Error: Acceso denegado.");
	}
?>