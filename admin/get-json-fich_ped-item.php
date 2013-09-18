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
	$query_Recordset1 = sprintf("SELECT item_talle, item_color, item_cantidad, item_preciounit, categoria_nombre_es, producto_nombre_es FROM item JOIN (categoria, producto) ON (producto.categoria_id=categoria.categoria_id AND item.producto_id=producto.producto_id) WHERE item.pedido_id=%s ORDER BY categoria_nombre_es ASC, producto_nombre_es ASC, item_talle ASC, item_color ASC", GetSQLValueString($colname_Recordset1, "int"));
	
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