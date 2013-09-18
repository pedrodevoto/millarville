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
	$query_Recordset1 = sprintf("SELECT color_hex, color_nombre_es, color_nombre_en, color.color_id FROM color WHERE color.producto_id=%s", GetSQLValueString($colname_Recordset1, "int"));
	
	$Recordset1 = mysql_query($query_Recordset1, $connection) or die("Database error.");
	$row_Recordset1 = mysql_fetch_array($Recordset1,MYSQL_ASSOC);
	$totalRows_Recordset1 = mysql_num_rows($Recordset1);	
	
	$output = array();
	for ($i=0; $i<$totalRows_Recordset1; $i++) {
		foreach ($row_Recordset1 as $key=>$value) {
			$output[$i][$key] = strip_tags($value);
		}		
		$row_Recordset1 = mysql_fetch_array($Recordset1,MYSQL_ASSOC);		
	}
	echo json_encode($output);
	
	mysql_free_result($Recordset1);
	
?>