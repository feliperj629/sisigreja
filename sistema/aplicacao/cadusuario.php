<?php session_start();

//error_reporting(E_ALL);
//ini_set('display_errors','1');

require_once("../include/seguranca.php"); 
require_once('../classes/usuario.class.php');
require_once('../classes/cadastro.class.php');
require_once('../classes/banco.class.php');


	$id_acesso = $_SESSION['id_acesso'];	
	$res = $_REQUEST['res'];
   
	
	
		
	if($res == SI){
	$MSG = '<strong>ERRO!</strong> Senha Atual Incorreta!';
	$COR = 	'warning';
	}if($res == AI){
	$MSG = '<strong>Parabéns!</strong> Alteração realizada com sucesso!';
	$COR = 	'info';
	}if($res == NA){
	$MSG = '<strong>ERRO!</strong> Alteração Não foi realizada!';
	$COR = 	'warning';
	}





	$clConexao = new Conexao;
	$conn = $clConexao->conecta();

	$Usuario = new Usuario;
	$Usuario->banco;
	
	$cadastro = new Cadastro;
	$cadastro->banco;
	
	$op = $_REQUEST['op'];
	$id_user = $_REQUEST['id'];
	
	if (($op == A) && (!empty($id_user)))
   {
   
   
       $Usuario->getById($id_user);	 
	   
	   $id_usuario = $Usuario->id_usuario;
	   $nome_user = $Usuario->nome_usuario;
	   $login = $Usuario->login;
	   $senha = $Usuario->senha;
	   $telefone = $Usuario->telefone;
	   $celular = $Usuario->celular;
	   $email = $Usuario->email;
	   $id_igreja_usuario = $Usuario->id_igreja_usuario;
	   $perfil = $Usuario->id_tipo_acesso;
	   
	   $id_tipo_acesso = $Usuario->id_tipo_acesso;
			
	}
	

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">

	<title>Chama Viva - Usuario Sistema</title>

<!-- Bootstrap Core CSS -->
<link href="../css/bootstrap.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="../css/sb-admin.css" rel="stylesheet">

<!-- Morris Charts CSS -->
<link href="../css/plugins/morris.css" rel="stylesheet">

<!-- Custom Fonts -->
<link href="../font-awesome-4.1.0/css/font-awesome.css" rel="stylesheet" type="text/css">




</head>

<body>

<div id="page-wrapper">
   
	
	<!-- MENSAGEM DE RESPOSTA AO GRAVAR-->
	<?php if(!empty($MSG)){?>	
	<div class='alert alert-<?php echo $COR;?> alert-dismissible' role='alert'>
		<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>
		   <?php echo $MSG;?>
	</div>
	<?php } ?>
	
	
	<div id="myModal" class="modal fade">
			
		  <div class="modal-dialog"> 
			<div class="modal-content"> 
			  <!-- dialog body -->
			  <div class="modal-body"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				Excluir o(s) registro(s)? </div>
			  <!-- dialog buttons -->
			  <div class="modal-footer"> 
				<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
				<button type="button" class="btn btn-danger" onClick="excluir()">Excluir</button>
			  </div>
			</div>
		  </div>
		  
	</div>
	
<div class="intro-header">	
 
