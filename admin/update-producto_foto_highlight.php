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
	// Get Product ID
	if (isset($_POST['id'])) {
		$producto_foto_id = intval($_POST['id']);
	}		
	else {
		die("Error: Producto no encontrado.");			
	} // If product exists
	
	$sql = sprintf('SELECT producto_id FROM producto_foto WHERE producto_foto_id = %s', $producto_foto_id);
	error_log($sql);
	$res = mysql_query($sql) or die(mysql_error());
	list($producto_id) = mysql_fetch_array($res);
	
	$sql = sprintf('UPDATE producto_foto SET producto_foto_highlight=0 WHERE producto_id = %s', $producto_id);
	mysql_query($sql) or die(mysql_error());
	
	$sql = sprintf('UPDATE producto_foto SET producto_foto_highlight=1 WHERE producto_foto_id = %s', $producto_foto_id);
	mysql_query($sql) or die(mysql_error());

?>