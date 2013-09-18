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
	$categoria_id = 0;
	if (isset($_GET['categoria_id'])) {
		$categoria_id = $_GET['categoria_id'];
	}

	// Recordset: Producto
	$colname_Recordset1 = "-1";
	if (isset($_GET['id'])) {
		$colname_Recordset1 = $_GET['id'];
	}	
	$query_Recordset1 = sprintf("SELECT categoria_nombre_en, producto.producto_id, producto_nombre_en, producto_desc_en, producto_precio FROM producto JOIN (categoria, color, talle) ON (producto.categoria_id=categoria.categoria_id AND producto.producto_id=color.producto_id AND producto.producto_id=talle.producto_id) WHERE producto_ocultar=0 AND producto.producto_id=%s AND producto.categoria_id=%s",
						GetSQLValueString($colname_Recordset1, "int"),	
						GetSQLValueString($categoria_id, "int"));	
	$Recordset1 = mysql_query($query_Recordset1, $connection) or die("Database error.");
	$totalRows_Recordset1 = mysql_num_rows($Recordset1);

	// If Product not found or not selected
	if ($totalRows_Recordset1==0) {
		// Bring oldest valid product
		$query_Recordset1 = sprintf("SELECT categoria_nombre_en, producto.producto_id, producto_nombre_en, producto_desc_en, producto_precio FROM producto JOIN (categoria, color, talle) ON (producto.categoria_id=categoria.categoria_id AND producto.producto_id=color.producto_id AND producto.producto_id=talle.producto_id) WHERE producto_ocultar=0 AND producto.categoria_id=%s GROUP BY color.producto_id, talle.producto_id ORDER BY categoria_orden ASC, producto_nombre_en ASC",	
							GetSQLValueString($categoria_id, "int"));	
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
<title>Millarville Web Site - Products</title>
<?php include('../inc/library.php'); ?>
 
<script type="text/javascript" language="javascript">
	openImageBig = function(id) {
		$.colorbox({
			title:'Image Detail',
			href:'../img_det.php?id='+id
		});
	}
</script>
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
            <div>
            	<div style="width:797px;">
                <?php
                    // Recordset: Categoria
                    $query_Recordset2 = "SELECT categoria.categoria_id, categoria_nombre_en FROM categoria WHERE categoria_id=".$categoria_id." ORDER BY categoria_orden ASC";
                    $Recordset2 = mysql_query($query_Recordset2, $connection) or die("Database error.");
					$row_Recordset2 = mysql_fetch_assoc($Recordset2);
					// Show category name
				?>                
						<div class="f_white f_12" style="float:left; text-align:left; padding-bottom:5px;">
                        	&nbsp;
                        	<div class="f_red f_21" style="text-align:left;">
								<?=strtoupper(strip_tags($row_Recordset2['categoria_nombre_en']))?>
                            </div>	
                        </div>
                        <div class="f_white f_12" style="float:right; text-align:right; padding-bottom:5px;">
                            PRODUCTS >
                            <div class="f_red f_21" style="text-align:right;">
                            	<?php echo strtoupper(strip_tags($row_Recordset1['producto_nombre_en'])); ?>
                            </div>
                        </div>
                        <div style="background-color:#FFFFFF; height:1px; margin-top:4px; margin-bottom:14px; width:100%; clear:both" /></div>
                <div style="float:left; width:180px; text-align:left;">
                <?  
                    // While rows in Recordset: Categoria
                    do {
                        
                        // Recordset: Productos (Listado)
                        $query_Recordset3 = sprintf("SELECT producto.categoria_id as p_categoria_id, producto.producto_id, producto_nombre_en FROM producto JOIN (color, talle) ON (producto.producto_id=color.producto_id AND producto.producto_id=talle.producto_id) WHERE producto_ocultar=0 AND producto.categoria_id=%s GROUP BY color.producto_id, talle.producto_id ORDER BY producto_nombre_en ASC",
                                            GetSQLValueString($row_Recordset2['categoria_id'], "int"));	
                        $Recordset3 = mysql_query($query_Recordset3, $connection) or die("Database error.");
                        $totalRows_Recordset3 = mysql_num_rows($Recordset3);				
                        
                        // If rows in Recordset: Productos (Listado)
                        if ($totalRows_Recordset3>0) {
        
                            // Show product container
                            echo '<div class="f_white f_13"><ul>';
        
                            // While rows in Recordset: Productos (Listado)
                            while ($row_Recordset3 = mysql_fetch_assoc($Recordset3)) {						
                                echo '<li style="margin-bottom:5px;"><a href="products.php?id='.$row_Recordset3['producto_id'].'&categoria_id='.$row_Recordset3['p_categoria_id'].'" class="'.($row_Recordset1['producto_id']==$row_Recordset3['producto_id'] ? "f_red" : "f_white").'">'.$row_Recordset3['producto_nombre_en'].'</a></li>';
                            }					
                            
                            // Close product container
                            echo '</ul></div>';
                            
                        } // End: If rows in Recordset: Productos (Listado)
                        
                        // Close Recordset: Productos (Listado)
                        mysql_free_result($Recordset3);				
                        
                    }while($row_Recordset2 = mysql_fetch_assoc($Recordset2)); // End: While rows in Recordset: Categoria
                    
                    // Close Recordset: Categoria
                    mysql_free_result($Recordset2);
                ?>        
                </div>
                <div style="display:table-cell; float:left; padding-right:70px;">
                	<table cellpadding="0" cellspacing="0" style="padding-top:30px;">
                    	<tr>
                        	<td valign="bottom">
                            	<a href=""><img src="../img/flecha_s_izq.png" border="0" /></a>
                            </td>
                        	<td valign="bottom" style="display: inline-block; width:252px;" align="center">
		                        <a href="javascript:openImageBig(<?php echo $row_Recordset1['producto_id']; ?>);"><img src="../img/template1.png" border="0" /></a>
                            </td>
                        	<td valign="bottom">
		                        <a href=""><img src="../img/flecha_s_der.png" border="0" /></a>
                            </td>
                        </tr>
                    </table>
                </div>
                <div style="float:left; width:272px;">
                	<div class="f_red f_13" style="text-align:right; padding-bottom:20px;">
                    	+ PICTURES
                        <br /><br /><img src="../img/template.png" />&nbsp;<img src="../img/template.png" />&nbsp;<img src="../img/template.png" />
                    </div>
                    <?php if ($totalRows_Recordset1>0) { ?>
                        <div>
                            <div class="f_white f_12" style="text-align:left; margin-top:10px; margin-bottom:20px;">
                            <?php echo strip_tags($row_Recordset1['producto_desc_en']); ?>
                            </div>
                            <form name="frmAddProduct" id="frmAddProduct" action="bag.php" method="post" class="formProd">
                                <div style="float:right">
                                	<table cellpadding="0" cellspacing="0" class="f_white f_12">
                                    	<tr>
                                            <td align="left" style="height:30px;" valign="middle">&nbsp;</td>
                                            <td align="left" style="height:30px;" valign="middle">                                    
                                            </td>
                                        </tr>
                                    	<tr>
                                            <td align="left" style="height:30px;" valign="middle"><b>QUANTITY:&nbsp;</b></td>
                                            <td align="left" style="height:30px;" valign="middle">
                                                <select name="item_cantidad" id="item_cantidad">
                                                    <option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option>
                                                </select>                                       
                                            </td>
                                        </tr>
                                    	<tr>
                                            <td align="left" style="height:30px;" valign="middle"><b>PRICE:</b></td>
                                            <td align="left" style="height:30px;" valign="middle">
												US$ <?php echo $row_Recordset1['producto_precio']; ?>                                       
                                            </td>
                                        </tr>
                                    	<tr>
                                            <td align="left" style="height:30px;" valign="middle"><b>SHIPPING:&nbsp;</b></td>
                                            <td align="left" style="height:30px;" valign="middle">
                                                US$ XXX                                      
                                            </td>
                                        </tr>
                                    	<tr>
                                            <td align="left" style="height:30px;" valign="middle"><b>TOTAL:</b></td>
                                            <td align="left" style="height:30px;" valign="middle">
												US$ <?php echo $row_Recordset1['producto_precio']; ?>                                       
                                            </td>
                                        </tr>   
                                    	<tr>
                                            <td align="left" style="height:30px;" valign="middle">
                                                <input type="hidden" name="producto_id" id="producto_id" value="<?php echo $row_Recordset1['producto_id']; ?>" />
                                                <input type="hidden" name="action" id="action" value="add"  />                 
                                                <input type="submit" name="submit" id="submit" value="GO" />
                                            </td>
                                            <td align="left" style="height:30px;" valign="middle">&nbsp;</td>
                                        </tr>                                 
                                    </table>
                                </div>
                                <div style="float:left">
                                	<table cellpadding="0" cellspacing="0" class="f_white f_12">
                                    	<tr>
                                            <td align="left" style="height:30px;" valign="middle"><b>STYLE:</b></td>
                                            <td align="left" style="height:30px;" valign="middle">
                                            <select name="talle_id" id="talle_id">
                                                <?php
                                                    // Recordset: Talle
                                                    $query_Recordset4 = sprintf("SELECT talle.talle_id, talle_nombre_en FROM talle WHERE talle.producto_id=%s ORDER BY talle_nombre_en ASC",
                                                                        GetSQLValueString($row_Recordset1['producto_id'], "int"));	
                                                    $Recordset4 = mysql_query($query_Recordset4, $connection) or die("Database error.");
                                                    // While rows in Recordset: Talle
                                                    while ($row_Recordset4 = mysql_fetch_assoc($Recordset4)) {									
                                                        echo '<option value="'.$row_Recordset4['talle_id'].'">'.$row_Recordset4['talle_nombre_en'].'</option>';
                                                    }
                                                    // Close Recordset: Talle
                                                    mysql_free_result($Recordset4)
                                                ?>
                                            </select>                                        
                                            </td>
                                        </tr>
                                    	<tr>
                                            <td align="left" style="height:30px;" valign="middle"><b>TYPE:</b></td>
                                            <td align="left" style="height:30px;" valign="middle">
                                            <select name="talle_id" id="talle_id">
                                                <?php
                                                    // Recordset: Talle
                                                    $query_Recordset4 = sprintf("SELECT talle.talle_id, talle_nombre_en FROM talle WHERE talle.producto_id=%s ORDER BY talle_nombre_en ASC",
                                                                        GetSQLValueString($row_Recordset1['producto_id'], "int"));	
                                                    $Recordset4 = mysql_query($query_Recordset4, $connection) or die("Database error.");
                                                    // While rows in Recordset: Talle
                                                    while ($row_Recordset4 = mysql_fetch_assoc($Recordset4)) {									
                                                        echo '<option value="'.$row_Recordset4['talle_id'].'">'.$row_Recordset4['talle_nombre_en'].'</option>';
                                                    }
                                                    // Close Recordset: Talle
                                                    mysql_free_result($Recordset4)
                                                ?>
                                            </select>                                        
                                            </td>
                                        </tr>
                                    	<tr>
                                            <td align="left" style="height:30px;" valign="middle"><b>SIZE:</b></td>
                                            <td align="left" style="height:30px;" valign="middle">
                                            <select name="talle_id" id="talle_id">
                                                <?php
                                                    // Recordset: Talle
                                                    $query_Recordset4 = sprintf("SELECT talle.talle_id, talle_nombre_en FROM talle WHERE talle.producto_id=%s ORDER BY talle_nombre_en ASC",
                                                                        GetSQLValueString($row_Recordset1['producto_id'], "int"));	
                                                    $Recordset4 = mysql_query($query_Recordset4, $connection) or die("Database error.");
                                                    // While rows in Recordset: Talle
                                                    while ($row_Recordset4 = mysql_fetch_assoc($Recordset4)) {									
                                                        echo '<option value="'.$row_Recordset4['talle_id'].'">'.$row_Recordset4['talle_nombre_en'].'</option>';
                                                    }
                                                    // Close Recordset: Talle
                                                    mysql_free_result($Recordset4)
                                                ?>
                                            </select>                                        
                                            </td>
                                        </tr>
                                    	<tr>
                                            <td align="left" style="height:30px;" valign="middle"><b>MEASURES:&nbsp;</b></td>
                                            <td align="left" style="height:30px;" valign="middle">
                                            <select name="talle_id" id="talle_id">
                                                <?php
                                                    // Recordset: Talle
                                                    $query_Recordset4 = sprintf("SELECT talle.talle_id, talle_nombre_en FROM talle WHERE talle.producto_id=%s ORDER BY talle_nombre_en ASC",
                                                                        GetSQLValueString($row_Recordset1['producto_id'], "int"));	
                                                    $Recordset4 = mysql_query($query_Recordset4, $connection) or die("Database error.");
                                                    // While rows in Recordset: Talle
                                                    while ($row_Recordset4 = mysql_fetch_assoc($Recordset4)) {									
                                                        echo '<option value="'.$row_Recordset4['talle_id'].'">'.$row_Recordset4['talle_nombre_en'].'</option>';
                                                    }
                                                    // Close Recordset: Talle
                                                    mysql_free_result($Recordset4)
                                                ?>
                                            </select>                                        
                                            </td>
                                        </tr>
                                    	<tr>
                                            <td align="left" style="height:30px;" valign="middle"><b>COLOR:</b></td>
                                            <td align="left" style="height:30px;" valign="middle">
                                        <select name="color_id" id="color_id" style="width:55px;">
                                            <?php
                                                // Recordset: Color
                                                $query_Recordset5 = sprintf("SELECT color.color_id, color_nombre_en FROM color WHERE color.producto_id=%s ORDER BY color_nombre_en ASC",
                                                                    GetSQLValueString($row_Recordset1['producto_id'], "int"));	
                                                $Recordset5 = mysql_query($query_Recordset5, $connection) or die("Database error.");
                                                // While rows in Recordset: Color
                                                while ($row_Recordset5 = mysql_fetch_assoc($Recordset5)) {									
                                                    echo '<option value="'.$row_Recordset5['color_id'].'">'.$row_Recordset5['color_nombre_en'].'</option>';
                                                }
                                                // Close Recordset: Color								
                                                mysql_free_result($Recordset5)
                                            ?>
                                        </select>                                      
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </form>
                        </div>
                    <?php } ?>            
                </div>
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