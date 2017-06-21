<?php
session_start();
if ($_SESSION['LOGADO']==false)
 {
	@header("Location: login.php");
 }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CobreOn</title>

    <meta name="description" content="Source code generated using layoutit.com">
    <meta name="author" content="LayoutIt!">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/MedGrid.css" rel="stylesheet">
    <link href="css/datatable.css" rel="stylesheet">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    
     <script src="js/datatable.js"></script>
  
    <script src="js/scripts.js"></script>    
    <style>
		body{
			background:#e5e5e5;
			}
	</style>
<?php    
include_once('Class/ManipulateData.php');
$idUser=$_SESSION['idUser'];

$list = new ManipulateData();
$retorno = $list->operacao("SELECT U.NOME AS USUARIO,E.FANTASIA,E.NOME AS RAZAO_SOCIAL FROM USUARIO U INNER JOIN EMPRESA E ON E.ID=U.ID_EMPRESA WHERE U.ID = $idUser","listagem");
if($retorno[0]['FANTASIA'] !== "")
{
	$empresa = $retorno[0]['FANTASIA'];
}
else
{
	$empresa = $retorno[0]['RAZAO_SOCIAL'];	
}
echo "
<script>
$(document).ready(function(){
		$('#pnlNome').html('Bem vindo ".$retorno[0]['USUARIO']." / ".$empresa."');
});
</script>
";

