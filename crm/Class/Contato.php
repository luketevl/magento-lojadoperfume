<?php
$nome=$_POST["nome"];
$empresa=$_POST["empresa"];
$contato=$_POST["contato"];
$telefone=$_POST["telefone"];
$celular=$_POST["celular"];
$email=$_POST["email"];
$site=$_POST["site"];


include_once('manipulateData.php');
$cadastrar = new ManipulateData();
$cadastrar->setTable('contato');

$cadastrar->setFields('nome,fantasia,nome_contato,telefone,celular,email,site,excluido,atendido');
$cadastrar->setDados(" '$nome','$empresa','$contato','$telefone','$celular','$email','$site','N','N'");
if ($cadastrar->insert())
{
        $respost = array("retorno"=>"1");
        echo json_encode($respost);
}
else
{
        $respost = array("retorno"=>"Erro ao enviar contato!");
        echo json_encode($respost);
}
	

?>