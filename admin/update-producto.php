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
	$producto_id = "-1";
	if (isset($_POST['box-producto_id'])) {
		$producto_id = intval($_POST['box-producto_id']);
	}		
	
	// Recordset: Producto
	$query_Recordset1 = sprintf("SELECT producto.producto_id FROM producto WHERE producto.producto_id=%s", $producto_id);	
	$Recordset1 = mysql_query($query_Recordset1, $connection) or die("Database error.");
	$totalRows_Recordset1 = mysql_num_rows($Recordset1);		
	
	// If product exists
	if ($totalRows_Recordset1==1) {
	
		// Update Basic Info
		$updateSQL = sprintf("UPDATE producto SET producto.categoria_id = %s, producto_nombre_es = TRIM(%s), producto_nombre_en = TRIM(%s), producto_desc_es = TRIM(%s), producto_desc_en = TRIM(%s), producto_precio = %s, producto_destacado = %s, producto_ocultar = %s WHERE producto.producto_id = %s LIMIT 1",
						GetSQLValueString($_POST['box-categoria_id'], "int"),
						GetSQLValueString($_POST['box-producto_nombre_es'], "text"),
						GetSQLValueString($_POST['box-producto_nombre_en'], "text"),						
						GetSQLValueString($_POST['box-producto_desc_es'], "text"),
						GetSQLValueString($_POST['box-producto_desc_en'], "text"),						
						GetSQLValueString($_POST['box-producto_precio'], "double"),						
						GetSQLValueString($_POST['box-producto_destacado'], "int"),
						GetSQLValueString($_POST['box-producto_ocultar'], "int"),
						$producto_id);
		$Result1 = mysql_query($updateSQL, $connection) or die("Database error.");
		echo "La información del producto fue actualizada con éxito.";						
		
	} else {
		die("Error: Producto no encontrado.");			
	} // If product exists
	
	// Close Recordset: Producto
	mysql_free_result($Recordset1);	
?>