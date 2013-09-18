<?php
if (!isset($_SESSION)) {
  session_start();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Millarville Web Site - Contact</title>
<?php include('../inc/library.php'); ?>
<style>
	html{
		height:100%;
	}
</style>
</head>

<body>
<div align="center">
	<?php include('inc/header.php');?>
    <div id="main">
        <?php include('inc/menu.php');?>
        <div id="separator5"></div>
    	<div id="content" style="position:relative">
			<img src="../img/polo.jpg" height="100%" width="100%" />
            <div style="position:absolute; width:100%; top:0;; padding-top:40px; z-index:5;" align="center">
            	<div style="width:797px;">
                    <div style="width:260px; float:left">
                        <div class="f_white f_21">MILLARVILLE POLO TEAM</div>
                        <div id="separator4"></div>
                        <div class="f_red f_14" style="text-align:left">
                        > ADVICE
                        </div>
                        <div class="f_white f_12" style="margin-top:20px; text-align:left">
                        Millarville offers clients total supervision for the team's clothing, from designing jerseys to putting toghether the whole equipment for players and horses. Our main goal is to provide counseling and advice to the team to look great in the field and the palenque.
                        <br /><br />
                        We offer:<br />
                        - Image and fashion design<br />
                        - Production<br />
                        - Contact with suppliers
                        </div>
                    </div>
                    <div style="float:right" class="f_white f_21">
	                    + PICTURES
                    </div>
                </div>
            </div>
		</div>

        <?php include('inc/bottom.php');?>
    </div>
</div>
</body>
</html>