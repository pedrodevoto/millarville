<?php
if (!isset($_SESSION)) {
  session_start();
}
?>
<?php
	// Require security
	require_once('../inc/security-checkout.php');		
?>
<?php
	// Check if bag is empty
	if (!isset($_SESSION['bag']) || count($_SESSION['bag'])==0) {
		header("location: bag.php");
		die();
	}
?>
<?php
	// Require connection
	require_once('../Connections/connection.php');
	// Require DB functions
	require_once('../inc/db_functions.php');
	// Require Paypal
	require_once('../inc/payment.php');	
?>
<?php
	// Recordset: Usuario
	$query_Recordset1 = sprintf("SELECT usuario_pais, usuario_nombre, usuario_apellido, usuario_empresa, usuario_direccion1, usuario_direccion2, usuario_ciudad, usuario_estado, usuario_cp, usuario_tel FROM usuario WHERE usuario_id = %s",
						GetSQLValueString($_SESSION['User_MM_UserID'], "int"));	
	$Recordset1 = mysql_query($query_Recordset1, $connection) or die("Database error.");
	$row_Recordset1 = mysql_fetch_assoc($Recordset1);
	$totalRows_Recordset1 = mysql_num_rows($Recordset1);	
		
	// Recordset: Envio (Listado)
	$query_Recordset2 = "SELECT envio.envio_id, envio_nombre_es, envio_precio FROM envio WHERE envio_ocultar=0 ORDER BY envio_nombre_en ASC";	
	$Recordset2 = mysql_query($query_Recordset2, $connection) or die("Database error.");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Millarville Web Site - Pagar</title>
<?php include('../inc/library.php'); ?>

<script language="javascript" type="text/javascript">
<!--
	checkout = function() {
			
		// Disable submit button
		$('#submit').attr("disabled", "true");
		
		// General variables
		var returnvalue = false;
				
		// If shipping was selected		
		if ($('#shipping').val()!='') {									
		
			// Post
			$.ajax({
				type: 'POST',
				url: 'process.php',
				data: {shipping : $('#shipping').val()},
				dataType: 'json',	
				async: false,			
				success: function(j) {
					if (typeof(j)=='object' && j!=null) {
						switch (j.result) {
							case 'notlogged':				
								window.location = 'select.php';												
								break;
							case 'noitems':												
								window.location = 'bag.php';																			
								break;														
							case 'invalid':						
								alert('Requerimiento inválido.');			
								break;								
							case 'dberror':						
								alert('Error de base de datos.');			
								break;														
							default:							
								if (typeof(j.result) === 'number' && j.result%1 == 0) {
									$('#item_number').val(j.result);
									returnvalue = true;
								} else {
									alert('Undefined error.');
								}
								break;					
						}
					} else {
						alert('Error al intentar registrar el pedido. Intente nuevamente.');
					}									
				},
				error: function() {
					alert('Error: No se pudo registrar el pedido. Intente nuevamente.');
				}
			});	
			
		} else {
			alert('Por favor seleccione una forma de envío.');				
		} // End: If shipping was checked								
		
		// Enable submit button (if error ocurred)
		if (returnvalue==false) {
			$('#submit').removeAttr('disabled');
		}
		
		// Return
		return returnvalue;			
	}
//-->
</script>

</head>

