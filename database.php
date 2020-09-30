<?php
$con = new MySQLi('localhost:3306','root','','php_login_database');

if ($con->connect_errno) {
	die("ERROR : -> ".$con->connect_error);
}
?>