?>    
  </head>
  <body>

  	<div class="modal fade" id="modal-meioPagamento" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <div class="modal-header">
                     
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                    <?php 
                        include_once('secao/meioPagamento.php');
                            
                    ?>
                    
                </div>						
            </div>
            
        </div>
               				
	</div>
    
    <div class="modal fade" id="modal-meioPagamento" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <div class="modal-header">
                     
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                    <?php 
                        include_once('secao/meioPagamento.php');
                            
                    ?>
                    
                </div>						
            </div>
            
        </div>
               				
	</div>
    
    <div class="modal fade" id="modal-visualizaCobranca" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <div class="modal-header">
                     
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                    <?php 
                        include_once('secao/visualizaCobranca.php');
                            
                    ?>
                    
                </div>						
            </div>
            
        </div>
               				
	</div>

    <div class="modal fade" id="modal-novaCobranca" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <div class="modal-header">
                     
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                    <?php 
                        include_once('secao/novaCobranca.php');
                            
                    ?>
                    
                </div>						
            </div>
            
        </div>
               				
	</div>
    <div class="modal fade" id="modal-configEmail" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <div class="modal-header">
                     
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                    <?php 
                        include_once('secao/configEmail.php');
                            
                    ?>
                    
                </div>						
            </div>
            
        </div>
               				
	</div>
    
    <div class="modal fade" id="modal-cadCliente" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <div class="modal-header">
                     
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                    <?php 
                        include_once('secao/cadClientes.php');
                            
                    ?>
                    
                </div>						
            </div>
            
        </div>
               				
	</div>
    <div class="modal fade" id="modal-cadEmpresa" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <div class="modal-header">
                     
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                    <?php 
                        include_once('secao/cadEmpresa.php');
                            
                    ?>
                    
                </div>						
            </div>
            
        </div>
               				
	</div>
   <div class="modal fade" id="modal-cadUser" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <div class="modal-header">
                     
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                    <?php 
                        include_once('secao/cadUser.php');
                            
                    ?>
                    
                </div>						
            </div>
            
        </div>
               				
	</div>

  <div class="modal fade" id="modal-localizaEmpresa" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content ">
						<div class="modal-header">
							 
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
								×
							</button>
							<?php 
								include_once('secao/localizaEmpresa.php');
									
							?>
                            
						</div>						
					</div>
					
				</div>
                
				
	</div>
    <div class="modal fade" id="modal-localizaCliente" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content ">
						<div class="modal-header">
							 
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
								×
							</button>
							<?php 
								include_once('secao/localizaClientes.php');
									
							?>
                            
						</div>						
					</div>
					
				</div>
               
				
	</div>
  	<div id="all">
  	
           <div class="row"> 
            <header id="topo" class="col-md-12">
                <nav>
                    <div class="row">                            
                        <div class="col-md-12">
                           <ul class="nav">  
                           		
                                <a  href="?secao=pesCobranca&tp=local">                         		
                                <li class="cob col-md-2" id="btnCobrancas">
                                	<center>	
                                    	
                                           <table border="0">
                                              <tr>
                                                <td><img class="icon" src="images/icon-cobranca.png" alt=""></td>
                                              </tr>
                                              <tr>
                                                <td><span>COBRANÇAS</span></td>
                                              </tr>
                                            </table>
                                         
                                     </center>                                     
                                    
                                </li>
                                </a>
                                <a  href="?secao=pesClientes&tp=local">                                	                                
                                <li class="cli col-md-2" id="btnClientes">
                                	<center>	
                                     	
                                       <table border="0">
                                          <tr>
                                            <td><img class="icon" src="images/icon-cliente.png" alt=""></td>
                                          </tr>
                                          <tr>
                                            <td><span>CLIENTES</span></td>
                                          </tr>
                                        </table>
                                      
                                     </center>                                                                    
                                </li>
                                </a>
                                <li class="con  col-md-2" id="btnCONFIG">
                                    <center>	
                                       <table border="0">
                                          <tr>
                                            <td><img class="icon" src="images/icon-adm.png" alt=""></td>
                                          </tr>
                                          <tr>
                                            <td><span>CONFIGURAÇÃO</span></td>
                                          </tr>
                                        </table>
                                     </center>
                                    
                                    
                                </li>    
                                <li class="adm  col-md-2" id="btnADM">
                                    <center>	
                                       <table border="0">
                                          <tr>
                                            <td><img class="icon" src="images/icon-adm.png" alt=""></td>
                                          </tr>
                                          <tr>
                                            <td><span>ADMINISTRAÇÃO</span></td>
                                          </tr>
                                        </table>
                                     </center>
                                    
                                    
                                </li> 
                                <li class="pnl  col-md-2" id="btnPNL">
                                    <center>	
                                       <table border="0">
                                          <tr>
                                            <td><img class="icon" src="images/icon-pnl.png" alt=""></td>
                                          </tr>
                                          <tr>
                                            <td><span>MEU PAINEL</span></td>
                                          </tr>
                                        </table>
                                     </center>
                                    
                                    
                                </li>  
                                                    
                            </ul>          
                        </div>
                        
                    </div>
                </nav> 
                <nav id="submenu" class="col-md-12">                	
                    <ul id="clientes" class="col-md-12">
                        <a href="#modal-cadCliente" data-toggle="modal" onClick="cadCliente();" id="modal-286623"> <li class=" col-md-2" id="">
                            <span>Cadastrar</span>
                        </li></a>                                  
					</ul>
                    <ul id="pnl" class="col-md-12">
                    	<li class=" col-md-4" id="">
                            <span id="pnlNome"></span>
                        </li>
                        <a href="#modal-cadCliente" data-toggle="modal" onClick="cadCliente();" id="modal-286623"> <li class=" col-md-2" id="">
                            <span>Alter Senha</span>
                        </li></a>
                        <a href="#modal-cadCliente" data-toggle="modal" onClick="cadCliente();" id="modal-286623"> <li class=" col-md-1" id="">
                            <span>Sair</span>
                        </li></a>                                  
					</ul>
                    <ul id="cobrancas" class="col-md-12">
                        <a href="#modal-novaCobranca" data-toggle="modal" id="modal-286623"> <li class=" col-md-2" id="">
                            <span>Nova Cobrança</span>
                        </li></a>   
                        <a href="?secao=pesCobranca&tp=local"> <li class=" col-md-2" id="">
                            <span>Pesquisar</span>
                        </li></a>                                                           
					</ul>            	
                    <ul id="adm" class="col-md-12">
                        <a href="#modal-cadEmpresa" data-toggle="modal" id="modal-286623"> <li class=" col-md-2" id="">
                            <span>Empresas</span>
                        </li></a>         
                        <a href="#modal-cadUser" data-toggle="modal" id="modal-286623"> <li class=" col-md-2" id="">
                            <span>Usúarios</span>
                        </li></a>                           
					</ul>  
                    <ul id="config" class="col-md-12">
                        <a href="#modal-meioPagamento" data-toggle="modal" id="modal-286623"> <li class=" col-md-2" id="">
                            <span>Meio de Pagamento</span>
                        </li></a> 
                        <a href="#modal-configEmail" data-toggle="modal" id="modal-286623"> <li class=" col-md-2" id="">
                            <span>E-MAIL</span>
                        </li></a>                                            
					</ul>                    
                </nav>                
            </header>
            </div>
         <section id="conteudo">
            <section id="menu">
              <div class="col-md-1">
              </div>
              <div class="col-md-10" id="page-section">
              	<?php
					include_once('Class/verUrl.php');				
					$red = new verURL();
					$red->trocarURL($_GET["secao"],$_GET["tp"]);		 
				?>
			    


              </div>
              <div class="col-md-1">
              </div>
              
           
          
            </section>
          
            
  	</section><!--FIM DO CONTEUDO -->
    <FOOTER id="rodape"> 
             <div class="col-md-4">
                <section>
                    <img alt="Logotipo" width="270" height="90" src="images/logo.png" />
                </section>    
             </div>                  
             <div class="col-md-8">    
                                                                                
             </div> 	
    </FOOTER> 
    <!--FIM DO ALL -->

    <script>
    	esconde();
		
		function cadCliente()
		{
			acaoCliente = 'C';
			$('#btnsalvarCliente').html('Cadastrar');
			limparCliente();
			$('#titleCadClientes').html('Cadastrar Cliente'); 	
		}
		
		$("#cobrancas").show();
				
		$("#btnCobrancas").click(function(){           
			//Sem parâmetros: o efeito é executado em 400ms
			
			esconde(); 
			$("#cobrancas").show();
			$("#topo").css("background","#18c20f");
			
			
		});	
		$("#btnClientes").click(function(){           
			//Sem parâmetros: o efeito é executado em 400ms
			
			esconde(); 
			$("#clientes").show();
			$("#topo").css("background","#383838");
		});
		
		$("#btnADM").click(function(){  				         
			//Sem parâmetros: o efeito é executado em 400ms
			
			esconde();
			$("#adm").show();
			$("#topo").css("background","#505069");
		});	
		$("#btnPNL").click(function(){  				         
			//Sem parâmetros: o efeito é executado em 400ms
			
			esconde();
			$("#pnl").show();
			$("#topo").css("background","#824803");
		});	
		
		$("#btnCONFIG").click(function(){  				         
			//Sem parâmetros: o efeito é executado em 400ms
			
			esconde();
			$("#config").show();
			$("#topo").css("background","#900");
		});	
    </script>
    <script>
	$(document).ready(function(e) {
        var chamada;
		var acaoCliente;
		var idClienteAltera;
		
    });		
	function chamadaClienteCobranca()
	{
		chamada = "cobranca";
	}
	function chamadaClienteNovaCobranca()
	{
		chamada = "novaCobranca";
	}
	</script>
    <?php
		if($_GET["secao"]=="pesCobranca")
		{
		  echo "	
		  <script>		  	
		 	esconde(); 
			$('#cobrancas').show();	
			$('#topo').css('background','#18c20f');
		  </script>	
			";
		}
		else if($_GET["secao"]=="pesClientes")
		{
		  echo "	
		  <script>
		 	esconde(); 
			$('#clientes').show();	
			$('#topo').css('background','#383838');
		  </script>	
			";
		}
		
	?>
    <?php
	if ($_SESSION['LOGADO']==true)
	 {
		if ($_SESSION['PERMISSAO']=="ADM")
		{ 
			echo "<script>$('#btnADM').show();</script>";
		}
		else
		{
			echo "<script>$('#btnADM').hide(); </script>";	
		}
	 }
	
	?>
  </body>
</html>