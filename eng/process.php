<?php
	// Require security
	require_once('../inc/security-checkout_ajax.php');		
?>
<?php
	// Check if bag is empty
	if (!isset($_SESSION['bag']) || count($_SESSION['bag'])==0) {
		echo '{"result": "noitems"}';
		die();
	}
?>
<?php
	// Require connection
	require_once('../Connections/connection.php');
	// Require DB functions
	require_once('../inc/db_functions.php');	
?>
<?php
	if (isset($_POST["shipping"]) && $_POST["shipping"]!="") {
		
			// Insert Pedido
			$insertSQL = sprintf("INSERT INTO pedido (pedido.usuario_id, pedido.estado_id) VALUES (%s, %s)",
							GetSQLValueString($_SESSION['User_MM_UserID'], "int"),
							1);													
			$Result1 = mysql_query($insertSQL, $connection) or die('{"result": "dberror"}');
					
			// Get ID of Order
			$pedido_id = mysql_insert_id();	
			
			// General variables
			$total_item = 0;
			$total_without_delivery = 0;				
			
			// For each item
			foreach ($_SESSION['bag'] as $key=>$value) {
				
				// Compute totals
				$total_item = $value['producto_precio'] * $value['item_cantidad'];
				$total_without_delivery	+= $total_item;						
				
				// Insert
				$insertSQL = sprintf("INSERT INTO item (item.pedido_id, item.producto_id, item_talle, item_color, item_cantidad, item_preciounit) VALUES (%s, %s, %s, %s, %s, %s)",
								GetSQLValueString($pedido_id, "int"),
								GetSQLValueString($value['producto_id'], "int"),
								GetSQLValueString($value['talle_nombre_es'], "text"),									
								GetSQLValueString($value['color_nombre_es'], "text"),
								GetSQLValueString($value['item_cantidad'], "int"),
								GetSQLValueString($value['producto_precio'], "double"));													
				$Result1 = mysql_query($insertSQL, $connection) or die('{"result": "dberror"}');	
												
			}						
			
			// Clear Cart
			unset($_SESSION['bag']);					

			// Return ID of Order
			echo '{"result": '.$pedido_id.'}';
		
	} else {
		die('{"result": "invalid"}');
	}	
?>