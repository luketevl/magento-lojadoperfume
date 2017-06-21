<?php
$postHash = $_POST['hash'];
$postToken = $_POST['token'];
$postCard = $_POST['card'];
if($postHash!=''){
	$fp = fopen("$postCard.txt", "w");
		$escreve = fwrite($fp, $postHash.';'.$postToken);
	fclose($fp);
}
?>