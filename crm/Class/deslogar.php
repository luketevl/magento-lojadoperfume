<?php
session_start();
$_SESSION['LOGADO']=false;
$_SESSION['idUser']="";
session_destroy();
@header("Location: ../login.php");

?>