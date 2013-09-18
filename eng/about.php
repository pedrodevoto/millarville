<?php
if (!isset($_SESSION)) {
  session_start();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Millarville Web Site - About Us</title>
<?php include('../inc/library.php'); ?>
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
        	<div style="text-align:center; width:600px; padding-top:10px;" class="f_white f_15">
            	<div style="padding-bottom:3px;">
            		<span class="f_21">MILLARVILLE</span> IS THE CREATION OF A POLO BRAND
                </div>
            	<div style="padding-bottom:5px;">
                	THAT OFFERS FIRST QUALITY POLO PRODUCTS FOR ALL PLAYERS AND HORSES,
                </div>
            	<div style="padding-bottom:15px;">
                	EMPHASIZING ON THE PASSION FOR THE SPORT IN ALL ITS LEVELS.
                </div>
                <div style="float:left; width:260px; text-align:right; padding-top:20px;">
                    <img src="../img/about.png" width="249" height="257" />            
                </div>
                <div style="float:right; width:300px; padding-left:20px; text-align:left; padding-top:20px;" class="f_white f_13">
                    <div style="width:328px;">
                        With a concept of variety and flexibility, these products contain the simplicity and detail required in the making in order to achieve the best performance when playing polo, always highlighting style, elegance and perfection.<br />
                        <br /><br /><br />
                        <span class="f_brown f_30"><img src="../img/products_about.png" /></span><br /><br />
                        Millarville relies on first quality suppliers for the design and manufacturing of leather equipment, and apparel. A detailed market research has been made for this among the best providers of Argentina, as well as independent producers who offer a distinctive pattern for certain products.				
                    </div>
              </div>
            </div>
		</div>            
        <?php include('inc/bottom.php');?>
    </div>
</div>
</body>
</html>