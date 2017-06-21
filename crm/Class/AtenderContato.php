<?php
include_once('ManipulateData.php');
$id=$_POST['idContato']; //unidade atual
$status=$_POST['Status'];

$listagem = new ManipulateData();
if($listagem->operacao("UPDATE CONTATO SET ATENDIDO='".$status."' WHERE ID=".$id,"update"))
{
			$respost = array("retorno"=>"1");
			echo json_encode($respost);	
}
else
{
			$respost = array("retorno"=>"Erro ao atender contato");
			echo json_encode($respost);	
}
?>
