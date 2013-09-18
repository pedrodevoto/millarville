<?php
	$MM_authorizedUsers = "admin";
?>
<?php require_once('inc/security-ajax.php'); ?>
<?php
	// Require connection
	require_once('Connections/connection.php');
	// Require DB functions
	require_once('inc/db_functions.php');	
?>
<?php

	// MAIN QUERY
	$colname_Recordset1 = "-1";
	if (isset($_GET['id'])) {
		$colname_Recordset1 = $_GET['id'];
	}
	$query_Recordset1 = sprintf("SELECT producto.producto_id, producto.categoria_id, producto_nombre_es, producto_nombre_en, producto_desc_es, producto_desc_en, producto_precio, producto_destacado, producto_ocultar FROM producto WHERE producto.producto_id=%s", GetSQLValueString($colname_Recordset1, "int"));	
	
	$Recordset1 = mysql_query($query_Recordset1, $connection) or die("Database error.");
	$row_Recordset1 = mysql_fetch_assoc($Recordset1);
	$totalRows_Recordset1 = mysql_num_rows($Recordset1);	
	
	$output = array();
	if ($totalRows_Recordset1 > 0) {
		foreach ($row_Recordset1 as $key=>$value) {
			$output[$key] = strip_tags($value);
		}		
	} else {
		$output["empty"] = true;
	}
	echo json_encode($output);			
	
	mysql_free_result($Recordset1);
	
?>