<div class="panel panel-default "> 
<?php require("topo.php");?>
	<div class="container">		
					<div class="row">
						<div class="col-lg-12">
							<h2 class="page-header">
							<span class="glyphicon glyphicon-user"></span> Dados do Usuario <small></small>
							</h2>
                    </div>
					</div>
	</div>
	<!-- Contact with Map - START -->
    <div class="container">
      <div class="row">
	    <div class="col-md-12">
		
			<!-- Botoes de Cima-->
		<div class="well well-sm">
		
	<form role="form" name="frm2" id="frm2"  method="post" action="exec.usuario.php">
	<input type="hidden" name="op" id="op" value="<?php echo $op;?>">
	<input type="hidden" name="edtid" id="edtid" value="<?php echo $id_usuario;?>">
    <input type="hidden" name="fechar" id="fechar" value="">
			<div class="panel-heading"> 
              <div class="btn-group"> 
                <button type="button" class="btn btn-default" onClick="salvarFechar()"> 
                <span class="glyphicon glyphicon-floppy-disk"></span> Salvar</button>
				
			
				<!--
				<button type="button" class="btn btn-default" onClick="inicio()"> 
                <span class="glyphicon glyphicon-home"></span> Inicio</button>
               
                <button type="button" class="btn btn-default" onClick="showExcluir()"> 
                <span class="glyphicon glyphicon-minus"></span> Excluir</button>
				
				<button type="button" class="btn btn-default" onClick="voltar();"> 
                <span class="glyphicon glyphicon-chevron-left"></span> Voltar</button>
				-->
              </div>
       			
            </div>
			
			
				
		</div>
		
			<!-- FIM ---------- Botoes de Cima-->
            

    <div class="col-md-12">
		   
			<div class="row">

               
  <div class="form-group">
   <div class="row"> 
   

   
    <div class="col-lg-6"> 	   
    <label class="ccontrol-label">Nome:</label>
	
      <input type="text" class="form-control" id="edtnome" name="edtnome"  value="<?php echo $nome_user; ?>"  >
    </div>
 <div class="col-lg-6"> 	   
    <label  class=" control-label">Email:</label>
    
      <input type="email" class="form-control"  id="edtemail" name="edtemail" value="<?php  echo $email; ?>"   >
    </div>
	</div>
  </div>
   <div class="form-group">
      <div class="row"> 
	  
   <div class="col-lg-6"> 	   
    <label  class=" control-label">Telefone:</label>
 
                    <input id="edttelefone" name="edttelefone" type="text"  class="form-control" onKeyPress="MascaraTelefone(form.tel);" maxlength="14"  onBlur="ValidaTelefone(form.tel);" value="<?php echo $telefone;?>">    </div>
  <div class="col-lg-6"> 	   
    <label  class=" control-label">Celular:</label>
     <input id="edtcelular" name="edtcelular" type="text"  class="form-control" onKeyPress="MascaraTelefone(form.cel);" maxlength="14"  onBlur="ValidaTelefone(form.cel);" value="<?php echo $celular;?>">    </div>
 
    </div>
	</div>
  </div>
     <?php /*Acesso apenas para os adms*/ 
	 if(($id_acesso == 1) || ($id_acesso == 2) || ($id_acesso == 3)) { ?>
	<div class="row">	   
		<div class="form-group">
		
			<div class="col-lg-6"> 
				<label  class=" control-label">Perfil:</label>	  
				<?php echo $Usuario->listaPerfil('edtidperfil',$perfil,'N','class="form-control"');?>	
			</div>
			<div class="col-lg-6"> 
				<label  class=" control-label">Igreja:</label>	 
				<?php echo $Usuario->listaIgreja('edtidigreja',$id_igreja_usuario,'N','class="form-control"');?>
			</div>
		</div>
	</div>
	<?php } ?>
	
	<div class="row">		
		<div class="form-group">
			<div class="col-lg-4"> 
				<label  class=" control-label">Login:</label>	   
				<input type="text" class="form-control" id="edtlogin" name="edtlogin" value="<?php  echo $login; ?>">
			</div>
			<div class="col-lg-4">
			
				<label  class=" control-label">Senha Atual:</label>
				<input type="password" class="form-control" id="edtsenhaatual"  name="edtsenhaatual" value="<?php // echo $senha; ?>">
			
				<label  class=" control-label">Nova Senha:</label>
				<input type="password" class="form-control" id="edtsenhanova"  name="edtsenhanova" value="<?php // echo $senha; ?>">
			</div>
			
		
		</div>
	</div>		
</div>
</form>
</div>
</div>
</div>
	
  
  </div>
  </div>
</div>

<!-- jQuery Version 1.11.0 --> 
<script src="../js/jquery-1.11.0.js"></script> 

<!-- Bootstrap Core JavaScript --> 
<script src="../js/bootstrap.min.js"></script> 

</body>
</html>