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
	// Require general functions
	require_once('../inc/general_functions.php');		
?>
<?php
	// Recordset: Producto
	$colname_Recordset1 = "abc123!";
	if (isset($_GET['query']) && $_GET['query']!="") {
		$colname_Recordset1 = $_GET['query'];
	}	
	$query_Recordset1 = sprintf("SELECT producto.producto_id, producto_nombre_es, producto_desc_es FROM producto JOIN (color, talle) ON (producto.producto_id=color.producto_id AND producto.producto_id=talle.producto_id) WHERE producto_ocultar=0 AND (producto_nombre_es LIKE %s OR producto_desc_es LIKE %s) GROUP BY color.producto_id, talle.producto_id ORDER BY producto_nombre_es ASC LIMIT 10",
						GetSQLValueString('%'.$colname_Recordset1.'%', "text"),
						GetSQLValueString('%'.$colname_Recordset1.'%', "text"));	
	$Recordset1 = mysql_query($query_Recordset1, $connection) or die("Database error.");	
	$totalRows_Recordset1 = mysql_num_rows($Recordset1);	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Millarville Web Site - Resultados</title>
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
            	<h1 class="header1">Resultados de la búsqueda</h1>
				
				<?php
					// If query was specified
                	if (isset($_GET['query']) && $_GET['query']!="") {
						
	                 	echo '<p class="f_white f_12">Resultados para el término "'.$_GET['query'].'" (mostrando 10 resultados)</p>';                
                    	echo '<hr />';
                    
						// If results were found
						if ($totalRows_Recordset1>0) {
							                                   
                        	echo '<ul class="list1">';
                        
							// While rows in Recordset: Producto
							while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)) {	  
							
								echo '<li class="f_white f_12"><a href="products.php?id='.$row_Recordset1['producto_id'].'" class="f_orange">'.$row_Recordset1['producto_nombre_es'].'</a><br />';
								echo trim_text($row_Recordset1['producto_desc_es'], 100, true, true).'</li>';
                           
                           	} // End: While rows in Recordset: Producto
                            
                        	echo '</ul>';
               
						} else {
                        	echo '<p class="f_white f_12">No se encontraron resultados.</p>';
						} // End: If results were found
                                 
	                } else {
						echo '<p class="f_white f_12">No realizó ninguna consulta. Intente nuevamente.</p>';
					} // End: If query was specified
                ?>                                                                
                
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