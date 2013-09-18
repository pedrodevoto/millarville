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
	$query_Recordset1 = sprintf("SELECT usuario_email, usuario_passreset, usuario_pais, usuario_nombre, usuario_apellido, usuario_empresa, usuario_direccion1, usuario_direccion2, usuario_ciudad, usuario_estado, usuario_cp, usuario_tel FROM usuario WHERE usuario.usuario_id=%s", GetSQLValueString($colname_Recordset1, "int"));	
	
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