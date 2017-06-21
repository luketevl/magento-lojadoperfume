<?php
$login=$_POST['txtLogin'];
$senha=$_POST['txtSenha'];
include_once("manipulateData.php");
$verificaLogin = new ManipulateData();

$sql="SELECT * FROM USUARIO WHERE login='$login' and SENHA='$senha' and SITUACAO='A'  ";

$conta = $verificaLogin->operacao($sql,"count");
if($conta>0){
	$post = $verificaLogin->operacao($sql,"listagem");
	session_start();
	$_SESSION['idUser']=$post[0]['ID'];	
	$_SESSION['LOGADO']=true;
	@header("Location: ../index.php");	
   }

else if($conta==0){
	@header("Location: ../login.php?erro=1");
}
?>