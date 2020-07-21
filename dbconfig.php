<?php
	$server = 'imc.kean.edu';
	$login = 'bhatiaha';
	$pass = '1065589';
	$dbname = 'CPS3740';

	$conn = mysqli_connect($server, $login, $pass, $dbname) or 
	die("Cannot establish connection to DB");
?>