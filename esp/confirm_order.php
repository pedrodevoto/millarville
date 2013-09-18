<?php
if (!isset($_SESSION)) {
  session_start();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Millarville Web Site - Confirmación de pedido</title>
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
                      
            	<h1 class="header1">Confirmación de pedidos</h1>
                <hr />

				<p class="f_white f_12"><strong>Su orden ha sido recibida.</strong><br />
                Los detalles de la misma han sido enviados a su casilla de e-mail.</p>                                                                                                    
	                
            </div>                    		                   
        </div>
        <?php include('inc/bottom.php');?>
    </div> 
</div>
</body>
</html>