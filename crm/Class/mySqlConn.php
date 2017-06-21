<?php 
/*************************************************************************************
**	CLASSE EM PHP QUE FAZ A CONEXÃO COM O BANCO DE DADOS MYSQL VERSÃO 1.0
**	DATA DA CRIAÇÃO: XX/XX/XXXX
**	DESENVOLVIDO POR: EVERTON WILLIAM
**	CÓDIGO LIVRE MANTIDO PELA GNU
**
**	ESTA CLASSE SÓ PODERÁ SER USANDO EM MODO DE HERANÇA...
**
**	CLASSE ABSTRATA PARA CONEXÃO COM BANCO DE DADOS.
**************************************************************************************/
abstract class mySqlConn{

	protected $host, $user, $pass, $dba, $conn, $sql, $qr, $data, $status, $totalFields, $error;
	
	//método que incializa automaticamente as variáaveis de conexão
	public function __construct(){
		$this->host = "10.240.0.7";
		$this->user = "lojadope_crm";
		$this->pass = "Crm_101010";
		$this->dba = "lojadope_crm";	
		self::connect(); // eexecuta o método de conexão automaticamente ao herdar a classe
	}
	
	//método utilizando para efetuar a conexão com o banco de dados
	protected function connect(){
		$this->conn = @mysql_connect($this->host, $this->user, $this->pass) or die 
											("<b><center>Erro ao acessar banco de dados </b></center><br />".mysql_error());
		$this->dba = @mysql_select_db($this->dba) or die 
											("<b><center>Erro ao selecionar banco de dados: </b></center><br />".mysql_error());
	}
	// metodo utilizando para executar comandos SQL
	protected function execSQL($sql){
		$this->qr = @mysql_query($sql) or die ("<b><center>Erro ao Executar o Query: $sql - </b></center><br />".mysql_error());
		return $this->qr;
	}
	
	// método que executa e lista dados do banco de dados
	protected function listQr($qr){
		$this->data = @mysql_fetch_assoc($qr);
		return $this->data;
	}

	// método que lista a quantidade de dados encontrados no query
	protected function countData($qr){
		$this->totalFields = mysql_num_rows($qr);
		return $this->totalFields;
	}
}
?>