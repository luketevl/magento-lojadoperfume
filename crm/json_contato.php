
<?php
include_once("Class/ManipulateData.php");
$atendido='';
if(isset($_GET["statusAtendimento"]))
{
  if($_GET["statusAtendimento"] == "A")
  {  
    $atendido='S';
  }
  else if($_GET["statusAtendimento"] == "N")
  {  
    $atendido='N';  
  }
}

if($atendido != "")
{
    $sql="SELECT *,IF(ATENDIDO='S','Atendido','Não Atendido') AS STATUS FROM CONTATO WHERE ATENDIDO='".$atendido."' AND EXCLUIDO='N'";
}
else
{
    $sql="SELECT *,IF(ATENDIDO='S','Atendido','Não Atendido') AS STATUS FROM CONTATO WHERE EXCLUIDO='N'";
}
$listagem = new ManipulateData();
if($listagem->operacao($sql,'count')>0)
{
    $json = array('data'=>$listagem->operacao($sql,'listagem'));
    echo  json_encode($json,JSON_PRETTY_PRINT);
}

?>

  