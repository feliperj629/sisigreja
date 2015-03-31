<?php session_start();

session_destroy();

$erro = $_REQUEST[erro]; 

if($erro == 1){
		$html = "<div class='alert alert-warning alert-dismissible' role='alert'>
  <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>
  <strong>ERRO!</strong> Login é Obrigatório! </div>";
	}

?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Igreja Chama Viva</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
   <link href="css/login.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	
	
  </head>
  <body>
  
  
  <div class="wrapper">
  
    <form class="form-signin" method="POST" action="login.php">    

     <img src="img/logo.jpg" class="img-responsive" alt="Responsive image">
      <input type="text" class="form-control" name="login" placeholder="Login" required="" autofocus="" />
      <input type="password" class="form-control" name="senha" placeholder="Senha" required=""/>  
	  <?php echo $html;?>	
		<div class="checkbox">
            <label>
                <input name="remember" type="checkbox" value="Remember Me">Mantenha-me conectado
			</label>
        </div>	  
		<div id="alert_placeholder"></div>	  
      <label >
       
      </label>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>  
		
		
		<div align="center">
		<p class="small">Acesse pelo celular</p>
		<img src="img/qrcode.png" class="img-responsive" alt="Responsive image">	
		</div>	  
    </form>
  </div>




<p class="text-center">Sistema - Deus V 0.01</p>







    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
	
	

<script>
  function showalert(message,alerttype) 
	{  
    $('#alert_placeholder').append('<div id="alertdiv" class="alert ' +  alerttype + '"><a class="close" data-dismiss="alert">X</a><span>'+message+'</span></div>');
    setTimeout(function() {
	// this will automatically close the alert and remove this if the users doesnt close it in 5 secs
      $("#alertdiv").remove();
	  }, 5000);
	} $(document).ready(function() {
				<?php if ($_REQUEST['e']==1)
				{
					echo 'showalert("Usu&aacute;rio ou senha inv&aacute;lidos.","alert-danger");';
				}?>
				<?php if ($_REQUEST['e']==2)
				{
					echo 'showalert("Sess&atilde;o expirou.","alert-danger");';
				}?>
			} );

			function novo()
			{

			}		

			function showExcluir()
			{
				$('#myModal').modal({
  					keyboard: true
				})
			}
			function excluir()
			{
				$('#myModal').modal('hide');
				showalert("Deleted","alert-error");
			  	//$('#myModal').modal();
			}		
		
			
		</script>

  </body>
</html>