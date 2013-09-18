<?php
	// Require connection
	require_once('../Connections/connection.php');
	// Require DB functions
	require_once('../inc/db_functions.php');
?>
<?php
	// Start session [IMPORTANT!]
	if (!isset($_SESSION)) {
		session_start();
	}	
	// Start Shopping Cart
	if (!isset($_SESSION['bag'])) {
		$_SESSION['bag'] = array();
	}
?>
<?php
	// If POST information is available
	if (isset($_POST['action'])) {
				
		switch($_POST['action']) {
			case "add":			
			
				// Get quantity
				$prod_qtty = intval($_POST['item_cantidad']);
				
				// If valid product quantity
				if ($prod_qtty>0 || $prod_qtty <= 10) {
			
					// Recordset: Product				
					$query_Recordset1 = sprintf("SELECT producto.producto_id, producto_nombre_es, producto_nombre_en, producto_precio, color.color_id, color_nombre_es, color_nombre_en, talle.talle_id, talle_nombre_es, talle_nombre_en FROM producto JOIN (color, talle) ON (producto.producto_id=color.producto_id AND producto.producto_id=talle.producto_id) WHERE producto_ocultar=0 AND producto.producto_id=%s AND color.color_id=%s AND talle.talle_id=%s",
										GetSQLValueString($_POST['producto_id'], "int"),
										GetSQLValueString($_POST['color_id'], "int"),
										GetSQLValueString($_POST['talle_id'], "int"));	
					$Recordset1 = mysql_query($query_Recordset1, $connection) or die("Database error.");
					$row_Recordset1 = mysql_fetch_assoc($Recordset1);					
					$totalRows_Recordset1 = mysql_num_rows($Recordset1);				
					
					// If product exists
					if ($totalRows_Recordset1==1) {
						
						$_SESSION['bag'][] = array(
							'producto_id'=>$row_Recordset1['producto_id'],
							'producto_nombre_es'=>$row_Recordset1['producto_nombre_es'],
							'producto_nombre_en'=>$row_Recordset1['producto_nombre_en'],
							'producto_precio'=>$row_Recordset1['producto_precio'],
							'item_cantidad'=>$prod_qtty,							
							'color_id'=>$row_Recordset1['color_id'],														
							'color_nombre_es'=>$row_Recordset1['color_nombre_es'],		
							'color_nombre_en'=>$row_Recordset1['color_nombre_en'],									
							'talle_id'=>$row_Recordset1['talle_id'],														
							'talle_nombre_es'=>$row_Recordset1['talle_nombre_es'],
							'talle_nombre_en'=>$row_Recordset1['talle_nombre_en']							
						);						
						
					} // End: If product exists		
									
					// Close Recordset: Product
					mysql_free_result($Recordset1);			
					
					// Redirect to self (avoid multiple submissions)
					header("Location: ".$_SERVER['PHP_SELF']);
					die();

				} // End: If valid product quantity
				
				break;	
				
			case "remove":
			
				// If products were selected
				if (isset($_POST['index'])) {
					
					// For each product
					foreach ($_POST['index'] as $key=>$value) {
						// Remove from array
						unset($_SESSION['bag'][$value]);						
					} // End: For each product
					
					// Reorder array
					$_SESSION['bag'] = array_values($_SESSION['bag']);					
					
					// Redirect to self (avoid multiple submissions)
					header("Location: ".$_SERVER['PHP_SELF']);	
					die();				
					
				} // End: If products were selected
				break;
		}
		
	} // End: If POST information is available
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Millarville Web Site - Mi Bolsa</title>
<?php include('../inc/library.php'); ?>
</head>

<body>
<div align="center">
	<?php include('inc/header.php');?>
    <div id="main">    
        <?php include('inc/menu.php');?>
        <div id="separator" /></div>
    	<div id="content">  
            <div id="innercontent">  
                      
            	<h1 class="header1">Mi Bolsa</h1>
                <hr />

				<div style="margin-top:20px">
				<?php
					// If bag is not empty
					if (count($_SESSION['bag'])>0) {

						// Form/table start						
						echo '<form name="frmRemoveProduct" id="frmRemoveProduct" action="'.$_SERVER['PHP_SELF'].'" method="post">';
						echo '<table class="table1">';											
						
						// Table headers
						echo '<th>Producto</th>';
						echo '<th>Precio (US$)</th>';
						echo '<th>Cant</th>';
						echo '<th>Tamaño</th>';
						echo '<th>Color</th>';																								
						echo '<th style="text-align:right;">&nbsp;</th>';						
												
						// For each Product
						foreach ($_SESSION['bag'] as $key=>$value) {
							
							// Show
							echo '<tr>';
							echo '<td>'.$value['producto_nombre_es'].'</td>';
							echo '<td>'.$value['producto_precio'].'</td>';							
							echo '<td>'.$value['item_cantidad'].'</td>';							
							echo '<td>'.$value['talle_nombre_es'].'</td>';														
							echo '<td>'.$value['color_nombre_es'].'</td>';																					
							echo '<td style="text-align:right;"><input type="checkbox" name="index[]" id="index'.$key.'" value="'.$key.'" style="padding:0; margin:0" /></td>';
							echo '</tr>';						
														
						} // End: For each Product
						
						// Form/table end						
						echo '</table>';
						echo '<input type="hidden" name="action" id="action" value="remove"></input>';
						echo '<div align="right" style="margin-top:20px"><input type="submit" name="submit" id="submit" value="REMOVER" /></div>';												
						echo '</form>';																						
						
						echo '<div align="right" style="margin-top:40px"><input type="button" name="continue" id="continue" value="CONTINUAR COMPRANDO" onclick="javascript:window.location=\'products.php\';" /><input type="button" name="checkout" id="checkout" value="PAGAR" onclick="javascript:window.location=\'checkout.php\';" /></div>';
						
					} else {
						echo '<p class="f_12 f_white">Su bolsa se encuentra vacía.</p>';
					} // End: If bag is not empty
				?>
                </div>
                                                                                                   
            </div>                    		                   
        </div>
        <?php include('inc/bottom.php');?>
    </div> 
</div>
</body>
</html>