<body>
<div align="center">
	<?php include('inc/header.php');?>
    <div id="main">    
        <?php include('inc/menu.php');?>
        <div id="separator" /></div>
    	<div id="content">  
            <div id="innercontent">  
                      
            	<h1 class="header1">Pagar</h1>
				<p class="f_white f_12">Por favor confirme su orden:</p>                
                <hr />
                
                <div class="f_12 f_white" style="margin-top:20px; margin-bottom:20px;">   
                	<div style="float:left; width:45%;">             
                        <h2 class="header2">Sus datos</h2>
                        <ul class="list1">
                            <li>Nombre completo: <?php echo strip_tags($row_Recordset1['usuario_nombre']." ".$row_Recordset1['usuario_apellido']); ?></li>
                            <li>Empresa: <?php echo strip_tags($row_Recordset1['usuario_empresa']); ?></li>                        
                            <li>Teléfono: <?php echo strip_tags($row_Recordset1['usuario_tel']); ?></li>                                                                                                
                            <li>Dirección línea 1: <?php echo strip_tags($row_Recordset1['usuario_direccion1']); ?></li>                        
                            <li>Dirección línea 2: <?php echo strip_tags($row_Recordset1['usuario_direccion2']); ?></li>                                                                        
                            <li>Ciudad: <?php echo strip_tags($row_Recordset1['usuario_ciudad']); ?></li>                                                                        
                            <li>Código postal: <?php echo strip_tags($row_Recordset1['usuario_cp']); ?></li>                                                                                                
                            <li>Provincia/estado: <?php echo strip_tags($row_Recordset1['usuario_estado']); ?></li>                                                                                                
                            <li>País: <?php echo strip_tags($row_Recordset1['usuario_pais']); ?></li>                                                                        
						</ul>                            
                        <span style="margin-left:20px"><a href="account.php?checkout=1" class="f_11 f_orange">MODIFICAR</a></span>
	                </div>
					<div style="float:right; width:50%;" align="right">
                        <h2 class="header2">Su orden</h2>
                        <?php					
							// General variables
							$total_item = 0;
							$total_without_delivery = 0;
						
                            // Table start						
                            echo '<table class="table1">';											
                            
                            // Table headers
                            echo '<th>Producto</th>';
                            echo '<th>Precio (US$)</th>';
                            echo '<th>Cant</th>';
                            echo '<th>Tamaño</th>';
                            echo '<th>Color</th>';																								
                            echo '<th style="text-align:right">Total</th>';																														
                                                    
                            // For each Product
                            foreach ($_SESSION['bag'] as $key=>$value) {
								
								// Compute totals
								$total_item = $value['producto_precio'] * $value['item_cantidad'];
								$total_without_delivery	+= $total_item;							
                                                        
                                // Show row
                                echo '<tr>';
                                echo '<td>'.$value['producto_nombre_es'].'</td>';
                                echo '<td>'.$value['producto_precio'].'</td>';							
                                echo '<td>'.$value['item_cantidad'].'</td>';							
                                echo '<td>'.$value['talle_nombre_es'].'</td>';														
                                echo '<td>'.$value['color_nombre_es'].'</td>';																					
                                echo '<td style="text-align:right">'.number_format($total_item,2).'</td>';																												
								echo '</tr>';
                                                            
                            } // End: For each Product
							
							// Show separator
							echo '<tr><td colspan="6"><hr /></td></tr>';
							
							// Show total
							echo '<tr>';
							echo '<td colspan="6" style="text-align:right"><strong>Total (sin envío): US$ </strong> '.number_format($total_without_delivery,2).'</td>';																																				
							echo '</tr>';													
                            
                            // Table end						
                            echo '</table>';					
                        ?>	
                        <span style="margin-right:5px"><a href="bag.php" class="f_11 f_orange">MODIFICAR</a></span>                        
                	</div>				
                    <br clear="all" />
            	</div> 
                <hr />
                <div>
                    <p>
						<form name="_xclick" action="<?php echo $paypal_url; ?>" method="post" onSubmit="return checkout();">						
							<input type="hidden" name="cmd" value="_xclick" />						
							<input type="hidden" name="return" value="http://www.millarville.com.ar/esp/confirm_order.php" />																								
							<input type="hidden" name="business" value="<?php echo $paypal_business; ?>" />						
							<input type="hidden" name="currency_code" value="USD" />
							<input type="hidden" name="item_name" value="Orden Millarville" />						
							<input type="hidden" name="item_number" id="item_number" value="" />						
							<input type="hidden" name="amount" value="<?php echo number_format($total_without_delivery,2); ?>" />
							<p class="f_white f_12">Seleccione la forma de envío preferida&nbsp;&nbsp;&nbsp;
		                        <select name="shipping" id="shipping">
		                            <option value="">No seleccionada</option>
		                            <?php
										// While rows in Recordset: Envio (Listado)
										while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)) {						
											echo '<option value="'.$row_Recordset2['envio_precio'].'">'.$row_Recordset2['envio_nombre_es'].' - US$ '.$row_Recordset2['envio_precio'].'</option>';
										}	                                
									?>                                
		                        </select>	
	                        </p>											
							<input type="image" src="http://www.paypal.com/en_US/i/btn/btn_buynow_LG.gif" border="0" name="submit" id="submit" alt="Make payments with PayPal - it\'s fast, free and secure!" />						
						</form>	                        			
                    </p>                       
				</div>               
                                                                                               
            </div>                    		                   
        </div>
        <?php include('inc/bottom.php');?>
    </div> 
</div>
</body>
</html>
<?php
	// Close Recordset: Usuario
    mysql_free_result($Recordset1);	
	
	// Close Recordset: Envio (Listado)
    mysql_free_result($Recordset2);		
?>