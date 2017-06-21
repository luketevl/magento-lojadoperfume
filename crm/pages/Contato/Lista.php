<!DOCTYPE html>
<html>
  <head>
    <title>AdminLTE 2 | Calendar</title>
    <style>
        #btnPesquisar{
            width:25px;
            height:25px;            
            display: block;
            background: url("images/icon-pesquisa.png") center no-repeat ;
            background-size: 25px 25px;
        }
    </style>
  </head>
  <body class="skin-blue">
   <div class="modal fade " id="modal-visContato" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <div class="modal-header">
                     
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                    <?php 
                        include_once('pages/Contato/Visualiza.php');
                            
                    ?>
                    
                </div>						
            </div>
            
        </div>
               				
   </div>       
   <div class="col-md-12">    
        <div class="col-md-8">

        </div>
        <div class="col-md-4">
            <!--
             <button type="button" id="btnNaoAtendidos" name="btnNaoAtendidos" onclick="carregaGridContato('N')" class=" btn btn-primary col-md-6">
             Não Atendidos
             </button> 
             <button type="button" id="btnAtendidos" name="btnAtendidos" onclick="carregaGridContato('A')" class=" btn btn-success col-md-6">
             Atendidos
             </button> 
            -->
        </div> 
   
       <br /><br /><br /><br />
   <input class="form-control hide" id="edtIDContato" name="edtIDContato" type="text" />
   <table id="listContato" class="display col-md-12  table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Cód</th>
                <th>Nome</th>
                <th>Fantasia</th>
                <th>Telefone</th>
                <th>Celular</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Cód</th> 
                <th>Nome</th>
                <th>Fantasia</th>
                <th>Telefone</th>
                <th>Celular</th>
                <th>Status</th>
                <th></th>
              
            </tr>
        </tfoot>
    </table>
   </div>
   <script src="js/jquery.1.12.4.js" type="text/javascript"></script>   
   <script src="js/jquery.dataTables.min.js" type="text/javascript"></script>
  
   <script>
      
       $(document).ready(function() {
          carregaGridContato('T');   
          
            
          
        } ); 
      //  var caminho;
        
        function carregaGridContato(statusAtendimento)
        {
            
            
            if(statusAtendimento=='A')
            {
                caminho = 'json_contato.php?statusAtendimento=A';
            }
            else if(statusAtendimento=='N')
            {
                caminho = 'json_contato.php?statusAtendimento=N';
            }
            else if(statusAtendimento=='T')
            {
                caminho = 'json_contato.php';
            }
            //alert(caminho);
            var listaContato = $('#listContato').DataTable( {
                "ajax": 'json_contato.php?statusAtendimento=T',               
                "columns": [
                    
                    { "data": "ID", "targets": 0 },
                    { "data": "NOME" },
                    { "data": "FANTASIA" },
                    { "data": "TELEFONE" },
                    { "data": "CELULAR" },
                    { "data": "STATUS" },
                    {                       
                        "DATA":           "ID", 
                        "mData": "ID" ,
                       // "mData" "ID",
                        //"mRender":"<a id='btnPesquisar' onclick='visContato("+data['ID']+")' href='#'></a>"
                        "mRender": function ( data, type, row ) {
                         //return row.field.name +' '+ row.ID;
                         return "<a href='#modal-visContato' data-toggle='modal'  id='btnPesquisar' onclick='visContato("+data+")' href='#'></a>";
                        }  
                        
                            
                    }
                    
                          ]
            } );     
           
            
        }
         
       
        
        function visContato(idContato2)
        {       
            
            $.ajax({			  
            url: "Class/retornaContato.php",
            cache:false,	
            method:"post",
            data:{idContato:idContato2},
            dataType: "json",			  		  			  
            error:function(){	
                
                    alert('Erro');	
                    },
            success: function(retorno){			 
                    if (retorno[0].erro){	
                                    
                                  alert(retorno[0].erro);
                           }
                    else{   
                        
                           $('#edtIDContato').val(retorno[0].ID);
                           $('#txtNome').val(retorno[0].NOME);
                           $('#txtEmpresa').val(retorno[0].FANTASIA);
                           $('#txtContato').val(retorno[0].NOME_CONTATO);
                           $('#txtSite').val((retorno[0].SITE));
                           $('#txtTelefone').val((retorno[0].TELEFONE));
                           $('#txtCelular').val((retorno[0].CELULAR));
                           $('#txtEmail').val((retorno[0].EMAIL));                           
                        }
                    }
          });
        }
   </script>
  </body>
</html>