<?php
/*************************************************************************************
**	CLASSE EM PHP QUE FAZ A MANIPULAÇÃO DE DADOS NO BANCO DE DADOS MYSQL VERSÃO 1.0
**	DATA DA CRIAÇÃO: XX/XX/XXXX
**	DESENVOLVIDO POR: EVERTON WILLIAM
**	CÓDIGO LIVRE MANTIDO PELA GNU
**
**	ESTA CLASSE SÓ PODERÁ SER USANDO EM MODO DE HERANÇA...
**
**	CLASSE ABSTRATA PARA CONEXÃO COM BANCO DE DADOS.
**************************************************************************************/
include_once("mySqlConn.php");

class ManipulateData extends mySqlConn{
	
	protected $sql, $table, $fields, $dados, $status, $fieldId, $valueId; 

	//envia o nome da tabela a ser usada na classe
	public function setTable($t){
		$this->table = $t;
	}
	
	public function setSql($t){
		$this->sql = $t;
	}
	
	//envia os campos a serem usados na classe
	public function setFields($f){
		$this->fields = $f;
	}
	
	// envia os dados a serem usados na classe
	public function setDados($d){
		$this->dados = $d;
	}
	
	//envia o campo de pesquisa, normalmente o campo código
	public function setFieldId($fi){
		$this->fieldId = $fi;
	}
	
	// envia os dados a serem cadastrados ou pesquisados
	public function setValueId($vi){
		$this->valueId = $vi;
	}	
	
	//recebe o status atual, erros ou acertos
	public function getStatus(){
		return $this->status;
	}
	
	//método que efetua cadastro de dados no banco
	public function insert(){
		$this->sql = "INSERT INTO $this->table(
							$this->fields
					  )VALUES(
					  		$this->dados
					  )";
		if(self::execSql($this->sql)){
			$this->status = "Cadastrado com Sucesso!!!";
			return true;
		}
		else
		{
			return false;
		}		  
	}
	
	// método que efetua a exclusão de dados no banco
	public function delete(){
		$this->sql = "DELETE FROM $this->table WHERE $this->fieldId = '$this->valueId'";
		if(self::execSQL($this->sql)){
			$this->status = "Apagado com Sucesso!!!";
		}
	}
	
	// método que faz a alteraçao de dados no banco
	public function update(){		
		$this->sql = "UPDATE $this->table SET
							$this->fields
					  WHERE
					  		$this->fieldId = '$this->valueId'
					  ";
		if(self::execSql($this->sql)){
	
			$this->status = "Alterado com Sucesso!!!";
			return true;
		}
		else
		{
			return false;	
		}
	}

	//método que busca o ultimo código na tabela cadastrada
	public function getLastId(){
		$this->sql = "SELECT $this->fieldId FROM $this->table ORDER BY $this->fieldId DESC LIMIT 1";
		$this->qr = self::execSql($this->sql);
		$this->data = self::listQr($this->qr);
		return $this->data["$this->fieldId"];
	}
	
	// método que verifica se existem valores duplicados, returna 1 existe 0 nao existe
	public function getDadosDuplicados($valorPesquisado){
		$this->sql = "SELECT $this->fieldId FROM $this->table WHERE $this->fieldId = '$valorPesquisado'";
		$this->qr = self::execSql($this->sql);
		return self::countData($this->qr);
	}
	
	// método que verifica se existem valores duplicados, returna 1 existe 0 nao existe
	public function operacao($query,$tipo)
	{
		if($this->qr = self::execSql($query))
		{
			if ($tipo=='count'){
				return self::countData($this->qr);
			}
			else if ($tipo=='json'){
			    if(self::countData($this->qr)>0)
				{		
					  while ($post = self::listQr($this->qr)){
						  $retorno[] = $post;
						  }				
				}
				else
				{
					$retorno[] = array("erro"=>"Nenhum registro encontrado");	
				}
				return json_encode($retorno,JSON_PRETTY_PRINT);
			}
			else if ($tipo=='listagem'){	
				  
			  while ($post = self::listQr($this->qr)){
			   $retorno[] = $post;
			  }				
			  return $retorno;
			}
			else if ($tipo=='update'){
				return true;
			}else if ($tipo=='insert'){
				return true;
			}
			
		}else{
			return false;
			}
	}
	
	// método que busca o total de dadoa cadastrado em uma query
	public function getTotalData(){
		$this->sql = "SELECT $this->fieldId FROM $this->table ORDER BY $this->fieldId";
		$this->qr = self::execSql($this->sql);
		return self::countData($this->qr);
	}
	public function consultar(){
		$this->qr = self::execSql($this->sql);
		return self::listQr($this->qr);
	}
	
}


?>