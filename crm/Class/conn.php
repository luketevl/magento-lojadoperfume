<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "db_cobreon";
$connect = @mysqli_connect($host,$user,$pass,$db);
if(mysqli_connect_errno($connect)){
		echo "Falha ao conectar no banco de dados!";
		die;
	}	


?>