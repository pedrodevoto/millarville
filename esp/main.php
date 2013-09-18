<?php
if (!isset($_SESSION)) {
  session_start();
}
?>
<?php
	// Require connection
	require_once('../Connections/connection.php');
	// Require general functions
	require_once('../inc/general_functions.php');	
?>
<?php
	// Recordset: Producto
	$query_Recordset1 = "SELECT categoria_nombre_es, producto.producto_id, producto_nombre_es, producto_desc_es FROM producto JOIN (categoria, color, talle) ON (producto.categoria_id=categoria.categoria_id AND producto.producto_id=color.producto_id AND producto.producto_id=talle.producto_id) WHERE producto_destacado=1 AND producto_ocultar=0 GROUP BY color.producto_id, talle.producto_id ORDER BY RAND() LIMIT 4";	
	$Recordset1 = mysql_query($query_Recordset1, $connection) or die("Database error.");
	$totalRows_Recordset1 = mysql_num_rows($Recordset1);	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Millarville Web Site</title>
<?php include('../inc/library.php'); ?>

<?php if ($totalRows_Recordset1>0) { ?>
    <!-- Initialize billboard -->
    <script type="text/javascript" language="javascript" src="../js/rotating_init.js"></script>
<?php } ?>

</head>

<body>
<div align="center">
	<?php include('inc/header.php');?>
    <div id="main">
        <?php include('inc/menu.php');?>
        <div id="separator"></div>
    	<div id="content">	        
		<?php
			// If there are highlighted products			
        	if ($totalRows_Recordset1>0) {
		?>
                <!-- Rotating Box -->        
                <div id="slidebox">
                    <div class="next"></div>
                    <div class="previous"></div>
                    <div class="thumbs">
                    	<?php
							// For each record, echo a thumb button
							for ($i=1; $i<=$totalRows_Recordset1; $i++) {
	                        	echo '<span onClick="Slidebox(\''.$i.'\');return false" class="thumb"></span>';
                            }
                        ?>
                    </div>                                
                    <div class="container">                    
						<?php
                            // While rows in Recordset: Producto
                            while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)) {	
                        ?>                
                                <div class="content">     
                                    <div style="float:left; text-align:right; width:50%"><img src="../prod_img/<?php echo $row_Recordset1['producto_id']; ?>-highlight.png" width="350" height="188" border="0" /></div>                                    
                                    <div style="float:left; width:40%; padding-left:10px; text-align:left">
                                        <div class="f_yellow">
                                            CATEGORÍA: <?php echo strtoupper(strip_tags($row_Recordset1['categoria_nombre_es'])); ?>
                                        </div>
                                        <div class="f_yellow f_30">
                                            <?php echo trim_text(strtoupper($row_Recordset1['producto_nombre_es']), 15, true, true); ?>
                                        </div>
                                        <div class="f_yellow f_12">
                                            <?php echo strip_tags($row_Recordset1['producto_desc_es']); ?><br />
                                            <div style="padding-top:10px;"><a href="products.php?id=<?php echo $row_Recordset1['producto_id']; ?>"><img src="../img/shop_es.jpg" width="75" height="21" border="0" /></a></div>
                                        </div>
                                    </div>
                                </div>
						<?php				
                            } // While rows in Recordset: Producto			
                        ?>
	            	</div>                
                </div>
                <!-- End: Rotating Box -->      
        <?php
			} // End: If there are highlighted productos
		?>  
            <div style="width:100%; text-align:center; margin-top: 50px;">
                <table cellpadding="0" cellspacing="0" align="center" width="100%">
                    <tr>
                        <td><img src="../img/player.jpg" width="199" height="108" border="0" /><br /><a href="products.php"><img src="img/player-label.png" width="196" height="17" border="0" vspace="6" /></a></td>
                        <td><img src="../img/horse.jpg" width="199" height="108" border="0" /><br /><a href="products.php"><img src="img/horse-label.png" width="193" height="17" border="0" vspace="6" /></a></td>
                        <td><img src="../img/accsesories.jpg" width="198" height="109" border="0" /><br /><a href="products.php"><img src="img/accsesories-label.png" width="197" height="17" border="0" vspace="6" /></a></td>
                    </tr>
                </table>
            </div>
		</div>            
        <?php include('inc/bottom.php');?>
    </div>
</div>
</body>
</html>
<?php 
	// Close Recordset: Producto	
	mysql_free_result($Recordset1);	
?>