<?php
if (!isset($_SESSION)) {
  session_start();
}
?>
<?php
	// Require connection
	require_once('../Connections/connection.php');
	// Require DB functions
	require_once('../inc/db_functions.php');
?>
<?php
	// Recordset: Producto
	$colname_Recordset1 = "-1";
	if (isset($_GET['id'])) {
		$colname_Recordset1 = $_GET['id'];
	}	
	$query_Recordset1 = sprintf("SELECT categoria_nombre_es, producto.producto_id, producto_nombre_es, producto_desc_es, producto_precio FROM producto JOIN (categoria, color, talle) ON (producto.categoria_id=categoria.categoria_id AND producto.producto_id=color.producto_id AND producto.producto_id=talle.producto_id) WHERE producto_ocultar=0 AND producto.producto_id=%s",
						GetSQLValueString($colname_Recordset1, "int"));	
	$Recordset1 = mysql_query($query_Recordset1, $connection) or die("Database error.");
	$totalRows_Recordset1 = mysql_num_rows($Recordset1);

	// If Product not found or not selected
	if ($totalRows_Recordset1==0) {
		// Bring oldest valid product
		$query_Recordset1 = "SELECT categoria_nombre_es, producto.producto_id, producto_nombre_es, producto_desc_es, producto_precio FROM producto JOIN (categoria, color, talle) ON (producto.categoria_id=categoria.categoria_id AND producto.producto_id=color.producto_id AND producto.producto_id=talle.producto_id) WHERE producto_ocultar=0 GROUP BY color.producto_id, talle.producto_id ORDER BY categoria_orden ASC, producto_nombre_es ASC";	
		$Recordset1 = mysql_query($query_Recordset1, $connection) or die("Database error.");
		$totalRows_Recordset1 = mysql_num_rows($Recordset1);		
	}
	
	// Get row
	$row_Recordset1 = mysql_fetch_assoc($Recordset1);		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Millarville Web Site - Productos</title>
<?php include('../inc/library.php'); ?>
 
<script type="text/javascript" language="javascript">
	openImageBig = function(id) {
		$.colorbox({
			title:'Detalle de imágen',
			href:'../img_det.php?id='+id
		});
	}
</script>

</head>

