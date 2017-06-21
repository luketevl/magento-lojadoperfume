<?php
include_once('ManipulateData.php');
$id=$_POST['idContato']; //unidade atual
$listagem = new ManipulateData();
if($listagem->operacao("UPDATE CONTATO SET EXCLUIDO='S' WHERE ID=".$id,"update"))
{
			$respost = array("retorno"=>"1");
			echo json_encode($respost);	
}
else
{
			$respost = array("retorno"=>"Erro ao excluir o contato");
			echo json_encode($respost);	
}
?>
