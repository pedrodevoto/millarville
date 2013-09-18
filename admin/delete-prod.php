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

		// Set master ID		
		$producto_id = intval($_POST["id"]);
		
		// Recordset: Producto
		$query_Recordset1 = sprintf("SELECT producto.producto_id FROM producto WHERE producto.producto_id=%s", GetSQLValueString($producto_id, "int"));		
		$Recordset1 = mysql_query($query_Recordset1, $connection) or die("Database error.");
		$totalRows_Recordset1 = mysql_num_rows($Recordset1);		
		mysql_free_result($Recordset1);

		// If record was found
		if ($totalRows_Recordset1==1) {		
		
			// Delete record
			$deleteSQL = sprintf("DELETE FROM producto WHERE producto.producto_id=%s LIMIT 1",
							GetSQLValueString($producto_id, "int"));
			$Result1 = mysql_query($deleteSQL, $connection);
			
			// Evaluate results
			switch (mysql_errno()) {
				case 0:
					// If succeeded, delete images
					$file_base = "../prod_img/";
					$file_names = array("-highlight.png", "-small.jpg", "-big.jpg");
					foreach ($file_names as $key=>$value) {
						$filename = $file_base.$producto_id.$value;
						if (file_exists($filename)) {
							unlink($filename) or die ("Error: Couldn't delete file: ".$filename);
						}
					}					
					echo "El producto fue eliminado con éxito";
					break;
				case 1451:
					die("Error: No se puede eliminar el producto ya que posee registros asociados."); 
					break;
				default: 
					die("Database error.");
					break;
			}
			
		} else {
			die("Error: Producto no encontrado.");
		}
		
	} else {
		die("Error: Acceso denegado.");
	}
?>