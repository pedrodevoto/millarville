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
	if ((isset($_POST["box-insert"])) && ($_POST["box-insert"] != "")) {
		
		// Set files info
		$files = array(
			array(	'field' => 'box-image_highlight', 'alias' => 'Imagen Destacada', 'short' => 'highlight',
					'maxsize' => 2048000,
					'validext' => array('png'), 'validmime' => array('image/png'), 				
					'width' => 350, 'height' => 188),
			array(	'field' => 'box-image_small', 'alias' => 'Imagen Pequeña', 'short' => 'small',
					'maxsize' => 2048000,
					'validext' => array('jpg'), 'validmime' => array('image/jpeg'),		
					'width' => 286, 'height' => 200),
			array(	'field' => 'box-image_big', 'alias' => 'Imagen Grande', 'short' => 'big',
					'maxsize' => 2048000,
					'validext' => array('jpg'), 'validmime' => array('image/jpeg'),
					'width' => 460, 'height' => 340)						
		);		
		
		// Verify upload and image details
		foreach ($files as $array) {
    		VerifyUpload($array['field'], $array['alias'], $array['maxsize'], $array['validext']);
			VerifyImage($array['field'], $array['alias'], $array['validmime'], $array['width'], $array['height']);
		}
		
		// Insert basic info		
		$insertSQL = sprintf("INSERT INTO producto (producto.categoria_id, producto_nombre_es, producto_nombre_en, producto_desc_es, producto_desc_en, producto_precio, producto_destacado, producto_ocultar) VALUES (%s, TRIM(%s), TRIM(%s), TRIM(%s), TRIM(%s), %s, %s, %s)",
						GetSQLValueString($_POST['box-categoria_id'], "int"),
						GetSQLValueString($_POST['box-producto_nombre_es'], "text"),
						GetSQLValueString($_POST['box-producto_nombre_en'], "text"),						
						GetSQLValueString($_POST['box-producto_desc_es'], "text"),
						GetSQLValueString($_POST['box-producto_desc_en'], "text"),						
						GetSQLValueString($_POST['box-producto_precio'], "double"),						
						GetSQLValueString($_POST['box-producto_destacado'], "int"),
						GetSQLValueString($_POST['box-producto_ocultar'], "int"));											
		$Result1 = mysql_query($insertSQL, $connection) or die("Database error.");
		
		// Check insert
		switch (mysql_errno()) {
			case 0:			
				// Get ID
				$inserted_id = mysql_insert_id();				
				// General variables
				$move_error = 0;				
				// Move images
				foreach ($files as $array) {
					// Temp file path
					$uploaded_file_path = $_FILES[$array['field']]['tmp_name'];
					// Uploaded file extension
					$uploaded_ext = GetFileExt($array['field']);					
					// Final filename
					$filename = $inserted_id."-".$array['short'].".".$uploaded_ext;
					// Move file
					if (!move_uploaded_file($uploaded_file_path, "../prod_img/".$filename)) {									
						$move_error = 1;						
					}
				}				
				// Show confirmation/error message
				if ($move_error==0) {
					echo $inserted_id;
				} else {
					echo "Error moviendo archivos.";
				}
				break;
			default:
				echo "Database error.";
				break;
		}			
		
	} else {
		die("Error: Acceso denegado.");
	}
?>