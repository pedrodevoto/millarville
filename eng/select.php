<?php
if (!isset($_SESSION)) {
  session_start();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Millarville Web Site - Please select an option to continue</title>
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
                      
            	<h1 class="header1">Please login or register to continue</h1>
                <hr />
				<div class="f_12 f_white" style="margin-top:30px">
                	<ul class="list1">
						<li><a href="login.php?accesscheck=checkout.php" class="f_orange"><strong>LOGIN</strong></a> (existing user)</li>
                    	<li><a href="register.php?accesscheck=checkout.php" class="f_orange"><strong>REGISTER</strong></a> (new user)</li>
                    </ul>
				</div>
                                                                                                   
            </div>                    		                   
        </div>
        <?php include('inc/bottom.php');?>
    </div> 
</div>
</body>
</html>