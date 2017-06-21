<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Contato</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
</head>

<body>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-2">
		</div>
		<div class="col-md-8">
                    <form role="form">
				<div class="form-group col-md-12">
					 
					<label >
						Nome:
					</label>
					<input class="form-control" id="edtNome" name="edtNome" type="text" />
				</div> 
                <div class="form-group col-md-12">
					 
					<label >
						Nome Empresa:
					</label>
					<input class="form-control" id="edtEmpresa" name="edtEmpresa" type="text" />
				</div> 
                <div class="form-group col-md-12">
					 
					<label >
						Nome Contato:
					</label>
					<input class="form-control" id="edtContato" name="edtContato" type="text" />
				</div> 
                <div class="form-group col-md-6">
					 
					<label >
						Telefone:
					</label>
                    <input class="form-control" id="edtTelefone" name="edtTelefone" type="tel" />
				</div> 
                <div class="form-group col-md-6">
					 
					<label >
						Celular:
					</label>
                    <input class="form-control" id="edtCelular" name="edtCelular" type="tel" />
				</div> 
                <div class="form-group col-md-12">
					 
					<label >
						Email:
					</label>
					<input class="form-control" id="edtEmail" name="edtEmail" type="email" />
				</div> 
                <div class="form-group col-md-12">
					 
					<label >
					Site:
					</label>
					<input class="form-control" id="edtSite" name="edtSite" type="text" />
				</div> 
                
				<div class="form-group col-md-12">
				               
                    <button type="button" id="btnEnviar" class="btn-success btn  col-md-12">
                        Enviar
                    </button>
                </div>
			</form>
		</div>
		<div class="col-md-2">
		</div>
	</div>
</div>
<script src="js/jquery.min.js"></script>
<script>
    $("#btnEnviar").click(function(){
        
        var erro=0;
        if($("#edtNome").val() == "")
        {
          alert("Digite um nome!");                
          $("#edtNome").focus();
          erro=1;
        } 
        else if($("#edtEmpresa").val() == "")
        {
          alert("Digite o nome da empresa!");                
          $("#edtEmpresa").focus();
          erro=1;
        } 
        else if($("#edtContato").val() == "")
        {
          alert("Digite um contato!");                
          $("#edtContato").focus();
          erro=1;
        } 
        else if($("#edtTelefone").val() == "")
        {
          alert("Digite um telefone!");                
          $("#edtTelefone").focus();               
          erro=1;
        } 
        else if($("#edtCelular").val() == "")
        {
          alert("Digite um celular!");                
          $("#edtCelular").focus();                
          erro=1;
        }         
        if(erro == 0)
        {
          enviarContato();  
          
        }
        
    });
    
    function enviarContato()
    {
        
        $.ajax({			  
        url: "Class/Contato.php",
        cache:false,				  
        dataType: "json",	
        method:"post",
        data:{nome:$('#edtNome').val(),empresa:$('#edtEmpresa').val(),contato:$('#edtContato').val(),telefone:$('#edtTelefone').val(),celular:$('#edtCelular').val(),email:$('#edtEmail').val(),site:$('#edtSite').val()},
        error:function(){				  
                alert("Erro!");
                },
        success: function(retorno){			                       
                      if (retorno.retorno=="1")
                      {
                              alert("Enviado com Sucesso!");
                              limparForm();					
                      }
                      else
                      {
                              alert(retorno.retorno);
                      }
                }
        });
    }
    function limparForm()
    {
        $("#edtNome").val("");
        $("#edtContato").val("");
        $("#edtCelular").val("");
        $("#edtEmail").val("");
        $("#edtEmpresa").val("");
        $("#edtTelefone").val("");
        $("#edtSite").val("");
        $("#edtNome").focus();
    }
</script>
</body>
</html>
