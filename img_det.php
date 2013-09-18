<?php
	// Require connection
	require_once('Connections/connection.php');
	// Require DB functions
	require_once('inc/db_functions.php');	
?>
<?php 
	// Check that URL variable is set
	if (isset($_GET['id']) && $_GET['id']!="") {
		$producto_id = intval($_GET['id']);
	} else {
		die('<script language="javascript" type="text/javascript">$.colorbox.close();</script>');
	}
?>
<div style="background-image:url(../prod_img/<?php echo($producto_id); ?>-big.jpg); width:460px; height:340px;">
</div>
<div style="margin-top:10px">
<?php
	$query_Recordset1 = sprintf("SELECT color_hex FROM color WHERE producto_id=%s",
						GetSQLValueString($producto_id, "int"));	
	$Recordset1 = mysql_query($query_Recordset1, $connection) or die("Database error.");
	while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)) {
		echo '<div style="width:30px; height:30px; background-color:'.$row_Recordset1['color_hex'].'; margin-right: 5px; border: 1px solid #ccc; display: inline-block; *display: inline; zoom:1"></div>';
	}
?>
</div>