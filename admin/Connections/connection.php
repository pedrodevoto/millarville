<?php
	# FileName="Connection_php_mysql.htm"
	# Type="MYSQL"
	# HTTP="true"
	
	$hostname_connection = "internal-db.s145576.gridserver.com";
	$hostname_connection = "localhost";
	$database_connection = "db145576_millarville";
	$username_connection = "db145576";
	$password_connection = "Cha_Falex1416";
	$connection = mysql_pconnect($hostname_connection, $username_connection, $password_connection) or die("Database error."); 
	
	mysql_select_db($database_connection, $connection);
	mysql_query("SET CHARACTER SET utf8");
	mysql_query("SET NAMES utf8"); 
?>