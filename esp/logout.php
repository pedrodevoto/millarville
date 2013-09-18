<?php
// *** Logout the current user.
$logoutGoTo = "main.php";

if (!isset($_SESSION)) {
	session_start();
}

$_SESSION['User_MM_Username'] = NULL;
$_SESSION['User_MM_UserGroup'] = NULL;
$_SESSION['User_PrevUrl'] = NULL;
unset($_SESSION['User_MM_Username']);
unset($_SESSION['User_MM_UserGroup']);
unset($_SESSION['User_PrevUrl']);

// Custom session variables
$_SESSION['User_MM_UserID'] = NULL;
unset($_SESSION['User_MM_UserID']);

if ($logoutGoTo != "") {
	header("Location: $logoutGoTo");
	exit;
}
?>