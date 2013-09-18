<?php
	$MM_authorizedUsers = "admin";
?>
<?php require_once('inc/security-ajax.php'); ?>
<?php
	// Require connection
	require_once('Connections/connection.php');
?>
<?php
	$query_Recordset1 = "SELECT estado.estado_id, estado_nombre FROM estado ORDER BY estado_nombre ASC";
	$Recordset1 = mysql_query($query_Recordset1, $connection) or die("Database error.");
	
	$output = array();
	while ($row_Recordset1=mysql_fetch_array($Recordset1)) {
		$output[$row_Recordset1[0]] = strip_tags($row_Recordset1[1]);
	}
	echo json_encode($output);
	
	mysql_free_result($Recordset1);
?>