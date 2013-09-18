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
	$query_Recordset1 = "SELECT producto.categoria_id as p_categoria_id, categoria_nombre_en, producto.producto_id, producto_nombre_en, producto_desc_en FROM producto JOIN (categoria, color, talle) ON (producto.categoria_id=categoria.categoria_id AND producto.producto_id=color.producto_id AND producto.producto_id=talle.producto_id) WHERE producto_destacado=1 AND producto_ocultar=0 GROUP BY color.producto_id, talle.producto_id ORDER BY RAND() LIMIT 4";	
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

<style>
	html{
		height:100%;
	}
</style>

</head>

<body>
<div align="center" class="deg">
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
                                        <div class="f_yellow f_38" style="padding-bottom:3px;">
                                            <?php echo trim_text(strtoupper($row_Recordset1['producto_nombre_en']), 15, true, true); ?>
                                        </div>
                                        <div class="f_yellow f_12">
                                            <?php echo strip_tags($row_Recordset1['producto_desc_en']); ?><br />
                                            <div style="padding-top:10px;"><a href="products.php?id=<?php echo $row_Recordset1['producto_id']; ?>&categoria_id=<?php echo $row_Recordset1['p_categoria_id']; ?>"><img src="../img/shop.png" width="64" height="24" border="0" /></a></div>
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
            <div style="width:797px; text-align:center; margin-top: 50px;">
                <table cellpadding="0" cellspacing="0" align="center" width="100%">
                    <tr>
                        <td><a href="products.php?categoria_id=1"><img src="img/player.png" border="0" vspace="6" /></a></td>
                        <td><a href="products.php?categoria_id=2"><img src="img/horse.png" border="0" vspace="6" /></a></td>
                        <td><a href="products.php?categoria_id=3"><img src="img/accesories.png" border="0" vspace="6" /></a></td>
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