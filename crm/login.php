<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Painel Admin</title>

    <meta name="description" content="Source code generated using layoutit.com">
    <meta name="author" content="LayoutIt!">

    <link href="css/bootstrap.min.css" rel="stylesheet">
   
<style>
		body{
			background:#e5e5e5;
			}
	</style>
  </head>
  <body>
      <br/><br/><br/><br/><br/>
      
       <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-4" id="panel-login">
                <div class="row">
                    <div class="col-md-12">
                     <center>	                    	
                        <div class="row" id="logo">
                            <!--
                            <div class="col-md-12">
                                <img alt="Logotipo" height="90" width="270" src="images/logo.png" />
                            </div>
                            -->
                        </div>
                        <h4>ACESSO AO SISTEMA</h4>
                      </center>
                        
                        
                    </div>
                </div>
                <div class="row"  >
                    <div class="col-md-12" style="padding:10px;">
                        <form role="form" class="form-control-static" id="formLoginSenha" action="Class/efetuaLogin.php" method="post">
                              <div class="form-group">
                                <label class="sr-only" for="exampleInputAmount">jose@email.com.br</label>
                                <div class="input-group">
                                  <div class="input-group-addon"><img alt="Logotipo" width="20" height="20" src="images/icon-user.png" /></div>
                                  <input type="text" class="form-control" id="txtLogin" name="txtLogin" placeholder="Usuário">                                  
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="input-group">
                                  <div class="input-group-addon"><img alt="Logotipo"  width="20" height="20" src="images/icon-pass.png" /></div>
                                  <input type="password" class="form-control" id="txtSenha" name="txtSenha" placeholder="Senha">                                  
                                </div>
                              </div>
                            
                           
                            <button type="submit" class="btn btn-primary col-md-12">
                                ACESSAR
                            </button>
                        </form><br /><br />
                          <?php 
                            if(isset($_GET['erro']))
                            {	
                                  if($_GET['erro']==1)
                                  {
                                          echo "<script>alert('Login ou Senha invalidos!');</script>";								
                                  }		
                            }
                          ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>
  </body>
</html>