<?php
if (!isset($_SESSION)) {
  session_start();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Millarville Web Site - Nosotros</title>
<?php include('../inc/library.php'); ?>
</head>

<body>
<div align="center">
	<?php include('inc/header.php');?>
    <div id="main">
        <?php include('inc/menu.php');?>
        <div id="separator"></div>
    	<div id="content">
        	<div style="text-align:center; width:560px;" class="f_white f_14">
            	<div style="padding-bottom:3px;">
            		<span class="f_21">MILLARVILLE</span> ES UN EMPRENDIMIENTO QUE OFRECE LOS MEJORES
                </div>
            	<div style="padding-bottom:5px;">
                	PRODUCTOS DE POLO CON UNA EXCELENCIA EN SU CALIDAD PARA EL JUGADOR Y
                </div>
            	<div style="padding-bottom:15px;">
                	EL CABALLO, PRIORIZANDO LA PASIÓN POR EL DEPORTE EN TODAS SUS ETAPAS.
                </div>
            </div>
        	<div style="float:left; width:47%; text-align:right">
	            <img src="../img/about.jpg" width="268" height="266" />
            </div>
            <div style="width:6%">&nbsp;</div>
        	<div style="float:right; width:47%; text-align:left" class="f_white f_12">
            	<div style="width:308px;">
                    Con un concepto de variedad y flexibilidad, los productos de Alegría contienen la simplicidad y el detalle de fabricación para un buen desempeño a la hora de jugar buscando destacar el estilo, la elegancia y la perfección del polo en su totalidad.<br />
                    <br />
                    <span class="f_brown f_30">PRODUCTOS</span><br /><br />
                    Millarville cuenta con proveedores de primera calidad para el diseño y la fabricación de equipamiento de cuero e indumentaria. Para ello se ha hecho un estudio exhaustivo de los mejores proveedores del país, como así también productores independientes que le dan un sello distintivo a ciertos productos.
                </div>
          </div>
		</div>            
        <?php include('inc/bottom.php');?>
    </div>
</div>
</body>
</html>