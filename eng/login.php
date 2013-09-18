<?php
	// Require connection
	require_once('../Connections/connection.php');
	// Require DB functions
	require_once('../inc/db_functions.php');	
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
	$_SESSION['User_PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['Email'])) {
	
	$loginUsername=$_POST['Email'];
	$password=$_POST['Pass'];
	$MM_fldUserAuthorization = "";
	$MM_redirectLoginSuccess = "main.php";
	$MM_redirectLoginFailed = "error.php";
	$MM_redirecttoReferrer = true;
  
	$LoginRS__query=sprintf("SELECT usuario.usuario_id, usuario_email, usuario_pass FROM `usuario` WHERE usuario_email=%s AND usuario_pass=SHA1(%s)",
    				GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
	$LoginRS = mysql_query($LoginRS__query, $connection) or die("Database error.");
	$loginFoundUser = mysql_num_rows($LoginRS);
  
	if ($loginFoundUser) {
		$loginStrGroup = "";
		// Custom variables
		$loginUserID = mysql_result($LoginRS,0,'usuario_id');		
    
		if (PHP_VERSION >= 5.1) {
			session_regenerate_id(true);
		} else {
			session_regenerate_id();
		}

		//declare two session variables and assign them
		$_SESSION['User_MM_Username'] = $loginUsername;
		$_SESSION['User_MM_UserGroup'] = $loginStrGroup;	      
		
		// Custom session variables
		$_SESSION['User_MM_UserID'] = $loginUserID;		

		if (isset($_SESSION['User_PrevUrl']) && true) {
			$MM_redirectLoginSuccess = $_SESSION['User_PrevUrl'];	
		}
		header("Location: " . $MM_redirectLoginSuccess);

	} else {
		header("Location: ". $MM_redirectLoginFailed );
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Millarville Web Site - Login</title>
<?php include('../inc/library.php'); ?>
<script language="javascript" type="text/javascript">
	$(document).ready(function() {	
		$('#Email').focus();
	});
</script>
</head>

<body>
<div align="center">
	<?php include('inc/header.php');?>
    <div id="main">    
        <?php include('inc/menu.php');?>
        <div id="separator" /></div>
    	<div id="content">  
            <div id="innercontent">  
                      
            	<h1 class="header1">Login</h1>
                <hr />
                
                <?php
					if(isset($_GET['register']) && $_GET['register']=="true") {
						echo '<p class="f_12 f_white" align="center"><strong>Registration success. Please login to continue:</strong></p>';
					}
				?>

				<div align="center">
                    <form name="frmLogin" id="frmLogin" method="POST" action="<?php echo $loginFormAction; ?>" class="formLog">
                        <label for="Email">E-mail</label>
                        <input type="text" name="Email" id="Email" maxlength="255" />
                        <label for="Pass">Password</label>
                        <input type="password" name="Pass" id="Pass" maxlength="32" />
                        <input type="submit" name="Login" id="Login" value="LOGIN" />
                    </form>   			
                </div>
                                                                                   
            </div>                    		                   
        </div>
        <?php include('inc/bottom.php');?>
    </div> 
</div>
</body>
</html>