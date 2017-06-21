<?php
include_once('ManipulateData.php');
$id=$_POST['idContato']; //unidade atual
$listagem = new ManipulateData();
echo $listagem->operacao("SELECT * FROM CONTATO WHERE ID = ".$id,"json");
?>
