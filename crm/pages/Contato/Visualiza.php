<!DOCTYPE html>
<html>
  <head>
    <title>Visualiza</title>
    
  </head>
  <body class="skin-blue">
   <div class="container-fluid">
        <div class="row">
        	<div class="col-md-12 title-popup">
            	<span>DADOS DO CONTATO</span>
            </div>
            <div class="col-md-12">               	                                           	
                <div class="col-md-12">
                     
                      <div class="form-group col-md-6">   
                        <label >
                            Nome:
                        </label>                                                                        
                               <input class="form-control" id="txtNome" readonly="readonly" placeholder="" name="txtNome" type="text" />                                                        
                      </div> 
                      <div class="form-group col-md-6">   
                        <label >
                            Empresa:
                        </label>                                                                        
                               <input class="form-control" id="txtEmpresa" readonly="readonly" placeholder="" name="txtEmpresa" type="text" />                                                        
                      </div>
                      <div class="form-group col-md-6">   
                        <label >
                            Nome Contato:
                        </label>                                                                        
                               <input class="form-control" id="txtContato" readonly="readonly" placeholder="" name="txtContato" type="text" />                                                        
                      </div>
                      <div class="form-group col-md-6">   
                        <label >
                            Site:
                        </label>                                                                        
                               <input class="form-control" id="txtSite" readonly="readonly" placeholder="" name="txtSite" type="text" />                                                        
                      </div>
                      
                      <div class="form-group col-md-4">   
                        <label >
                            Telfone:
                        </label>                                                                        
                               <input class="form-control" id="txtTelefone" readonly="readonly" placeholder="" name="txtTelefone" type="text" />                                                        
                      </div>
                      <div class="form-group col-md-4">   
                        <label >
                            Celular:
                        </label>                                                                        
                               <input class="form-control" id="txtCelular" readonly="readonly" placeholder="" name="txtCelular" type="text" />                                                        
                      </div>
                      <div class="form-group col-md-4">   
                        <label >
                            E-mail:
                        </label>                                                                        
                               <input class="form-control" id="txtEmail" readonly="readonly" placeholder="" name="txtEmail" type="text" />                                                        
                      </div>
                     
                      <div class="col-md-6"></div>    
                      <div class="col-md-6">
                           <button type="button" data-dismiss="modal" aria-hidden="true" id="btnCancelaFatura" name="btnCancelaFatura" onclick="excluiContato()" class=" btn btn-danger col-md-6">
                             EXCLUIR ATENDIMENTO
                           </button> 
                           <button type="button"  data-dismiss="modal" aria-hidden="true" id="btnAcessaFatura" name="btnAcessaFatura" onclick="atenderContato('S')" class=" btn btn-primary col-md-6">
                             ATENDER
                           </button> 
                      </div> 
                      
                </div>
                                                                 
            </div>        
        </div>
    </div>	
  
   <script src="js/jquery.1.12.4.js" type="text/javascript"></script>   
   <script src="js/jquery.dataTables.min.js" type="text/javascript"></script>
  
   <script>
        function excluiContato()
        {
            $.ajax({			  
            url: "Class/ExcluiContato.php",
            cache:false,	
            method:"post",
            data:{idContato:$('#edtIDContato').val()},
            dataType: "json",			  		  			  
            error:function(){	
                    alert('Erro');	
                    },
            success: function(retorno){	
                    
                    if (retorno.retorno=="1"){
                        alert("Excluido com sucesso!");
                        //carregaGridContato('T');   
                        window.location.reload();         
                           }
                    else{					
                        alert(retorno.erro);                            
                        }
                    }
          });
        }
        function atenderContato(Status2)
        {
            
            $.ajax({			  
            url: "Class/AtenderContato.php",
            cache:false,	
            method:"post",
            data:{idContato:$('#edtIDContato').val(),Status:Status2},
            dataType: "json",			  		  			  
            error:function(){	
                    alert('Erro');	
                    },
            success: function(retorno){		                   
                    if (retorno.retorno=="1"){					 
                         alert("Status alterado com sucesso!");   
                         //carregaGridContato('T'); 
                         window.location.reload();
                           }
                    else{
                          alert(retorno.erro);                          
                        }
                    }
          });
        }
   </script>
  </body>
</html>