<body>
<div align="center">
	<?php include('inc/header.php');?>
    <div id="main">
        <?php include('inc/menu.php');?>
        <div id="separator"></div>
    	<div id="content">	        
            <div>
                <div style="float:left; width:90px; text-align:left; margin-left:70px;">
                <?php
                    // Recordset: Categoria
                    $query_Recordset2 = "SELECT categoria.categoria_id, categoria_nombre_es FROM categoria ORDER BY categoria_orden ASC";
                    $Recordset2 = mysql_query($query_Recordset2, $connection) or die("Database error.");
                    
                    // While rows in Recordset: Categoria
                    while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)) {
                        
                        // Show category name
                        echo '<div class="f_brown f_12" style="margin-top:34px;">'.strtoupper(strip_tags($row_Recordset2['categoria_nombre_es'])).'</div>';
        
                        // Recordset: Productos (Listado)
                        $query_Recordset3 = sprintf("SELECT producto.producto_id, producto_nombre_es FROM producto JOIN (color, talle) ON (producto.producto_id=color.producto_id AND producto.producto_id=talle.producto_id) WHERE producto_ocultar=0 AND producto.categoria_id=%s GROUP BY color.producto_id, talle.producto_id ORDER BY producto_nombre_es ASC",
                                            GetSQLValueString($row_Recordset2['categoria_id'], "int"));	
                        $Recordset3 = mysql_query($query_Recordset3, $connection) or die("Database error.");
                        $totalRows_Recordset3 = mysql_num_rows($Recordset3);				
                        
                        // If rows in Recordset: Productos (Listado)
                        if ($totalRows_Recordset3>0) {
        
                            // Show product container
                            echo '<div class="f_white f_12"><br /><ul>';
        
                            // While rows in Recordset: Productos (Listado)
                            while ($row_Recordset3 = mysql_fetch_assoc($Recordset3)) {						
                                echo '<li><a href="products.php?id='.$row_Recordset3['producto_id'].'" class="'.($row_Recordset1['producto_id']==$row_Recordset3['producto_id'] ? "f_orange" : "f_white").'">'.$row_Recordset3['producto_nombre_es'].'</a></li>';
                            }					
                            
                            // Close product container
                            echo '</ul></div>';
                            
                        } // End: If rows in Recordset: Productos (Listado)
                        
                        // Close Recordset: Productos (Listado)
                        mysql_free_result($Recordset3);				
                        
                    } // End: While rows in Recordset: Categoria
                    
                    // Close Recordset: Categoria
                    mysql_free_result($Recordset2);
                ?>        
                </div>
                <div style="float:right; width:565px; margin-right:70px">
                    <?php if ($totalRows_Recordset1>0) { ?>
                        <div class="f_white f_12" style="text-align:right; padding-right:20px;">
                        PRODUCTOS > <?php echo strtoupper(strip_tags($row_Recordset1['categoria_nombre_es'])); ?>
                        </div>
                        <div class="f_brown f_21" style="text-align:right; padding-right:20px;">
                        <?php echo strtoupper(strip_tags($row_Recordset1['producto_nombre_es'])); ?>
                        </div>
                        <div style="background-color:#FFFFFF; height:1px; margin-top:4px; margin-bottom:14px; width:100%;" /></div>
                        <div style="width:100%;">
                            <a href="javascript:openImageBig(<?php echo $row_Recordset1['producto_id']; ?>);"><img src="../prod_img/<?php echo $row_Recordset1['producto_id']; ?>-small.jpg" width="286" height="200" border="0" /></a>
                        </div>
                        <div style="width:70%;">
                            <div class="f_white f_12" style="text-align:left; margin-top:10px;">
                            <?php echo strip_tags($row_Recordset1['producto_desc_es']); ?>
                            </div>
                            <form name="frmAddProduct" id="frmAddProduct" action="bag.php" method="post" class="formProd">
                                <div class="f_white f_12" style="text-align:left; margin-top:10px;">
                                    <span style="padding-right:30px;"><b>PRECIO:</b> US$ <?php echo $row_Recordset1['producto_precio']; ?></span>
                                    <span><b>CANTIDAD:</b>&nbsp;&nbsp;
                                        <select name="item_cantidad" id="item_cantidad">
                                            <option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option>
                                        </select>
                                    </span>
                                </div>
                                <div class="f_white f_12" style="text-align:left; margin-top:2px;">
                                    <b>SELECCIONE TALLE:</b>&nbsp;&nbsp;
                                    <select name="talle_id" id="talle_id">
                                        <?php
                                            // Recordset: Talle
                                            $query_Recordset4 = sprintf("SELECT talle.talle_id, talle_nombre_es FROM talle WHERE talle.producto_id=%s ORDER BY talle_nombre_es ASC",
                                                                GetSQLValueString($row_Recordset1['producto_id'], "int"));	
                                            $Recordset4 = mysql_query($query_Recordset4, $connection) or die("Database error.");
                                            // While rows in Recordset: Talle
                                            while ($row_Recordset4 = mysql_fetch_assoc($Recordset4)) {									
                                                echo '<option value="'.$row_Recordset4['talle_id'].'">'.$row_Recordset4['talle_nombre_es'].'</option>';
                                            }
                                            // Close Recordset: Talle
                                            mysql_free_result($Recordset4)
                                        ?>
                                    </select>
                                </div>
                                <div class="f_white f_12" style="text-align:left; margin-top:2px;">
                                    <b>SELECCIONE COLOR:</b>&nbsp;&nbsp;
                                    <select name="color_id" id="color_id">
                                        <?php
                                            // Recordset: Color
                                            $query_Recordset5 = sprintf("SELECT color.color_id, color_nombre_es FROM color WHERE color.producto_id=%s ORDER BY color_nombre_es ASC",
                                                                GetSQLValueString($row_Recordset1['producto_id'], "int"));	
                                            $Recordset5 = mysql_query($query_Recordset5, $connection) or die("Database error.");
                                            // While rows in Recordset: Color
                                            while ($row_Recordset5 = mysql_fetch_assoc($Recordset5)) {									
                                                echo '<option value="'.$row_Recordset5['color_id'].'">'.$row_Recordset5['color_nombre_es'].'</option>';
                                            }
                                            // Close Recordset: Color								
                                            mysql_free_result($Recordset5)
                                        ?>
                                    </select>
                                </div>
                                <div style="text-align:left; margin-top:10px;">       
                                	<input type="hidden" name="producto_id" id="producto_id" value="<?php echo $row_Recordset1['producto_id']; ?>" />
                                	<input type="hidden" name="action" id="action" value="add"  />                 
                                    <input type="submit" name="submit" id="submit" value="AGREGAR AL CARRITO" />
                                </div>
                            </form>
                        </div>
                    <?php } ?>            
                </div>
                <br clear="all" />
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